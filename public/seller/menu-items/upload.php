<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

/* ===============================
   HEADERS / CORS
================================ */
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

/* ===============================
   DB + AUTH (COOKIE TOKEN)
================================ */
require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$token = $_COOKIE['token'] ?? '';
if (!$token) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$stmt = $pdo->prepare("SELECT user_id FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit;
}

$user_id = (int)$user->user_id;

/* ===============================
   FILE CHECK
================================ */
if (!isset($_FILES['file'])) {
    echo json_encode(["success" => false, "message" => "No image received"]);
    exit;
}

$file = $_FILES['file'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "message" => "Upload error"]);
    exit;
}

/* ===============================
   VALIDATION
================================ */
$allowed = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
];

if (!isset($allowed[$file['type']])) {
    echo json_encode(["success" => false, "message" => "Invalid image type"]);
    exit;
}

if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode(["success" => false, "message" => "Image must be under 5MB"]);
    exit;
}

/* ===============================
   CORRECT DIRECTORY (🔥 FIXED)
================================ */
$year  = date('Y');
$month = date('m');
$day   = date('d');

$uploadBase = __DIR__ . "/../../uploads"; // ✅ public/uploads
$relativeDir = "sellers/$user_id/menu-settings/$year/$month/$day";
$uploadDir = $uploadBase . "/" . $relativeDir;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

/* ===============================
   SAFE FILE NAME
================================ */
$ext = $allowed[$file['type']];
$name = pathinfo($file['name'], PATHINFO_FILENAME);
$name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);

$fileName = $name . "_" . time() . "." . $ext;
$fullPath = $uploadDir . "/" . $fileName;

if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
    echo json_encode(["success" => false, "message" => "Failed to save image"]);
    exit;
}

/* ===============================
   SUCCESS RESPONSE
================================ */
echo json_encode([
    "success"  => true,
    "imageUrl" => "/uploads/" . $relativeDir . "/" . $fileName
]);
exit;
