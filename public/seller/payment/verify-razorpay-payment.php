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

// Debug raw input
error_log("RAW PAYMENT VERIFY INPUT: " . $input);

// Validate required Razorpay fields
if (
    empty($data['razorpay_payment_id']) ||
    empty($data['razorpay_order_id']) ||
    empty($data['razorpay_signature'])
) {
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

$logged_in_user_id = $data['logged_in_user_id'] ?? null; // <- IMPORTANT

if (!$logged_in_user_id) {
    error_log("❌ logged_in_user_id not received!");
    echo json_encode([
        "success" => false,
        "message" => "User identity missing. Please re-login."
    ]);
    exit;
}

error_log("Logged-in user_id received: " . $logged_in_user_id);

// DB Connection + Razorpay settings
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

// Validate signature
$generated_signature = hash_hmac("sha256", $order_id . "|" . $payment_id, $key_secret);

if ($generated_signature !== $signature) {
    echo json_encode([
        "success" => false,
        "message" => "Payment verification failed - invalid signature"
    ]);
    exit;
}

// Payment verified successfully
try {
    // Start transaction
    $pdo->beginTransaction();

    // Get invoice number
    $stmt = $pdo->query("SELECT MAX(invoice_number) AS last_invoice FROM subscription_histories");
    $last = $stmt->fetch(PDO::FETCH_ASSOC);
    $invoice_number = ($last['last_invoice'] ?? 0) + 1;

    // Get plan duration from subscription_plans table
    $plan_id = $plan_data["plan_id"] ?? null;
    $duration_days = 0;

    if ($plan_id) {
        $stmt = $pdo->prepare("SELECT duration FROM subscription_plans WHERE id = ?");
        $stmt->execute([$plan_id]);
        $plan = $stmt->fetch(PDO::FETCH_ASSOC);
        $duration_days = $plan['duration'] ?? 0;
    }

    // Calculate expiration date
    $expires_on = date('Y-m-d H:i:s', strtotime("+$duration_days days"));

    // Insert subscription record
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

    $insert = $pdo->prepare($insertSql);

    $insertData = [
        ":invoice_number" => $invoice_number,
        ":plan_id" => $plan_id,
        ":user_id" => $logged_in_user_id,
        ":payment_method" => "razorpay",
        ":payment_id" => $payment_id,
        ":currency" => $plan_data["currency"] ?? $currency,
        ":currency_symbol" => $plan_data["currency_symbol"] ?? $currency_symbol,
        ":amount" => $plan_data["amount"] ?? 0,
        ":gst_amount" => $plan_data["gst_amount"] ?? 0,
        ":gst_type" => $plan_data["gst_type"] ?? null,
        ":gst_number" => $billing_data["gstin"] ?? null,
        ":gst_percentage" => $plan_data["gst_percentage"] ?? null,
        ":discount" => $plan_data["discount"] ?? 0,
        ":name" => $billing_data["name"] ?? "",
        ":email" => $billing_data["email"] ?? "",
        ":phone" => $billing_data["phone"] ?? "",
        ":address_1" => $billing_data["address_1"] ?? "",
        ":address_2" => $billing_data["address_2"] ?? "",
        ":state" => $billing_data["state"] ?? "",
        ":city" => $billing_data["city"] ?? "",
        ":pin_code" => $billing_data["pin_code"] ?? "",
        ":country" => $billing_data["country"] ?? "India"
    ];

    error_log("Inserting subscription: " . json_encode($insertData));
    $insert->execute($insertData);

    // Update users table with plan_id and expiration date
    $updateUserSql = "UPDATE users SET plan_id = :plan_id, expires_on = :expires_on WHERE user_id = :user_id";
    $updateUser = $pdo->prepare($updateUserSql);
    $updateUser->execute([
        ':plan_id' => $plan_id,
        ':expires_on' => $expires_on,
        ':user_id' => $logged_in_user_id
    ]);

    $rowsAffected = $updateUser->rowCount();
    error_log("Updated users table. Rows affected: " . $rowsAffected);
    error_log("Set expires_on to: " . $expires_on . " for user_id: " . $logged_in_user_id);

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Payment verified and recorded successfully",
        "invoice_number" => $invoice_number,
        "payment_id" => $payment_id,
        "user_id" => $logged_in_user_id,
        "expires_on" => $expires_on,
        "plan_id" => $plan_id,
        "redirect_url" => "/payment-success?invoice={$invoice_number}"
    ]);
} catch (Exception $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    error_log("❌ Payment Insert Error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
