<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$raw = file_get_contents("php://input");
$input = json_decode($raw, true) ?? $_POST;

$phone = trim($input['phone'] ?? "");
$password = trim($input['password'] ?? "");

if (!$phone || !$password) {
    echo json_encode(["success" => false, "message" => "Phone and password required"]);
    exit;
}

// Get correct seller row
$stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ? LIMIT 1");
$stmt->execute([$phone]);
$user = $stmt->fetchObject();

if (!$user) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

if (!password_verify($password, $user->password)) {
    echo json_encode(["success" => false, "message" => "Incorrect password"]);
    exit;
}

// generate token
$token = bin2hex(random_bytes(32));
$update = $pdo->prepare("UPDATE users SET api_token = ? WHERE id = ?");
$update->execute([$token, $user->id]);

// response structure FIXED
echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "token" => $token,
    "user" => [
        "id" => $user->user_id, // ⭐ REAL SELLER USER_ID
        "name" => $user->name,
        "phone" => $user->phone,
        "site_slug" => $user->site_slug,
    ]
]);
exit;
?>
