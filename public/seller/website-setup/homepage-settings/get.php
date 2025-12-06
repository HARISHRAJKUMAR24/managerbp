<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();

$public_user_id = $_GET["user_id"] ?? null;

if (!$public_user_id) {
    echo json_encode([
        "success" => false,
        "message" => "user_id missing"
    ]);
    exit;
}

// Convert PUBLIC → REAL primary key
$stmt = $pdo->prepare("SELECT id FROM users WHERE user_id = :uid LIMIT 1");
$stmt->execute([":uid" => $public_user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid user"]);
    exit;
}

$realUser = $user["id"];

// GET header settings
$stmt = $pdo->prepare("
    SELECT hero_title, hero_description, hero_image
    FROM website_settings
    WHERE user_id = :uid
");
$stmt->execute([":uid" => $realUser]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    $data = [
        "hero_title" => "",
        "hero_description" => "",
        "hero_image" => "",
    ];
}

$baseURL = "http://localhost/managerbp/public/uploads/";

$data["hero_image_url"] = $data["hero_image"]
    ? $baseURL . $data["hero_image"]
    : null;

$data["user_id"] = $realUser;

echo json_encode([
    "success" => true,
    "data" => $data
]);
