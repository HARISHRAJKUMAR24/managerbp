<?php
// coupons/delete.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// Get coupon ID from GET parameter (numeric ID, not coupon_id)
$id = $_GET['id'] ?? 0;

if (!$id) {
    echo json_encode(["success" => false, "message" => "Coupon ID is required"]);
    exit();
}

// Get user ID from token
$headers = getallheaders();
$token = str_replace('Bearer ', '', $headers['Authorization'] ?? '');
$user_id = 1; // In production, decode token to get user_id

// Delete coupon
$sql = "DELETE FROM coupons WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([':id' => $id, ':user_id' => $user_id]);

if ($result && $stmt->rowCount() > 0) {
    echo json_encode(["success" => true, "message" => "Coupon deleted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Coupon not found or already deleted"]);
}