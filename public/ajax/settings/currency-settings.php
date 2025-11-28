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

$app_name = $_POST['app_name'] ?? '';
$currency = $_POST['currency'] ?? '';

// Validate inputs
if (empty($app_name)) {
    exit(json_encode(["type" => "error", "msg" => "App name is required"]));
}
if (empty($currency)) {
    exit(json_encode(["type" => "error", "msg" => "Currency is required"]));
}

// Update settings
$stmt = $pdo->prepare("UPDATE settings SET app_name = ?, currency = ? WHERE id = 1");
if ($stmt->execute([$app_name, $currency])) {
    exit(json_encode(["type" => "success", "msg" => "Currency settings updated successfully!"]));
} else {
    exit(json_encode(["type" => "error", "msg" => "Failed to update settings"]));
}
?>