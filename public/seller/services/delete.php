<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$service_id = $_GET["service_id"] ?? null;

if (!$service_id) {
    echo json_encode(["success" => false, "message" => "service_id missing"]);
    exit();
}

// Delete main service
$stmt = $pdo->prepare("DELETE FROM services WHERE service_id = :sid");
$stmt->execute(["sid" => $service_id]);

// Also delete additional images table
$pdo->prepare("DELETE FROM service_images WHERE service_id = ?")->execute([$service_id]);

$deleted = $stmt->rowCount() > 0;

echo json_encode([
    "success" => $deleted,
    "message" => $deleted ? "Service deleted" : "Service not found"
]);
