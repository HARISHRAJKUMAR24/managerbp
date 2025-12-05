<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
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

// ADDITIONAL IMAGES PATH: services/additional/user_id/year/month/day/
$relativePath = "services/additional/$user_id/$year/$month/$day/";
$uploadDir = "../../../public/uploads/" . $relativePath;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES["files"])) {
    echo json_encode(["success" => false, "message" => "No files uploaded"]);
    exit();
}

$files = $_FILES["files"];
$stored = [];

if (is_array($files["name"])) {
    for ($i = 0; $i < count($files["name"]); $i++) {
        if ($files["error"][$i] !== UPLOAD_ERR_OK) {
            continue;
        }
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($files["tmp_name"][$i]);
        
        if (!in_array($fileType, $allowedTypes)) {
            continue;
        }
        
        $ext = pathinfo($files["name"][$i], PATHINFO_EXTENSION);
        $filename = uniqid("add_") . "." . $ext;
        $fullPath = $uploadDir . $filename;
        
        if (move_uploaded_file($files["tmp_name"][$i], $fullPath)) {
            $stored[] = $relativePath . $filename;
        }
    }
}

if (empty($stored)) {
    echo json_encode([
        "success" => false,
        "message" => "No files were successfully uploaded"
    ]);
    exit();
}

echo json_encode([
    "success" => true,
    "files" => $stored,
    "message" => count($stored) . " file(s) uploaded successfully"
]);
?>