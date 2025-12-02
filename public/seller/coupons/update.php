<?php
// coupons/update.php
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

// Get coupon ID from GET parameter
$coupon_id = $_GET['id'] ?? '';

if (empty($coupon_id)) {
    echo json_encode(["success" => false, "message" => "Coupon ID is required"]);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

if (empty($data)) {
    echo json_encode(["success" => false, "message" => "No data provided"]);
    exit();
}

// Get user ID from token
$headers = getallheaders();
$token = str_replace('Bearer ', '', $headers['Authorization'] ?? '');
$user_id = 1; // In production, decode token to get user_id

// Check if coupon exists and belongs to user
$checkSql = "SELECT COUNT(*) FROM coupons WHERE coupon_id = :coupon_id AND user_id = :user_id";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([':coupon_id' => $coupon_id, ':user_id' => $user_id]);
if ($checkStmt->fetchColumn() == 0) {
    echo json_encode(["success" => false, "message" => "Coupon not found"]);
    exit();
}

// Prepare update fields
$updateFields = [];
$params = [':coupon_id' => $coupon_id, ':user_id' => $user_id];

// All possible fields to update
$fieldMap = [
    'name' => 'name',
    'code' => 'code',
    'discount_type' => 'discount_type',
    'discount' => 'discount',
    'start_date' => 'start_date',
    'end_date' => 'end_date',
    'usage_limit' => 'usage_limit',
    'min_booking_amount' => 'min_booking_amount'
];

foreach ($fieldMap as $field => $dbField) {
    if (isset($data[$field])) {
        if ($field === 'code') {
            // Check if new code doesn't conflict with other coupons (excluding current)
            $codeCheckSql = "SELECT COUNT(*) FROM coupons WHERE code = :code AND coupon_id != :coupon_id AND user_id = :user_id";
            $codeCheckStmt = $pdo->prepare($codeCheckSql);
            $codeCheckStmt->execute([
                ':code' => strtoupper($data['code']), 
                ':coupon_id' => $coupon_id, 
                ':user_id' => $user_id
            ]);
            if ($codeCheckStmt->fetchColumn() > 0) {
                echo json_encode(["success" => false, "message" => "Coupon code already exists"]);
                exit();
            }
            $value = strtoupper($data['code']);
        } elseif (in_array($field, ['start_date', 'end_date'])) {
            $value = date('Y-m-d H:i:s', strtotime($data[$field]));
        } elseif (in_array($field, ['usage_limit', 'min_booking_amount'])) {
            // Handle nullable fields
            $value = $data[$field] !== '' && $data[$field] !== null ? (int)$data[$field] : null;
        } else {
            $value = $data[$field];
        }
        
        $updateFields[] = "$dbField = :$field";
        $params[":$field"] = $value;
    }
}

if (empty($updateFields)) {
    echo json_encode(["success" => false, "message" => "No fields to update"]);
    exit();
}

// Build and execute update query
$sql = "UPDATE coupons SET " . implode(', ', $updateFields) . " WHERE coupon_id = :coupon_id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute($params);

if ($result) {
    echo json_encode(["success" => true, "message" => "Coupon updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update coupon"]);
}