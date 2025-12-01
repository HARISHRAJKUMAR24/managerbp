<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "Employee id missing"]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
$deleted = $stmt->execute([$id]);

if ($deleted) {
    echo json_encode(["success" => true, "message" => "Employee deleted"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete employee"]);
}
