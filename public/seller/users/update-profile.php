<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$input = json_decode(file_get_contents("php://input"), true);

$user_id = $input["user_id"] ?? 0;
$name = $input["name"] ?? "";
$email = $input["email"] ?? "";
$phone = $input["phone"] ?? "";
$country = $input["country"] ?? "";
$image = $input["image"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID missing"]);
    exit;
}

// FIX: use correct column "id"
$sql = "UPDATE users SET 
            name = :name,
            email = :email,
            phone = :phone,
            country = :country,
            image = :image
        WHERE id = :user_id";

$stmt = $pdo->prepare($sql);

$success = $stmt->execute([
    ":name" => $name,
    ":email" => $email,
    ":phone" => $phone,
    ":country" => $country,
    ":image" => $image,
    ":user_id" => $user_id
]);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Profile updated!" : "Update failed"
]);
