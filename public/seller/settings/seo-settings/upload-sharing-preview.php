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

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";
require_once "../../../../src/auth.php";

$pdo = getDbConnection();

/* ================= AUTH ================= */

$user = getAuthenticatedUser($pdo);
$user_id = $user['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User not authenticated"
    ]);
    exit;
}

/* ================= FILE CHECK ================= */

if (!isset($_FILES["file"])) {
    echo json_encode([
        "success" => false,
        "message" => "No file uploaded"
    ]);
    exit;
}

/* ================= PATH ================= */

$relativePath = "sellers/{$user_id}/site-settings/seo/";
$uploadDir = "../../../../uploads/" . $relativePath;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* ================= UPLOAD ================= */

$file = $_FILES["file"];
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = uniqid("seo_") . "." . $ext;

if (!move_uploaded_file($file["tmp_name"], $uploadDir . $filename)) {
    echo json_encode([
        "success" => false,
        "message" => "Upload failed"
    ]);
    exit;
}

/* ================= RESPONSE ================= */

echo json_encode([
    "success" => true,
    "filename" => $relativePath . $filename
]);
