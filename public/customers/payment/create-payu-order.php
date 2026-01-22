<?php
// managerbp/public/customers/payment/create-payu-order.php

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

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

$db = getDbConnection();

try {
    // Basic validation
    $user_id = intval($input['user_id'] ?? 0);
    $customer_id = intval($input['customer_id'] ?? 0);
    $total_amount = floatval($input['total_amount'] ?? 0);
    
    if ($user_id <= 0 || $customer_id <= 0 || $total_amount <= 0) {
        throw new Exception("Invalid input parameters");
    }
    
    // Generate appointment ID
    $appointment_id = generateAppointmentId($user_id, $db);
    
    // Customer details
    $customer_name = trim($input['customer_name'] ?? 'Customer');
    $customer_email = trim($input['customer_email'] ?? '');
    $customer_phone = trim($input['customer_phone'] ?? '');
    
    // Get PayU credentials
    $stmt = $db->prepare("
        SELECT payu_api_key, payu_salt 
        FROM site_settings 
        WHERE user_id = ? 
        LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$settings || empty($settings['payu_api_key']) || empty($settings['payu_salt'])) {
        throw new Exception("PayU is not configured for this seller");
    }
    
    $merchantKey = trim($settings['payu_api_key']);
    $salt = trim($settings['payu_salt']);
    
    // Generate transaction ID
    $txnid = 'TXN' . $user_id . time() . rand(1000, 9999);
    
    // Product info
    $productinfo = "Booking Payment for " . substr($customer_name, 0, 30);
    
    // Format amount
    $amountFormatted = number_format($total_amount, 2, '.', '');
    
    // UDF fields
    $udf1 = $appointment_id;  // Appointment ID
    $udf2 = (string)$customer_id;  // Customer ID
    $udf3 = (string)$user_id;  // User ID
    
    // SIMPLE HASH CALCULATION - PayU Standard Format
    $hashString = $merchantKey . '|' . 
                  $txnid . '|' . 
                  $amountFormatted . '|' . 
                  $productinfo . '|' . 
                  $customer_name . '|' . 
                  $customer_email . '|||||||||||' . 
                  $salt;
    
    $hash = hash('sha512', $hashString);
    
    // Store pending payment (optional)
    $checkTable = $db->query("SHOW TABLES LIKE 'pending_payments'")->fetch();
    if ($checkTable) {
        $stmt = $db->prepare("
            INSERT INTO pending_payments 
            (user_id, customer_id, appointment_id, txnid, amount, status) 
            VALUES (?, ?, ?, ?, ?, 'initiated')
        ");
        $stmt->execute([$user_id, $customer_id, $appointment_id, $txnid, $total_amount]);
    }
    
    // URLs
    $backend_url = "http://localhost";
    $surl = $backend_url . "/managerbp/public/customers/payment/payu-success.php";
    $furl = $backend_url . "/managerbp/public/customers/payment/payu-failure.php";
    
    // PayU endpoint (use test for development)
    $payuEndpoint = "https://test.payu.in/_payment";
    
    // Response
    $response = [
        "success" => true,
        "message" => "PayU order created",
        "endpoint" => $payuEndpoint,
        "key" => $merchantKey,
        "txnid" => $txnid,
        "amount" => $amountFormatted,
        "productinfo" => $productinfo,
        "firstname" => $customer_name,
        "email" => $customer_email,
        "phone" => $customer_phone,
        "surl" => $surl,
        "furl" => $furl,
        "hash" => $hash,
        "service_provider" => "payu_paisa",
        // UDF fields
        "udf1" => $udf1,
        "udf2" => $udf2,
        "udf3" => $udf3,
        // For frontend
        "appointment_id" => $appointment_id,
        "transaction_id" => $txnid
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false, 
        "message" => $e->getMessage()
    ]);
}
?>