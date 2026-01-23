<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

/* ===============================
   CORS
================================ */
$allowedOrigin = "http://localhost:3001";

header("Access-Control-Allow-Origin: " . $allowedOrigin);
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../config/config.php";
require_once "../../src/database.php";

$pdo = getDbConnection();

/* ===============================
   READ INPUT
================================ */
$raw  = file_get_contents("php://input");
$data = json_decode($raw, true);

error_log("LOGIN RAW INPUT: " . $raw);
error_log("LOGIN PARSED DATA: " . print_r($data, true));

$phone = trim(
    $data["phone"]
        ?? $data["user"]
        ?? ""
);

$password = $data["password"] ?? "";

if ($phone === "" || $password === "") {
    echo json_encode([
        "success" => false,
        "message" => "Mobile number and password are required"
    ]);
    exit;
}

/* ===============================
   FIND CUSTOMER (NO SLUG)
================================ */
$stmt = $pdo->prepare("
    SELECT customer_id, name, phone,photo, password, user_id
    FROM customers
    WHERE phone = ?
    LIMIT 1
");
$stmt->execute([$phone]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid mobile number or password"
    ]);
    exit;
}

/* ===============================
   VERIFY PASSWORD
================================ */
if (!password_verify($password, $customer["password"])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid mobile number or password"
    ]);
    exit;
}

/* ===============================
   TOKEN
================================ */
$token = base64_encode(json_encode([
    "customer_id" => $customer["customer_id"],
    "user_id"     => $customer["user_id"],
    "iat"         => time()
]));


setcookie(
    "customer_token",
    $token,
    [
        "expires"  => time() + (60 * 60 * 24 * 7), // 7 days
        "path"     => "/",
        "httponly" => true,   // 🔒 secure
        "samesite" => "Lax"   // ✅ WORKS on HTTP
        // DO NOT set "secure" on localhost HTTP
    ]
);

/* ===============================
   SUCCESS
================================ */
echo json_encode([
    "success"  => true,
    "message"  => "Login successful",
    "token"    => $token,
    "customer" => [
        "customer_id" => $customer["customer_id"],
        "user_id"     => (int)$customer["user_id"], // ✅ ADD THIS

        "name"        => $customer["name"],
        "phone"       => $customer["phone"]
    ]
]);
exit;
