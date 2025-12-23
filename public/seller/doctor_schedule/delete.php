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

$stmt = $pdo->prepare("DELETE FROM doctor_schedule WHERE id=:id");
$stmt->execute([":id" => $id]);

echo json_encode(["success" => true, "message" => "schedule deleted"]);
