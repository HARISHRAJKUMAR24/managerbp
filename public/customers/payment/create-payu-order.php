<?php
// managerbp/public/customers/payment/create-payu-order.php

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";
require_once "../../../src/functions.php";

$pdo = getDbConnection();
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

try {
    $user_id       = intval($data['user_id']);
    $customer_id   = intval($data['customer_id']);
    $amount        = floatval($data['total_amount']);
    $name          = trim($data['customer_name'] ?? "Customer");
    $email         = trim($data['customer_email'] ?? "");
    $phone         = trim($data['customer_phone'] ?? "");
    
    // Extract appointment details
    $appointment_date = $data['appointment_date'] ?? null;
    $slot_from        = $data['slot_from'] ?? null;
    $slot_to          = $data['slot_to'] ?? null;
    $token_count      = intval($data['token_count'] ?? 1);
    
    // Extract service information
    $service_type     = $data['service_type'] ?? 'category';
    $category_id      = $data['category_id'] ?? null;
    $service_name     = $data['service_name'] ?? '';
    
    // Extract batch_id
    $batch_id         = $data['batch_id'] ?? null;
    
    // Extract GST Details
    $gst_type        = $data['gst_type'] ?? '';
    $gst_percent     = floatval($data['gst_percent'] ?? 0);
    $gst_amount      = floatval($data['gst_amount'] ?? 0);
    $sub_total       = floatval($data['amount'] ?? $amount); // Subtotal without GST

    $appointment_id = generateAppointmentId($user_id, $pdo);
    
    // Generate receipt
    $receipt = "receipt_" . $customer_id . "_" . time();
    
    // ⭐ GET SERVICE INFORMATION FOR JSON STORAGE
    $serviceInfo = getServiceInformation($pdo, $user_id, $service_type, $category_id, $service_name);
    
    // Debug log
    error_log("PayU Create - Service Info: " . json_encode($serviceInfo));
    
    if (!$serviceInfo || !isset($serviceInfo['success']) || !$serviceInfo['success']) {
        error_log("Service info error: " . ($serviceInfo['message'] ?? 'Unknown error'));
        
        // Fallback service info
        $serviceInfo = [
            "reference_id" => $category_id ?? 'GENERIC_' . $user_id,
            "reference_type" => $category_id ? 'category_id' : 'generic_service',
            "service_name_json" => json_encode([
                "type" => "generic",
                "service_name" => $service_name ?: "Service Booking",
                "service_type" => "PayU Payment"
            ]),
            "service_name_display" => $service_name ?: "Service Booking"
        ];
    }
    
    // ⭐ FIX: INSERT WITH ALL APPOINTMENT DETAILS
    $stmt = $pdo->prepare("
        INSERT INTO customer_payment 
        (user_id, customer_id, appointment_id, receipt, amount, total_amount, currency, 
         status, payment_method, appointment_date, slot_from, slot_to, token_count,
         service_reference_id, service_reference_type, service_name,
         gst_type, gst_percent, gst_amount, batch_id, created_at)
        VALUES (?, ?, ?, ?, ?, ?, 'INR', 'pending', 'payu', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    
    // Debug: Log what we're inserting
    error_log("PayU Inserting with slot_from: $slot_from, slot_to: $slot_to, batch_id: $batch_id");
    
    $success = $stmt->execute([
        $user_id,
        $customer_id,
        $appointment_id,
        $receipt,
        $sub_total,       // amount (without GST)
        $amount,          // total_amount (with GST)
        $appointment_date, // ⭐ FIXED: This was missing in execute array
        $slot_from,       // ⭐ FIXED: This was missing in execute array
        $slot_to,         // ⭐ FIXED: This was missing in execute array
        $token_count,     // ⭐ FIXED: This was missing in execute array
        $serviceInfo['reference_id'],       // CAT_xxx or department_id
        $serviceInfo['reference_type'],     // category_id or department_id
        $serviceInfo['service_name_json'],  // ⭐ JSON format
        $gst_type,
        $gst_percent,
        $gst_amount,
        $batch_id         // ⭐ FIXED: This was at wrong position
    ]);

    if (!$success) {
        $errorInfo = $stmt->errorInfo();
        error_log("PayU Insert error: " . json_encode($errorInfo));
        throw new Exception("Database insert failed: " . ($errorInfo[2] ?? 'Unknown error'));
    }

    $payment_id = $pdo->lastInsertId();

    // Verify the record was created
    $checkStmt = $pdo->prepare("SELECT id, appointment_date, slot_from, slot_to, batch_id, service_name FROM customer_payment WHERE id = ?");
    $checkStmt->execute([$payment_id]);
    $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    error_log("PayU Record created - ID: " . $payment_id . 
              ", slot_from: " . ($checkResult['slot_from'] ?? 'NULL') . 
              ", slot_to: " . ($checkResult['slot_to'] ?? 'NULL') . 
              ", batch_id: " . ($checkResult['batch_id'] ?? 'NULL'));

    // Fetch PayU credentials
    $stmt = $pdo->prepare("
        SELECT payu_api_key, payu_salt 
        FROM site_settings 
        WHERE user_id = ? LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $cred = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cred || empty($cred['payu_api_key']) || empty($cred['payu_salt'])) {
        throw new Exception("PayU is not configured for this seller");
    }

    $merchantKey = trim($cred['payu_api_key']);
    $salt        = trim($cred['payu_salt']);

    // Generate transaction ID
    $txnid = "TXN" . time() . rand(1000, 9999);
    $amountFormatted = number_format($amount, 2, '.', '');
    $productinfo = "Booking Payment";

    // Parse service info for display
    $serviceDisplay = $serviceInfo['service_name_display'];
    if ($serviceInfo['service_name_json']) {
        try {
            $serviceJson = json_decode($serviceInfo['service_name_json'], true);
            if (isset($serviceJson['doctor_name'])) {
                $serviceDisplay = $serviceJson['doctor_name'];
            } elseif (isset($serviceJson['department_name'])) {
                $serviceDisplay = $serviceJson['department_name'];
            } elseif (isset($serviceJson['service_name'])) {
                $serviceDisplay = $serviceJson['service_name'];
            }
        } catch (Exception $e) {
            error_log("Error parsing service JSON: " . $e->getMessage());
        }
    }

    // UDF fields - include ALL appointment details in JSON
    $udf1 = $appointment_id;      // appointment ID
    $udf2 = $customer_id;         // customer ID
    $udf3 = $user_id;             // user ID
    $udf4 = $appointment_date;    // appointment date
    $udf5 = json_encode([         // all details as JSON
        'slot_from' => $slot_from,
        'slot_to' => $slot_to,
        'token_count' => $token_count,
        'category_id' => $category_id,
        'batch_id' => $batch_id,
        'receipt' => $receipt,
        'gst_type' => $gst_type,
        'gst_percent' => $gst_percent,
        'gst_amount' => $gst_amount,
        'sub_total' => $sub_total,
        'payment_id' => $payment_id,
        'service_info' => [       // ⭐ ADD SERVICE INFO
            'reference_id' => $serviceInfo['reference_id'],
            'reference_type' => $serviceInfo['reference_type'],
            'display_name' => $serviceDisplay,
            'service_type' => $service_type
        ]
    ]);

    // PayU Hash Format
    $hashString =
        $merchantKey . "|" .
        $txnid . "|" .
        $amountFormatted . "|" .
        $productinfo . "|" .
        $name . "|" .
        $email . "|" .
        $udf1 . "|" .
        $udf2 . "|" .
        $udf3 . "|" .
        $udf4 . "|" .
        $udf5 . "|" .
        "" . "|" . "" . "|" . "" . "|" . "" . "|" . "" . "|" .
        $salt;

    $hash = strtolower(hash("sha512", $hashString));

    // Store txnid for later update
    $updateStmt = $pdo->prepare("
        UPDATE customer_payment 
        SET payment_id = ?
        WHERE appointment_id = ? AND user_id = ?
    ");
    $updateStmt->execute([$txnid, $appointment_id, $user_id]);

    // Browser-based redirect
    $surl = "http://localhost/managerbp/public/customers/payment/payu-success.php";
    $furl = "http://localhost/managerbp/public/customers/payment/payu-failure.php";

    echo json_encode([
        "success"       => true,
        "endpoint"      => "https://test.payu.in/_payment",
        "key"           => $merchantKey,
        "txnid"         => $txnid,
        "amount"        => $amountFormatted,
        "productinfo"   => $productinfo,
        "firstname"     => $name,
        "email"         => $email,
        "phone"         => $phone,
        "surl"          => $surl,
        "furl"          => $furl,
        "hash"          => $hash,
        "service_provider" => "payu_paisa",

        // Pass all appointment details
        "udf1" => $udf1,  // appointment_id
        "udf2" => $udf2,  // customer_id
        "udf3" => $udf3,  // user_id
        "udf4" => $udf4,  // appointment_date
        "udf5" => $udf5,  // ALL details JSON
        
        // Return service info for frontend
        "service_info" => [
            "reference_id" => $serviceInfo['reference_id'],
            "reference_type" => $serviceInfo['reference_type'],
            "display_name" => $serviceDisplay,
            "service_type" => $service_type
        ],
        
        // Debug info
        "debug" => [
            "slot_from" => $slot_from,
            "slot_to" => $slot_to,
            "batch_id" => $batch_id,
            "appointment_date" => $appointment_date
        ]
    ]);

} catch (Exception $e) {
    error_log("PayU Create Error: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>