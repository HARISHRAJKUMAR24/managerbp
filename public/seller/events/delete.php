<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Content-Type: application/json");

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../seller/functions.php';

$pdo = getDbConnection();

$id = $_GET["id"] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "Event ID missing"]);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $result = $stmt->execute([$id]);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "SQL execution failed",
            "errorInfo" => $stmt->errorInfo()   // 🔥 DEBUG EXACT SQL ERROR
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Event deleted successfully"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Exception occurred",
        "error" => $e->getMessage()
    ]);
}
exit;
?>
