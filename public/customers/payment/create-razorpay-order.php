<?php
// managerbp/public/customers/payment/create-razorpay-order.php

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

/* -------------------------------
   LOAD DEPENDENCIES
-------------------------------- */
require_once "../../../config/config.php";
require_once "../../../src/database.php";

/* -------------------------------
   READ JSON INPUT
-------------------------------- */
$input = json_decode(file_get_contents("php://input"), true);

$required = ["amount", "currency", "user_id", "customer_id"];

foreach ($required as $field) {
    if (!isset($input[$field]) || $input[$field] === "") {
        echo json_encode([
            "success" => false,
            "message" => "Missing required field: $field"
        ]);
        exit;
    }
}

$amount          = floatval($input["amount"]) * 100;  // Razorpay uses paise
$currency        = $input["currency"];
$user_id         = intval($input["user_id"]);
$customer_id     = intval($input["customer_id"]);

// ⭐ FIX: Accept both appointment_id styles
$appointment_id  = $input["appointment_id"] ?? $input["appointmentId"] ?? null;

/* Validate appointment_id */
if (empty($appointment_id)) {
    echo json_encode([
        "success" => false,
        "message" => "appointment_id is missing!",
        "received" => $input
    ]);
    exit;
}

$customer_email  = $input["customer_email"] ?? "";
$customer_phone  = $input["customer_phone"] ?? "";

$receipt = "receipt_" . $customer_id . "_" . time();

/* -------------------------------
   GET RAZORPAY KEYS
-------------------------------- */
$db = getDbConnection();

$stmt = $db->prepare("SELECT razorpay_key_id, razorpay_secret_key 
                      FROM site_settings WHERE user_id = ? LIMIT 1");
$stmt->execute([$user_id]);
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$settings || empty($settings["razorpay_key_id"]) || empty($settings["razorpay_secret_key"])) {
    echo json_encode([
        "success" => false,
        "message" => "Razorpay keys missing in site_settings"
    ]);
    exit;
}

$key_id     = $settings["razorpay_key_id"];
$key_secret = $settings["razorpay_secret_key"];

/* -------------------------------
   CREATE RAZORPAY ORDER
-------------------------------- */
$orderData = [
    "amount" => $amount,
    "currency" => $currency,
    "receipt" => $receipt,
    "payment_capture" => 1,
    "notes" => [
        "user_id"        => $user_id,
        "customer_id"    => $customer_id,
        "appointment_id" => $appointment_id,
        "email"          => $customer_email,
        "phone"          => $customer_phone
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
curl_setopt($ch, CURLOPT_USERPWD, $key_id . ":" . $key_secret);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

/* -------------------------------
   SUCCESS
-------------------------------- */
if ($httpCode === 200) {

    $order = json_decode($response, true);

    // ⭐ Store Razorpay order_id into payment_id field (as you requested)
    $razorpay_order_id = $order["id"];

    $ins = $db->prepare("
        INSERT INTO customer_payment 
        (user_id, customer_id, appointment_id, payment_id, receipt, amount, currency, 
         gst_type, gst_percent, gst_amount, total_amount, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");

    $ins->execute([
        $user_id,
        $customer_id,
        $appointment_id,
        $razorpay_order_id,       // <-- storing order_id into payment_id
        $receipt,
        $input["amount"],         // ₹ amount
        $currency,
        $input["gst_type"] ?? "",
        $input["gst_percent"] ?? 0,
        $input["gst_amount"] ?? 0,
        $input["total_amount"] ?? 0
    ]);

    echo json_encode([
        "success" => true,
        "order"   => $order,
        "receipt" => $receipt
    ]);
    exit;
}

/* -------------------------------
   FAILURE
-------------------------------- */
$errorResponse = json_decode($response, true);

echo json_encode([
    "success" => false,
    "message" => $errorResponse["error"]["description"] ?? "Order creation failed",
    "http_code" => $httpCode
]);
exit;

?>
