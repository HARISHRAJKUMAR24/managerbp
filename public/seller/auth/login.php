<?php
file_put_contents("php-error-debug.txt", "Reached login.php\n", FILE_APPEND);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

// FIXED: always read JSON input
$raw = file_get_contents("php://input");
$input = json_decode($raw, true);
if (!$input) {
    $input = $_POST;
}

file_put_contents("php-error-debug.txt", json_encode($input) . "\n", FILE_APPEND);

$phone = trim($input['phone'] ?? "");
$password = trim($input['password'] ?? "");

if (!$phone || !$password) {
    echo json_encode(["success" => false, "message" => "Phone and password required"]);
    exit;
}

$pdo = getDbConnection();
$stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ? LIMIT 1");
$stmt->execute([$phone]);
$user = $stmt->fetchObject();

file_put_contents("php-error-debug.txt", json_encode($user) . "\n", FILE_APPEND);

if (!$user) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

if (!password_verify($password, $user->password)) {
    echo json_encode(["success" => false, "message" => "Incorrect password"]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "data" => [
        "id" => $user->id,
        "name" => $user->name,
        "phone" => $user->phone,
    ]
]);
