<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

require_once '../../../config/config.php';
require_once '../../../src/database.php';

// Read JSON or POST
$input = $_POST;
if (!$input) {
    $input = json_decode(file_get_contents("php://input"), true);
}

// Read fields safely
$name       = trim($input['name'] ?? "");
$email      = trim($input['email'] ?? "");
$phone      = trim($input['phone'] ?? "");
$country    = trim($input['country'] ?? "IN");
$siteName   = trim($input['siteName'] ?? "");
$password   = trim($input['password'] ?? "");
$otp        = trim($input['otp'] ?? "");

// Validate required fields
if (!$name || !$phone || !$password || !$otp) {
    echo json_encode([
        "success" => false,
        "message" => "All fields required"
    ]);
    exit;
}

// OTP must be 111111 (dev mode)
if ($otp !== "111111") {
    echo json_encode([
        "success" => false,
        "message" => "Please enter correct OTP"
    ]);
    exit;
}

$pdo = getDbConnection();

// Check duplicate phone
$stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
$stmt->execute([$phone]);
if ($stmt->fetchColumn()) {
    echo json_encode([
        "success" => false,
        "message" => "Phone already registered"
    ]);
    exit;
}

// Safe slug
if ($siteName) {
    $siteSlug = strtolower(preg_replace('/\s+/', '-', $siteName));
} else {
    // default if empty
    $siteSlug = strtolower(preg_replace('/\s+/', '-', $name)) . "-" . rand(100,999);
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt = $pdo->prepare("
    INSERT INTO users (user_id, name, email, phone, password, country, site_name, site_slug, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
");

$userId = rand(10000, 99999);

$ok = $stmt->execute([
    $userId,
    $name,
    $email ?: null,
    $phone,
    $hashed,
    $country ?: "IN",
    $siteName ?: null,
    $siteSlug
]);

if (!$ok) {
    echo json_encode([
        "success" => false,
        "message" => "Registration failed"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Registration successful",
    "data" => [
        "user_id" => $userId,
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "country" => $country,
        "site_name" => $siteName,
        "site_slug" => $siteSlug
    ]
]);
