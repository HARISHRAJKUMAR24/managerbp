<?php
// managerbp/public/customers/payment/verify-razorpay-payment.php

/* -------------------------------
   CORS SETTINGS
-------------------------------- */
$allowedOrigins = [
    "http://localhost:3000",
    "http://localhost:3001",
    "http://localhost"
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";
require_once "../../../src/functions.php";

/* -------------------------------
   READ INPUT
-------------------------------- */
$input = json_decode(file_get_contents("php://input"), true);

$required = [
    "razorpay_payment_id",
    "razorpay_order_id",
    "razorpay_signature"
];

foreach ($required as $field) {
    if (empty($input[$field])) {
        echo json_encode([
            "success" => false,
            "message" => "Missing field: $field"
        ]);
        exit;
    }
}

$razorpay_payment_id = $input["razorpay_payment_id"];
$razorpay_order_id   = $input["razorpay_order_id"];
$razorpay_signature  = $input["razorpay_signature"];

// Appointment details
$appointment_date = $input["appointment_date"] ?? null;
$slot_from        = $input["slot_from"] ?? null;
$slot_to          = $input["slot_to"] ?? null;
$token_count      = intval($input["token_count"] ?? 1);

// Service details
$category_id = $input["category_id"] ?? null;
$batch_id = $input["batch_id"] ?? null;

// Service type and name for JSON storage
$service_type = $input["service_type"] ?? 'category';
$service_name = $input["service_name"] ?? '';

$db = getDbConnection();

// Debug log
error_log("Verifying payment - Order ID: " . $razorpay_order_id);

/* -------------------------------
   FETCH ORDER FROM DB - FIXED QUERY
-------------------------------- */
$stmt = $db->prepare("
    SELECT * FROM customer_payment 
    WHERE payment_id = ? 
    AND status = 'pending'
    LIMIT 1
");
$stmt->execute([$razorpay_order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    // Try alternative search
    error_log("Order not found with payment_id: " . $razorpay_order_id);
    
    // Check if it's in receipt field
    $stmt2 = $db->prepare("SELECT * FROM customer_payment WHERE receipt LIKE ? AND status = 'pending' LIMIT 1");
    $stmt2->execute(["%" . $razorpay_order_id . "%"]);
    $order = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo json_encode([
            "success" => false,
            "message" => "Order not found in database. Order ID: " . $razorpay_order_id
        ]);
        exit;
    }
}

$user_id = $order["user_id"];
$customer_id = $order["customer_id"];
$db_payment_id = $order["id"]; // Database primary key

error_log("Found order - DB ID: " . $db_payment_id . ", User ID: " . $user_id);

/* -------------------------------
   GET SELLER RAZORPAY KEYS
-------------------------------- */
$stmt2 = $db->prepare("
    SELECT razorpay_key_id, razorpay_secret_key 
    FROM site_settings 
    WHERE user_id = ? LIMIT 1
");
$stmt2->execute([$user_id]);
$settings = $stmt2->fetch(PDO::FETCH_ASSOC);

if (!$settings) {
    echo json_encode([
        "success" => false,
        "message" => "Razorpay settings missing for seller"
    ]);
    exit;
}

$key_secret = $settings["razorpay_secret_key"];

/* -------------------------------
   VERIFY SIGNATURE
-------------------------------- */
$generated_signature = hash_hmac(
    "sha256",
    $razorpay_order_id . "|" . $razorpay_payment_id,
    $key_secret
);

error_log("Generated signature: " . $generated_signature);
error_log("Received signature: " . $razorpay_signature);

if ($generated_signature !== $razorpay_signature) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid signature - Payment tampered. Generated: " . $generated_signature . ", Received: " . $razorpay_signature
    ]);
    exit;
}

/* -------------------------------
   GET SERVICE INFORMATION FOR JSON STORAGE
-------------------------------- */
$serviceInfo = getServiceInformation($db, $user_id, $service_type, $category_id, $service_name);

// Debug: Check what getServiceInformation returns
error_log("Service Info Result: " . json_encode($serviceInfo));

if (!$serviceInfo || !isset($serviceInfo['success']) || !$serviceInfo['success']) {
    // Check if we already have service info in the order
    if (!empty($order["service_name"])) {
        error_log("Using existing service info from order");
        $serviceInfo = [
            "reference_id" => $order["service_reference_id"] ?? $category_id ?? 'GENERIC_' . $user_id,
            "reference_type" => $order["service_reference_type"] ?? ($category_id ? 'category_id' : 'generic_service'),
            "service_name_json" => $order["service_name"],
            "service_name_display" => "Service"
        ];
    } else {
        // Fallback to basic service info
        $serviceInfo = [
            "reference_id" => $category_id ?? 'GENERIC_' . $user_id,
            "reference_type" => $category_id ? 'category_id' : 'generic_service',
            "service_name_json" => json_encode([
                "type" => "service",
                "service_name" => $service_name ?: "Service Booking",
                "service_type" => "Appointment"
            ]),
            "service_name_display" => $service_name ?: "Service Booking"
        ];
    }
}

/* -------------------------------
   UPDATE PAYMENT WITH ALL DETAILS INCLUDING JSON SERVICE NAME - FIXED
-------------------------------- */
// Check what we're updating
error_log("Updating payment ID: " . $db_payment_id . " with service_name: " . $serviceInfo['service_name_json']);

$update = $db->prepare("
    UPDATE customer_payment 
    SET 
        payment_id = ?,
        signature = ?, 
        status = 'paid',
        appointment_date = ?,
        slot_from = ?,
        slot_to = ?,
        token_count = ?,
        batch_id = ?,
        service_reference_id = ?,
        service_reference_type = ?,
        service_name = ?
    WHERE id = ? AND status = 'pending'
");

$updateResult = $update->execute([
    $razorpay_payment_id,  // Store actual payment ID from Razorpay
    $razorpay_signature,
    $appointment_date,
    $slot_from,
    $slot_to,
    $token_count,
    $batch_id,
    $serviceInfo['reference_id'],
    $serviceInfo['reference_type'],
    $serviceInfo['service_name_json'], // Store JSON
    $db_payment_id  // Use database primary key
]);

if (!$updateResult) {
    $errorInfo = $update->errorInfo();
    error_log("Update failed: " . json_encode($errorInfo));
    echo json_encode([
        "success" => false,
        "message" => "Database update failed: " . ($errorInfo[2] ?? 'Unknown error')
    ]);
    exit;
}

$rowsUpdated = $update->rowCount();
error_log("Rows updated: " . $rowsUpdated);

if ($rowsUpdated === 0) {
    // Check if already paid
    $checkPaid = $db->prepare("SELECT status FROM customer_payment WHERE id = ?");
    $checkPaid->execute([$db_payment_id]);
    $paidStatus = $checkPaid->fetch(PDO::FETCH_ASSOC);
    
    if ($paidStatus && $paidStatus['status'] === 'paid') {
        echo json_encode([
            "success" => true,
            "message" => "Payment already verified earlier",
            "appointment_id" => $order["appointment_id"],
            "already_paid" => true
        ]);
        exit;
    }
}

/* -------------------------------
   UPDATE TOKEN AVAILABILITY FOR THIS BATCH
-------------------------------- */
$tokenUpdateMessage = null;
if ($batch_id && $appointment_date && $category_id) {
    try {
        // Extract day index and slot index from batch_id
        $batchParts = explode(':', $batch_id);
        if (count($batchParts) === 2) {
            $dayIndex = intval($batchParts[0]);
            $slotIndex = intval($batchParts[1]);
            
            // Convert appointment date to day name
            $dayName = date('D', strtotime($appointment_date));
            
            // Get doctor schedule
            $stmtDoctor = $db->prepare("
                SELECT weekly_schedule 
                FROM doctor_schedule 
                WHERE category_id = ? 
                AND user_id = ?
                LIMIT 1
            ");
            $stmtDoctor->execute([$category_id, $user_id]);
            $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);
            
            if ($doctor && $doctor['weekly_schedule']) {
                $weeklySchedule = json_decode($doctor['weekly_schedule'], true);
                
                if (isset($weeklySchedule[$dayName]['slots'][$slotIndex])) {
                    $currentTokens = intval($weeklySchedule[$dayName]['slots'][$slotIndex]['token'] ?? 0);
                    $newTokens = max(0, $currentTokens - $token_count);
                    $weeklySchedule[$dayName]['slots'][$slotIndex]['token'] = strval($newTokens);
                    
                    // Update the schedule
                    $updateSchedule = $db->prepare("
                        UPDATE doctor_schedule 
                        SET weekly_schedule = ? 
                        WHERE category_id = ? 
                        AND user_id = ?
                    ");
                    $updateSchedule->execute([
                        json_encode($weeklySchedule),
                        $category_id,
                        $user_id
                    ]);
                    
                    $tokenUpdateMessage = "Token availability updated: $currentTokens -> $newTokens";
                }
            }
        }
    } catch (Exception $e) {
        error_log("Token update error: " . $e->getMessage());
        $tokenUpdateMessage = "Token update failed: " . $e->getMessage();
    }
}

/* -------------------------------
   SUCCESS RESPONSE
-------------------------------- */
// Parse service info for response
$serviceDisplay = $service_name ?: "Service";
if (isset($serviceInfo['service_name_json'])) {
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

echo json_encode([
    "success" => true,
    "message" => "Payment verified successfully",
    "appointment_id" => $order["appointment_id"],
    "razorpay_payment_id" => $razorpay_payment_id,
    "db_payment_id" => $db_payment_id,
    "service_info" => [
        "reference_id" => $serviceInfo['reference_id'],
        "reference_type" => $serviceInfo['reference_type'],
        "service_name_json" => $serviceInfo['service_name_json'],
        "display_name" => $serviceInfo['service_name_display'] ?? $serviceDisplay
    ],
    "redirect_url" => "/payment-success",
    "stored_data" => [
        "appointment_date" => $appointment_date,
        "slot_from" => $slot_from,
        "slot_to" => $slot_to,
        "token_count" => $token_count,
        "category_id" => $category_id,
        "batch_id" => $batch_id,
        "service_type" => $service_type
    ],
    "token_update" => $tokenUpdateMessage ?? "No token update performed"
]);
exit;
?>