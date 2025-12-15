<?php
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once "../../config/config.php";
require_once "../../src/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$name     = trim($data["name"] ?? "");
$email    = trim($data["email"] ?? "");
$phone    = trim($data["phone"] ?? "");
$password = $data["password"] ?? "";
$slug     = $data["slug"] ?? "";

if (!$name || !$phone || !$password || !$slug) {
  echo json_encode(["success" => false, "message" => "Missing required fields"]);
  exit;
}

$pdo = getDbConnection();

/* 🔥 1. FIND SELLER BY SLUG */
$st = $pdo->prepare("SELECT user_id FROM users WHERE site_slug = ? LIMIT 1");
$st->execute([$slug]);
$seller = $st->fetch(PDO::FETCH_ASSOC);

if (!$seller) {
  echo json_encode(["success" => false, "message" => "Invalid seller"]);
  exit;
}

$user_id = $seller["user_id"];

/* 🔥 2. HASH PASSWORD */
$hashed = password_hash($password, PASSWORD_BCRYPT);

/* 🔥 3. GENERATE CUSTOMER ID */
$customer_id = rand(100000, 999999);

/* 🔥 4. INSERT CUSTOMER */
$stmt = $pdo->prepare("
  INSERT INTO customers
  (customer_id, user_id, name, email, phone, password)
  VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([
  $customer_id,
  $user_id,
  $name,
  $email,
  $phone,
  $hashed
]);

echo json_encode([
  "success" => true,
  "message" => "Registration successful"
]);
