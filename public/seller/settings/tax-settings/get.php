<?php
// managerbp/public/seller/settings/tax-settings/get.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../../../config/config.php";
require_once "../../../../../src/database.php";

$pdo = getDbConnection();

// Get user ID
$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID required"]);
    exit();
}

// Get settings for user
$sql = "SELECT * FROM users_settings WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ LOG what we're returning
error_log("Get Tax Settings for user $user_id: " . json_encode($settings));

if (!$settings) {
    // No record exists at all
    $settings = [
        'gst_number' => null,
        'gst_type' => null,
        'tax_percent' => null
    ];
}

echo json_encode([
    'success' => true,
    'data' => $settings
]);