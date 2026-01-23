<?php
require_once "../../../src/functions.php";

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
    
    // ⭐ Extract appointment details
    $appointment_date = $data['appointment_date'] ?? null;
    $slot_from        = $data['slot_from'] ?? null;
    $slot_to          = $data['slot_to'] ?? null;
    $token_count      = intval($data['token_count'] ?? 1);
    
    // ⭐ NEW: Extract category_id
    $category_id      = $data['category_id'] ?? null;
    
    // ⭐ NEW: Extract GST Details (same as Razorpay)
    $gst_type        = $data['gst_type'] ?? '';
    $gst_percent     = floatval($data['gst_percent'] ?? 0);
    $gst_amount      = floatval($data['gst_amount'] ?? 0);
    $sub_total       = floatval($data['amount'] ?? $amount); // Subtotal without GST

    $appointment_id = generateAppointmentId($user_id, $pdo);
    
    // Store appointment details in database BEFORE PayU order
    $stmt = $pdo->prepare("
        INSERT INTO customer_payment 
        (user_id, customer_id, appointment_id, amount, total_amount, currency, 
         status, payment_method, appointment_date, slot_from, slot_to, token_count,
         service_reference_id, service_reference_type, service_name,
         gst_type, gst_percent, gst_amount, created_at)
        VALUES (?, ?, ?, ?, ?, 'INR', 'pending', 'payu', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    
    // Get category details if category_id provided
    $service_ref_id = null;
    $service_ref_type = null;
    $service_name = null;
    
    if ($category_id) {
        $catStmt = $pdo->prepare("
            SELECT category_id, name, doctor_name 
            FROM categories 
            WHERE category_id = ? 
            AND user_id = ?
            LIMIT 1
        ");
        $catStmt->execute([$category_id, $user_id]);
        $category = $catStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($category) {
            $service_ref_id = $category['category_id']; // CAT_xxx
            $service_ref_type = 'category_id';
            $service_name = $category['doctor_name'] ?? $category['name'];
        }
    }
    
    $stmt->execute([
        $user_id,
        $customer_id,
        $appointment_id,
        $sub_total,          // Amount without GST
        $amount,             // Total amount with GST
        $appointment_date,
        $slot_from,
        $slot_to,
        $token_count,
        $service_ref_id,
        $service_ref_type,
        $service_name,
        $gst_type,
        $gst_percent,
        $gst_amount
    ]);

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

    // UDF fields - include all appointment details AND category_id AND GST
    $udf1 = $appointment_id;      // appointment ID
    $udf2 = $customer_id;         // customer ID
    $udf3 = $user_id;             // user ID
    $udf4 = $appointment_date;    // appointment date
    $udf5 = json_encode([         // all details as JSON
        'slot_from' => $slot_from,
        'slot_to' => $slot_to,
        'token_count' => $token_count,
        'category_id' => $category_id,
        'gst_type' => $gst_type,
        'gst_percent' => $gst_percent,
        'gst_amount' => $gst_amount,
        'sub_total' => $sub_total
    ]);

    // ✔ Correct PayU Hash Format
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

    // Browser-based redirect (works on localhost)
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
        "udf5" => $udf5   // slot details + category_id + GST JSON
    ]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>