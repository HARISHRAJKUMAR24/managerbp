<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data["user_id"] ?? null;
$hero_title = $data["hero_title"] ?? "";
$hero_description = $data["hero_description"] ?? "";
$hero_image = $data["hero_image"] ?? "";

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "Missing user_id"]);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM website_settings WHERE user_id = :uid");
$stmt->execute([":uid" => $user_id]);

if ($stmt->fetch()) {
    $sql = "UPDATE website_settings SET 
            hero_title = :title,
            hero_description = :description,
            hero_image = :image
            WHERE user_id = :uid";
} else {
    $sql = "INSERT INTO website_settings 
            (user_id, hero_title, hero_description, hero_image)
            VALUES (:uid, :title, :description, :image)";
}

$pdo->prepare($sql)->execute([
    ":uid" => $user_id,
    ":title" => $hero_title,
    ":description" => $hero_description,
    ":image" => $hero_image
]);

echo json_encode([
    "success" => true,
    "message" => "Header settings updated successfully"
]);
