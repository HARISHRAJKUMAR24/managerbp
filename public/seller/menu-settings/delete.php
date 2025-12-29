<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* ✅ READ ID FROM QUERY STRING */
$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode([
        "success" => false,
        "message" => "Menu ID missing"
    ]);
    exit;
}

/* ✅ DELETE MENU */
$stmt = $pdo->prepare("DELETE FROM menus WHERE id = ?");
$stmt->execute([$id]);

echo json_encode([
    "success" => $stmt->rowCount() > 0,
    "message" => $stmt->rowCount() > 0
        ? "Menu deleted successfully"
        : "Menu not found"
]);
