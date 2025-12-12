<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../../../config/config.php";

$pdo = getDbConnection();

$event_id = $_GET["event_id"] ?? null;

if (!$event_id) {
    echo json_encode(["success" => false, "message" => "Missing event_id"]);
    exit;
}

$stmt = $pdo->prepare("SELECT layout_json FROM event_seat_layouts WHERE event_id = ? LIMIT 1");
$stmt->execute([$event_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(["success" => true, "data" => null]); // no layout saved yet
    exit;
}

echo json_encode([
    "success" => true,
    "data" => json_decode($row["layout_json"], true)
]);
