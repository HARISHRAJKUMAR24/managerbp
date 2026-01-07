<?php
// managerbp/public/seller/payment/create-payu-order.php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* -------------------------------------------------
   Read JSON body
------------------------------------------------- */
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request data"
    ]);
    exit;
}

try {
    /* -------------------------------------------------
       1. Extract & validate request data
    ------------------------------------------------- */
    $amount       = (float) ($data['amount'] ?? 0);
    $currency     = $data['currency'] ?? 'INR';
    $plan_id      = $data['plan_id'] ?? null;
    $user_email   = trim($data['user_email'] ?? '');
    $user_phone   = trim($data['user_phone'] ?? '');
    $user_name    = trim($data['user_name'] ?? 'Customer');
    $billing_data = $data['billing_data'] ?? [];
    $plan_data    = $data['plan_data'] ?? [];

    if ($amount <= 0) {
        throw new Exception("Invalid amount");
    }

    if ($user_email === '') {
        $user_email = "customer@example.com";
    }

    /* -------------------------------------------------
       2. Fetch PayU credentials
    ------------------------------------------------- */
    $stmt = $pdo->prepare("
        SELECT payu_merchant_key, payu_salt
        FROM settings
        LIMIT 1
    ");
    $stmt->execute();
    $credentials = $stmt->fetch(PDO::FETCH_ASSOC);

    if (
        !$credentials ||
        empty($credentials['payu_merchant_key']) ||
        empty($credentials['payu_salt'])
    ) {
        throw new Exception("PayU credentials not configured");
    }

    $merchantKey = trim($credentials['payu_merchant_key']);
    $salt        = trim($credentials['payu_salt']);

    /* -------------------------------------------------
       3. Generate unique transaction ID
    ------------------------------------------------- */
    $txnid = substr(hash('sha256', uniqid(mt_rand(), true)), 0, 20);

    /* -------------------------------------------------
       4. Prepare PayU required fields
    ------------------------------------------------- */
    $productinfo = $plan_data['plan_name'] ?? 'Subscription Plan';
    $productinfo = str_replace('|', '', $productinfo);

    // Amount must be string with 2 decimals
    $amountPayU = number_format($amount, 2, '.', '');

    // UDF fields (keep SIMPLE & SHORT)
    $udf1 = (string)($plan_id ?? '');
    $udf2 = (string)($billing_data['user_id'] ?? '');
    $udf3 = '';
    $udf4 = '';
    $udf5 = '';

    /* -------------------------------------------------
       5. Generate PayU hash (CRITICAL)
    ------------------------------------------------- */
    $hashString =
        $merchantKey . '|' .
        $txnid . '|' .
        $amountPayU . '|' .
        $productinfo . '|' .
        $user_name . '|' .
        $user_email . '|' .
        $udf1 . '|' .
        $udf2 . '|' .
        $udf3 . '|' .
        $udf4 . '|' .
        $udf5 . '||||||' .
        $salt;

    $hash = strtolower(hash('sha512', $hashString));

    /* -------------------------------------------------
       6. Success & Failure URLs
       (Backend endpoints only)
    ------------------------------------------------- */
    $surl = "http://localhost/managerbp/public/seller/payment/payu-success.php";
    $furl = "http://localhost/managerbp/public/seller/payment/payu-failure.php";

    /* -------------------------------------------------
       7. RETURN DATA (NO DATABASE INSERT HERE ❌)
    ------------------------------------------------- */
    echo json_encode([
        "success" => true,
        "endpoint" => "https://test.payu.in/_payment",
        "key" => $merchantKey,
        "txnid" => $txnid,
        "amount" => $amountPayU,
        "productinfo" => $productinfo,
        "firstname" => $user_name,
        "email" => $user_email,
        "phone" => $user_phone,
        "surl" => $surl,
        "furl" => $furl,
        "hash" => $hash,
        "service_provider" => "payu",
        "udf1" => $udf1,
        "udf2" => $udf2,
        "udf3" => $udf3,
        "udf4" => $udf4,
        "udf5" => $udf5
    ]);
    exit;

} catch (Exception $e) {
    error_log("PayU CREATE ERROR: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
}
