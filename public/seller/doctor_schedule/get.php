<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$id = $_GET['id'] ?? null;

if (!$id) {
  echo json_encode(["success" => false, "message" => "ID required"]);
  exit;
}

$stmt = $pdo->prepare("
  SELECT 
    id AS serviceId,
    name,
    slug,
    amount,
    doctor_image AS image,
    specialization,
    qualification,
    description,
    weekly_schedule,
    meta_title,
    meta_description
  FROM doctor_schedule
  WHERE id = ?
  LIMIT 1
");

$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
  echo json_encode(["success" => false, "message" => "Not found"]);
  exit;
}

$data['weekly_schedule'] = json_decode($data['weekly_schedule'], true);

echo json_encode([
  "success" => true,
  "data" => $data
]);
