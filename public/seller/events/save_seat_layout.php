<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once "../../../config/config.php";
$pdo = getDbConnection();

$raw = file_get_contents("php://input");
$input = json_decode($raw, true);

if (!$input) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON body",
        "raw" => $raw
    ]);
    exit;
}

$event_id = $input["event_id"] ?? null;
$user_id = $input["user_id"] ?? null;
$layout = $input["layout"] ?? null;

if (!$event_id || !$user_id || !$layout) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields (event_id, user_id, layout)",
        "received" => $input
    ]);
    exit;
}

$layout_json = json_encode($layout);

$stmt = $pdo->prepare("
    INSERT INTO event_seat_layouts (event_id, user_id, layout_json)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        layout_json = VALUES(layout_json),
        user_id = VALUES(user_id)
");

$success = $stmt->execute([$event_id, $user_id, $layout_json]);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Seat layout saved" : "Failed saving layout"
]);
