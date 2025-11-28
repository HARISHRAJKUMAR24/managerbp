<?php
require_once '../../../src/database.php';
require_once '../../../src/functions.php';

// Check if user is logged in and is admin
if (!isLoggedIn()) {
    exit(json_encode(["type" => "error", "msg" => "Please login first"]));
}
if (!isAdmin()) {
    exit(json_encode(["type" => "error", "msg" => "Access denied"]));
}

// Get database connection
$pdo = getDbConnection();

$razorpay_key_id = $_POST['razorpay_key_id'] ?? '';
$razorpay_key_secret = $_POST['razorpay_key_secret'] ?? '';
$ippopay_public_key = $_POST['ippopay_public_key'] ?? '';
$phonepe_key_merchant_id = $_POST['phonepe_key_merchant_id'] ?? '';
$phonepe_key_index = $_POST['phonepe_key_index'] ?? '';
$phonepe_key = $_POST['phonepe_key'] ?? '';

// Update payment settings
$stmt = $pdo->prepare("UPDATE settings SET 
    razorpay_key_id = ?, 
    razorpay_key_secret = ?, 
    ippopay_public_key = ?, 
    phonepe_key_merchant_id = ?, 
    phonepe_key_index = ?, 
    phonepe_key = ? 
    WHERE id = 1");

if ($stmt->execute([
    $razorpay_key_id, 
    $razorpay_key_secret, 
    $ippopay_public_key, 
    $phonepe_key_merchant_id, 
    $phonepe_key_index, 
    $phonepe_key
])) {
    exit(json_encode(["type" => "success", "msg" => "Payment settings updated successfully!"]));
} else {
    exit(json_encode(["type" => "error", "msg" => "Failed to update payment settings"]));
}
?>