<?php
// managerbp/public/seller/payment/payu-success.php

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* -------------------------------------------------
   1. Read PayU POST data
------------------------------------------------- */
$status = $_POST['status'] ?? '';
$txnid  = $_POST['txnid'] ?? '';

if ($status !== 'success' || !$txnid) {
    header("Location: http://localhost:3000/payment-failed");
    exit;
}

/* -------------------------------------------------
   2. Prevent duplicate inserts
------------------------------------------------- */
$stmt = $pdo->prepare("
    SELECT invoice_number 
    FROM subscription_histories 
    WHERE payment_id = ?
");
$stmt->execute([$txnid]);

if ($existing = $stmt->fetch(PDO::FETCH_ASSOC)) {
    header("Location: http://localhost:3000/payment-success?invoice=" . $existing['invoice_number']);
    exit;
}

/* -------------------------------------------------
   3. Extract REQUIRED PayU fields
------------------------------------------------- */
$plan_id = $_POST['udf1'] ?? null;
$user_id = $_POST['udf2'] ?? null;

if (!$plan_id || !$user_id) {
    error_log("PayU ERROR: Missing plan_id or user_id");
    header("Location: http://localhost:3000/payment-failed");
    exit;
}

/* Address fields sent back by PayU */
$address_1 = $_POST['address1'] ?? '';
$address_2 = $_POST['address2'] ?? '';
$city      = $_POST['city'] ?? '';
$state     = $_POST['state'] ?? '';
$pin_code  = $_POST['zipcode'] ?? '';
$country   = $_POST['country'] ?? 'India';

/* -------------------------------------------------
   4. Generate invoice number
------------------------------------------------- */
$stmt = $pdo->query("SELECT MAX(invoice_number) AS last_invoice FROM subscription_histories");
$last = $stmt->fetch(PDO::FETCH_ASSOC);
$invoice_number = ($last['last_invoice'] ?? 0) + 1;

/* -------------------------------------------------
   5. INSERT subscription_histories (SUCCESS ONLY)
------------------------------------------------- */
$insert = $pdo->prepare("
    INSERT INTO subscription_histories (
        invoice_number, plan_id, user_id, payment_method, payment_id,
        currency, amount, gst_amount, gst_type, gst_percentage, discount,
        name, email, phone,
        address_1, address_2, state, city, pin_code, country,
        created_at, currency_symbol
    ) VALUES (
        :invoice, :plan_id, :user_id, 'payu', :payment_id,
        :currency, :amount, :gst_amount, :gst_type, :gst_percentage, :discount,
        :name, :email, :phone,
        :address_1, :address_2, :state, :city, :pin_code, :country,
        NOW(), :currency_symbol
    )
");

$insert->execute([
    ':invoice'         => $invoice_number,
    ':plan_id'         => $plan_id,
    ':user_id'         => $user_id,
    ':payment_id'      => $txnid,
    ':currency'        => 'INR',
    ':amount'          => $_POST['amount'] ?? 0,
    ':gst_amount'      => 0,
    ':gst_type'        => null,
    ':gst_percentage'  => 0,
    ':discount'        => 0,
    ':name'            => $_POST['firstname'] ?? '',
    ':email'           => $_POST['email'] ?? '',
    ':phone'           => $_POST['phone'] ?? '',
    ':address_1'       => $address_1,
    ':address_2'       => $address_2,
    ':state'           => $state,
    ':city'            => $city,
    ':pin_code'        => $pin_code,
    ':country'         => $country,
    ':currency_symbol' => '₹'
]);

/* -------------------------------------------------
   6. UPDATE USERS TABLE (PLAN + EXPIRY)
------------------------------------------------- */

/* Get plan duration */
$stmt = $pdo->prepare("SELECT duration FROM subscription_plans WHERE id = ?");
$stmt->execute([$plan_id]);
$plan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$plan) {
    error_log("PayU ERROR: Plan not found");
    header("Location: http://localhost:3000/payment-failed");
    exit;
}

$duration_days = (int) $plan['duration'];

/* Get user current plan */
$stmt = $pdo->prepare("SELECT plan_id, expires_on FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$expires_on = new DateTime();

/* Renewal logic (same plan + active) */
if (
    !empty($user['expires_on']) &&
    new DateTime($user['expires_on']) > new DateTime() &&
    (int)$user['plan_id'] === (int)$plan_id
) {
    $expires_on = new DateTime($user['expires_on']);
}

$expires_on->modify("+{$duration_days} days");

/* Update users table */
$update = $pdo->prepare("
    UPDATE users
    SET plan_id = ?, expires_on = ?
    WHERE user_id = ?
");

$update->execute([
    $plan_id,
    $expires_on->format("Y-m-d H:i:s"),
    $user_id
]);

if ($update->rowCount() === 0) {
    error_log("PayU WARNING: User update affected 0 rows (user_id={$user_id})");
}

/* -------------------------------------------------
   7. Redirect to frontend success page
------------------------------------------------- */
header("Location: http://localhost:3000/payment-success?invoice={$invoice_number}");
exit;
