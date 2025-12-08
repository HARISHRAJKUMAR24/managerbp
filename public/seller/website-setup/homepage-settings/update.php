<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();

$data = json_decode(file_get_contents("php://input"), true);

$realUser = $data["user_id"] ?? null; // REAL PRIMARY KEY from Next.js cookie

$hero_title = $data["hero_title"] ?? "";
$hero_description = $data["hero_description"] ?? "";
$hero_image = $data["hero_image"] ?? "";

if (!$realUser) {
    echo json_encode(["success" => false, "message" => "Missing user_id"]);
    exit;
}

// VALIDATE USER EXISTS
$stmt = $pdo->prepare("SELECT id FROM users WHERE id = :uid LIMIT 1");
$stmt->execute([":uid" => $realUser]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid user"]);
    exit;
}

// CHECK IF ROW EXISTS FOR THIS REAL USER ID
$stmt = $pdo->prepare("SELECT id FROM website_settings WHERE user_id = :uid");
$stmt->execute([":uid" => $realUser]);

if ($stmt->fetch()) {
    // UPDATE
    $sql = "UPDATE website_settings SET 
            hero_title = :title,
            hero_description = :description,
            hero_image = :image
            WHERE user_id = :uid";
} else {
    // INSERT
    $sql = "INSERT INTO website_settings 
            (user_id, hero_title, hero_description, hero_image)
            VALUES (:uid, :title, :description, :image)";
}

// EXECUTE
$pdo->prepare($sql)->execute([
    ":uid" => $realUser,
    ":title" => $hero_title,
    ":description" => $hero_description,
    ":image" => $hero_image
]);

echo json_encode([
    "success" => true,
    "message" => "Homepage settings updated successfully"
]);
