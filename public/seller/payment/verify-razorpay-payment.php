<?php
// managerbp/public/seller/payment/verify-razorpay-payment.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

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

// Get Razorpay key secret
$pdo = getDbConnection();
$sql = "SELECT razorpay_key_secret FROM settings LIMIT 1";
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

// Generate signature
$generated_signature = hash_hmac('sha256', $order_id . '|' . $payment_id, $key_secret);

if ($generated_signature === $signature) {
    // Payment verified successfully
    // Store payment details in subscription_histories table
    
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
            currency, amount, gst_amount, gst_type, gst_number, gst_percentage,
            discount, name, email, phone, address_1, address_2, state, city, 
            pin_code, country, created_at
        ) VALUES (
            :invoice_number, :plan_id, :user_id, :payment_method, :payment_id,
            :currency, :amount, :gst_amount, :gst_type, :gst_number, :gst_percentage,
            :discount, :name, :email, :phone, :address_1, :address_2, :state, :city,
            :pin_code, :country, NOW()
        )";
        
        $insertStmt = $pdo->prepare($insertSql);
        
        // Prepare data for insertion
        $insertData = [
            ':invoice_number' => $invoice_number,
            ':plan_id' => $plan_data['plan_id'] ?? null,
            ':user_id' => $billing_data['user_id'] ?? null,
            ':payment_method' => 'razorpay',
            ':payment_id' => $payment_id,
            ':currency' => $plan_data['currency'] ?? 'INR',
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
        
        $insertStmt->execute($insertData);
        
        echo json_encode([
            "success" => true,
            "message" => "Payment verified and recorded successfully",
            "invoice_number" => $invoice_number,
            "payment_id" => $payment_id
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "Database error: " . $e->getMessage()
        ]);
    }
    
} else {
    echo json_encode([
        "success" => false,
        "message" => "Payment verification failed"
    ]);
}