<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../seller/functions.php';

$pdo = getDbConnection();

$user_id = $_POST["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit;
}

$title = $_POST["title"] ?? "";
$date = $_POST["date"] ?? "";
$location = $_POST["location"] ?? "";
$organizer = $_POST["organizer"] ?? "";
$category = $_POST["category"] ?? "";
$status = $_POST["status"] ?? "active";
$description = $_POST["description"] ?? "";

$banner = null;

if (!empty($_FILES["banner"]["name"])) {
    $upload = uploadImage($_FILES["banner"], "events");
    if ($upload["success"]) {
        $banner = $upload["file_name"];
    }
}

$sql = "INSERT INTO events (user_id, title, description, date, location, organizer, category, status, banner)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);

$success = $stmt->execute([
    $user_id, $title, $description, $date, $location,
    $organizer, $category, $status, $banner
]);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Event added successfully" : "Failed to add event"
]);
?>
