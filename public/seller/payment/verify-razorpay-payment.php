<?php
// managerbp/public/seller/payment/verify-razorpay-payment.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "../../../config/config.php";
require_once "../../../src/database.php";
require_once "../../../src/functions.php";

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate required data
if (!isset($data['razorpay_payment_id']) || !isset($data['razorpay_order_id']) || !isset($data['razorpay_signature'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing payment verification data"
    ]);
    exit;
}

$payment_id = $data['razorpay_payment_id'];
$order_id = $data['razorpay_order_id'];
$signature = $data['razorpay_signature'];
$billing_data = $data['billing_data'] ?? [];
$plan_data = $data['plan_data'] ?? [];

// Get Razorpay key secret and currency settings
$pdo = getDbConnection();
$sql = "SELECT razorpay_key_secret, currency FROM settings LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$settings || empty($settings['razorpay_key_secret'])) {
    echo json_encode([
        "success" => false,
        "message" => "Razorpay credentials not configured"
    ]);
    exit;
}

$key_secret = $settings['razorpay_key_secret'];
$currency = $settings['currency'] ?? 'INR';
$currency_symbol = getCurrencySymbol($currency);

// Generate signature
$generated_signature = hash_hmac('sha256', $order_id . '|' . $payment_id, $key_secret);

if ($generated_signature === $signature) {
    // Payment verified successfully
    
    // **FIX: Get user_id from users table (users.user_id column) using email/phone**
    $actual_user_id = null;
    
    // Try to find user by email first
    if (!empty($billing_data['email'])) {
        // **IMPORTANT: Select user_id (the column you want) not id**
        $userSql = "SELECT id, user_id FROM users WHERE email = :email LIMIT 1";
        $userStmt = $pdo->prepare($userSql);
        $userStmt->execute([':email' => $billing_data['email']]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // **USE user_id COLUMN (52064) NOT id COLUMN (9)**
            $actual_user_id = $user['user_id']; // This is what you want: 52064
        }
    }
    
    // If user not found by email, try by phone
    if (!$actual_user_id && !empty($billing_data['phone'])) {
        $userSql = "SELECT id, user_id FROM users WHERE phone = :phone LIMIT 1";
        $userStmt = $pdo->prepare($userSql);
        $userStmt->execute([':phone' => $billing_data['phone']]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $actual_user_id = $user['user_id']; // This is what you want: 52064
        }
    }
    
    // Debug: Log what we found
    error_log("User lookup - Email: " . ($billing_data['email'] ?? 'empty') . 
              ", Phone: " . ($billing_data['phone'] ?? 'empty') . 
              ", Found user_id: " . ($actual_user_id ?? 'null'));
    
    // If still no user found, set to NULL
    if (!$actual_user_id) {
        $actual_user_id = null;
        error_log("No user found in database for provided email/phone");
    }
    
    try {
        // Get invoice number (last invoice + 1)
        $invoiceSql = "SELECT MAX(invoice_number) as last_invoice FROM subscription_histories";
        $invoiceStmt = $pdo->prepare($invoiceSql);
        $invoiceStmt->execute();
        $invoiceResult = $invoiceStmt->fetch(PDO::FETCH_ASSOC);
        $invoice_number = ($invoiceResult['last_invoice'] ?? 0) + 1;
        
        // Insert into subscription_histories
        $insertSql = "INSERT INTO subscription_histories (
            invoice_number, plan_id, user_id, payment_method, payment_id, 
            currency, currency_symbol, amount, gst_amount, gst_type, gst_number, gst_percentage,
            discount, name, email, phone, address_1, address_2, state, city, 
            pin_code, country, created_at
        ) VALUES (
            :invoice_number, :plan_id, :user_id, :payment_method, :payment_id,
            :currency, :currency_symbol, :amount, :gst_amount, :gst_type, :gst_number, :gst_percentage,
            :discount, :name, :email, :phone, :address_1, :address_2, :state, :city,
            :pin_code, :country, NOW()
        )";
        
        $insertStmt = $pdo->prepare($insertSql);
        
        // Prepare data for insertion
        $insertData = [
            ':invoice_number' => $invoice_number,
            ':plan_id' => $plan_data['plan_id'] ?? null,
            // **NOW USING users.user_id (52064) instead of users.id (9)**
            ':user_id' => $actual_user_id,
            ':payment_method' => 'razorpay',
            ':payment_id' => $payment_id,
            ':currency' => $plan_data['currency'] ?? $currency,
            ':currency_symbol' => $plan_data['currency_symbol'] ?? $currency_symbol,
            ':amount' => $plan_data['amount'] ?? 0,
            ':gst_amount' => $plan_data['gst_amount'] ?? 0,
            ':gst_type' => $plan_data['gst_type'] ?? null,
            ':gst_number' => $billing_data['gstin'] ?? null,
            ':gst_percentage' => $plan_data['gst_percentage'] ?? null,
            ':discount' => $plan_data['discount'] ?? 0,
            ':name' => $billing_data['name'] ?? '',
            ':email' => $billing_data['email'] ?? '',
            ':phone' => $billing_data['phone'] ?? '',
            ':address_1' => $billing_data['address_1'] ?? '',
            ':address_2' => $billing_data['address_2'] ?? '',
            ':state' => $billing_data['state'] ?? '',
            ':city' => $billing_data['city'] ?? '',
            ':pin_code' => $billing_data['pin_code'] ?? '',
            ':country' => $billing_data['country'] ?? 'India'
        ];
        
        // Debug: Log the data being inserted
        error_log("Inserting payment record: " . json_encode($insertData));
        
        $insertStmt->execute($insertData);
        
        $lastInsertId = $pdo->lastInsertId();
        
        echo json_encode([
            "success" => true,
            "message" => "Payment verified and recorded successfully",
            "invoice_number" => $invoice_number,
            "payment_id" => $payment_id,
            "user_id" => $actual_user_id, // This will now be 52064
            "record_id" => $lastInsertId,
            "redirect_url" => "/payment-success?invoice=" . $invoice_number
        ]);
        
    } catch (Exception $e) {
        error_log("Payment verification error: " . $e->getMessage());
        error_log("Insert Data: " . print_r($insertData, true));
        
        echo json_encode([
            "success" => false,
            "message" => "Database error: " . $e->getMessage(),
            "error_code" => $e->getCode()
        ]);
    }
    
} else {
    echo json_encode([
        "success" => false,
        "message" => "Payment verification failed - Invalid signature"
    ]);
}