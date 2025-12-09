<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../seller/functions.php';

$pdo = getDbConnection();

$id = $_GET["id"] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "Event ID missing"]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$success = $stmt->execute([$id]);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Event deleted successfully" : "Delete failed"
]);
?>
