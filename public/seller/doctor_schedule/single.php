<?php
header("Content-Type: application/json");
require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$id = $_GET["id"] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "id required"]);
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM doctor_schedule WHERE id = :id LIMIT 1");
$stmt->execute([":id" => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(["success" => false, "message" => "not found"]);
    exit();
}

$row["weekly_schedule"] = json_decode($row["weekly_schedule"], true);
$row["additional_images"] = json_decode($row["additional_images"], true);

echo json_encode(["success" => true, "data" => $row]);
