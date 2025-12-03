<?php
// seller/coupons/create.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// ✅ CORRECT PATH
require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// Debug: Log the raw input
error_log("Raw input: " . file_get_contents("php://input"));

$data = json_decode(file_get_contents("php://input"), true);

// Debug: Log decoded data
error_log("Decoded data: " . print_r($data, true));

if (!$data) {
    echo json_encode(["success" => false, "message" => "No data received or invalid JSON"]);
    exit();
}

// Validate required fields
$required = ['name', 'code', 'discount_type', 'discount', 'start_date', 'end_date'];
foreach ($required as $field) {
    if (!isset($data[$field]) || $data[$field] === "" || $data[$field] === null) {
        echo json_encode(["success" => false, "message" => "$field is required"]);
        exit();
    }
}

// Get user ID from token or query param
$user_id = $_GET['user_id'] ?? null;
if (!$user_id) {
    // Try to get from headers
    $headers = getallheaders();
    $token = str_replace('Bearer ', '', $headers['Authorization'] ?? '');
    
    // For now, use a default user_id for testing
    $user_id = 1;
    
    error_log("Using user_id: $user_id, Token: " . substr($token, 0, 20) . "...");
}

// Generate unique coupon_id
$coupon_id = 'CPN_' . uniqid() . '_' . rand(1000, 9999);

// Prepare data
$name = trim($data['name']);
$code = strtoupper(trim($data['code']));
$discount_type = trim($data['discount_type']);
$discount = (int)$data['discount'];
$start_date = date('Y-m-d H:i:s.v', strtotime($data['start_date']));
$end_date = date('Y-m-d H:i:s.v', strtotime($data['end_date']));

$usage_limit = isset($data['usage_limit']) && $data['usage_limit'] !== '' ? (int)$data['usage_limit'] : null;
$min_booking_amount = isset($data['min_booking_amount']) && $data['min_booking_amount'] !== '' ? (int)$data['min_booking_amount'] : null;

// Debug: Log prepared data
error_log("Prepared data - Name: $name, Code: $code, Discount Type: $discount_type, Discount: $discount");

// Check if coupon code already exists for this user
$checkSql = "SELECT COUNT(*) FROM coupons WHERE code = :code AND user_id = :user_id";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([':code' => $code, ':user_id' => $user_id]);
if ($checkStmt->fetchColumn() > 0) {
    echo json_encode(["success" => false, "message" => "Coupon code already exists"]);
    exit();
}

// Insert coupon
$sql = "INSERT INTO coupons (coupon_id, user_id, name, code, discount_type, discount, start_date, end_date, usage_limit, min_booking_amount, created_at) 
        VALUES (:coupon_id, :user_id, :name, :code, :discount_type, :discount, :start_date, :end_date, :usage_limit, :min_booking_amount, NOW())";

$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    ':coupon_id' => $coupon_id,
    ':user_id' => $user_id,
    ':name' => $name,
    ':code' => $code,
    ':discount_type' => $discount_type,
    ':discount' => $discount,
    ':start_date' => $start_date,
    ':end_date' => $end_date,
    ':usage_limit' => $usage_limit,
    ':min_booking_amount' => $min_booking_amount
]);

if ($result) {
    error_log("Coupon created successfully: $coupon_id");
    echo json_encode([
        "success" => true,
        "message" => "Coupon created successfully",
        "coupon_id" => $coupon_id
    ]);
} else {
    $errorInfo = $stmt->errorInfo();
    error_log("Database error: " . print_r($errorInfo, true));
    echo json_encode([
        "success" => false, 
        "message" => "Database error: " . $errorInfo[2]
    ]);
}