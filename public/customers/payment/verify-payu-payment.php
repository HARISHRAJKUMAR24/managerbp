<?php
// managerbp/public/customers/payment/verify-payu-payment.php

$allowedOrigins = [
    "http://localhost:3000",
    "http://localhost:3001",
    "http://localhost"
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$db = getDbConnection();

$input = json_decode(file_get_contents("php://input"), true);

if (empty($input["transaction_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Transaction ID required"
    ]);
    exit;
}

$txnid = $input["transaction_id"];

// Check in customer_payment first
$stmt = $db->prepare("
    SELECT * FROM customer_payment 
    WHERE payment_id = ? 
    LIMIT 1
");
$stmt->execute([$txnid]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($payment) {
    // Payment already in database
    $response = [
        "success" => true,
        "payment" => [
            "transaction_id" => $payment['payment_id'],
            "appointment_id" => $payment['appointment_id'],
            "status" => $payment['status'],
            "amount" => $payment['amount'],
            "total_amount" => $payment['total_amount'],
            "currency" => $payment['currency'],
            "payment_method" => $payment['payment_method'] ?? 'payu'
        ]
    ];
    
    if ($payment['status'] === 'paid') {
        $response["message"] = "Payment verified successfully";
        $response["redirect_url"] = "/payment-success?appointment_id=" . $payment['appointment_id'];
    } else {
        $response["message"] = "Payment status: " . $payment['status'];
    }
    
    echo json_encode($response);
    exit;
}

// If not in customer_payment, check pending_payments
$stmt = $db->prepare("
    SELECT * FROM pending_payments 
    WHERE txnid = ? 
    LIMIT 1
");
$stmt->execute([$txnid]);
$pending = $stmt->fetch(PDO::FETCH_ASSOC);

if ($pending) {
    $response = [
        "success" => true,
        "payment" => [
            "transaction_id" => $pending['txnid'],
            "appointment_id" => $pending['appointment_id'],
            "status" => $pending['status'],
            "amount" => $pending['amount']
        ]
    ];
    
    if ($pending['status'] === 'completed') {
        $response["message"] = "Payment completed";
        $response["redirect_url"] = "/payment-success?appointment_id=" . $pending['appointment_id'];
    } else if ($pending['status'] === 'failed') {
        $response["message"] = "Payment failed";
        $response["redirect_url"] = "/payment-failed";
    } else {
        $response["message"] = "Payment is being processed";
    }
    
    echo json_encode($response);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Transaction not found"
    ]);
}
?>