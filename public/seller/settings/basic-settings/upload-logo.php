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
$user_id = $_GET["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit();
}

$year = date("Y");
$month = date("m");
$day = date("d");

// Logo upload path
$relativePath = "settings/logo/$user_id/$year/$month/$day/";
$uploadDir = "../../../public/uploads/" . $relativePath;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES["logo"])) {
    echo json_encode(["success" => false, "message" => "No file received"]);
    exit();
}

$file = $_FILES["logo"];
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = uniqid("logo_") . "." . $ext;

$target = $uploadDir . $filename;

// Validate file type
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
$fileType = mime_content_type($file["tmp_name"]);

if (!in_array($fileType, $allowedTypes)) {
    echo json_encode(["success" => false, "message" => "Invalid file type. Only JPG, PNG, GIF, WEBP, SVG allowed"]);
    exit();
}

if (move_uploaded_file($file["tmp_name"], $target)) {
    $relativeFilePath = $relativePath . $filename;
    
    echo json_encode([
        "success" => true,
        "filename" => $relativeFilePath,
        "message" => "Logo uploaded successfully"
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}
?>