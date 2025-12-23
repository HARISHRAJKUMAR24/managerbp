<?php
header("Content-Type: application/json");
require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$input = json_decode(file_get_contents("php://input"), true);
$user_id = $input["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id required"]);
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM doctor_schedule WHERE user_id = :user_id ORDER BY id DESC");
$stmt->execute([":user_id" => $user_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["success" => true, "data" => $data]);
