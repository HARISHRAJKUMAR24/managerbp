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

$sql = "UPDATE events SET 
        title = ?, description = ?, date = ?, location = ?, 
        organizer = ?, category = ?, status = ?" . 
        ($banner ? ", banner = ?" : "") . 
        " WHERE id = ?";

$stmt = $pdo->prepare($sql);

$params = [
    $title, $description, $date, $location,
    $organizer, $category, $status
];

if ($banner) {
    $params[] = $banner;
}

$params[] = $id;

$success = $stmt->execute($params);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Event updated successfully" : "Update failed"
]);
?>
