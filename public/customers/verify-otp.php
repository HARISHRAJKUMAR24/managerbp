<?php
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require_once "../../config/config.php";
require_once "../../src/database.php";

$data = json_decode(file_get_contents("php://input"), true);

// ✅ DEBUG (optional – remove later)
file_put_contents(__DIR__."/otp_debug.log", print_r($data, true));

// ✅ NORMALIZE OTP
$otp = trim((string)($data['otp'] ?? ''));

if ($otp !== "111111") {
    echo json_encode([
        "success" => false,
        "message" => "You entered an incorrect otp code",
        "received" => $otp
    ]);
    exit;
}

// ✅ REQUIRED DATA
$name     = $data['name'] ?? "";
$email    = $data['email'] ?? null;
$phone    = $data['phone'] ?? "";
$password = $data['password'] ?? "";
$slug     = $data['slug'] ?? "";

if (!$name || !$phone || !$password || !$slug) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}

$pdo = getDbConnection();

/**
 * 1️⃣ Find seller by slug
 */
$stmt = $pdo->prepare("SELECT user_id FROM users WHERE site_slug = ? LIMIT 1");
$stmt->execute([$slug]);
$seller = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$seller) {
    echo json_encode([
        "success" => false,
        "message" => "Seller not found"
    ]);
    exit;
}

/**
 * 2️⃣ Create customer
 */
$customerId = rand(100000, 999999);
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("
    INSERT INTO customers (customer_id, user_id, name, email, phone, password)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $customerId,
    $seller['user_id'],
    $name,
    $email,
    $phone,
    $hashedPassword
]);

echo json_encode([
    "success" => true,
    "message" => "Customer registered successfully"
]);
