<?php

error_log("LOGIN RAW INPUT: " . $raw);
error_log("LOGIN PARSED DATA: " . print_r($data, true));

ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../config/config.php";
require_once "../../src/database.php";

$pdo = getDbConnection();

/* ===============================
   READ INPUT (ROBUST)
================================ */
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$phone    = trim($data["phone"] ?? "");
$password = $data["password"] ?? "";

/**
 * ✅ SLUG FALLBACKS (THIS FIXES YOUR ISSUE)
 */
$slug =
    trim($data["slug"] ?? "") ?:
    trim($data["site"] ?? "") ?:
    trim($_GET["slug"] ?? "");

if ($phone === "" || $password === "" || $slug === "") {
    echo json_encode([
        "success" => false,
        "message" => "Mobile number, password and site are required",
        "debug" => [
            "phone" => $phone,
            "slug" => $slug
        ]
    ]);
    exit;
}

/* ===============================
   1️⃣ FIND SELLER
================================ */
$stmt = $pdo->prepare("
    SELECT user_id
    FROM users
    WHERE site_slug = ?
    LIMIT 1
");
$stmt->execute([$slug]);
$seller = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$seller) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid site"
    ]);
    exit;
}

$user_id = (int)$seller["user_id"];

/* ===============================
   2️⃣ FIND CUSTOMER
================================ */
$stmt = $pdo->prepare("
    SELECT id, customer_id, name, phone, password
    FROM customers
    WHERE user_id = ? AND phone = ?
    LIMIT 1
");
$stmt->execute([$user_id, $phone]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid mobile number or password"
    ]);
    exit;
}

/* ===============================
   3️⃣ VERIFY PASSWORD
================================ */
if (!password_verify($password, $customer["password"])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid mobile number or password"
    ]);
    exit;
}

/* ===============================
   4️⃣ TOKEN
================================ */
$token = base64_encode(json_encode([
    "customer_id" => $customer["customer_id"],
    "user_id"     => $user_id,
    "iat"         => time()
]));

/* ===============================
   SUCCESS
================================ */
echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "token"   => $token,
    "customer" => [
        "customer_id" => $customer["customer_id"],
        "name"        => $customer["name"],
        "phone"       => $customer["phone"]
    ]
]);
exit;
