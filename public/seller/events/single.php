<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../seller/functions.php';

$pdo = getDbConnection();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "Event ID missing"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Event not found"]);
    exit;
}

echo json_encode(["success" => true, "data" => $data]);
?>
