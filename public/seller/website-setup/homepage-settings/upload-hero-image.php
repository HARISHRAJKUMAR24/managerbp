<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") exit;

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();

$user_id = $_GET["user_id"] ?? null;
if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit;
}

if (!isset($_FILES["file"])) {
    echo json_encode(["success" => false, "message" => "No file uploaded"]);
    exit;
}

$file = $_FILES["file"];
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);

$filename = "hero_" . time() . "." . $ext;
$uploadDir = "../../../uploads/sellers/$user_id/website/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$path = $uploadDir . $filename;

if (move_uploaded_file($file["tmp_name"], $path)) {
    echo json_encode([
        "success" => true,
        "filename" => "sellers/$user_id/website/" . $filename
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}
