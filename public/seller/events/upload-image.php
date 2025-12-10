<?php

// ------------------ CORS FIX ------------------
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

header("Content-Type: application/json");

// Get fields
$userId = $_POST['user_id'] ?? null;
$type   = $_POST['type'] ?? null; // logo or banner

if (!$userId || !$type) {
    echo json_encode([
        "success" => false,
        "message" => "Missing user_id or type"
    ]);
    exit;
}

if (!isset($_FILES['file'])) {
    echo json_encode([
        "success" => false,
        "message" => "No file uploaded"
    ]);
    exit;
}

$file = $_FILES["file"];

$uploadDir = __DIR__ . "/../../../public/uploads/sellers/$userId/events/$type/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = time() . "_" . rand(1000, 9999) . "." . $ext;

$fullPath = $uploadDir . $filename;

if (!move_uploaded_file($file["tmp_name"], $fullPath)) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to save file"
    ]);
    exit;
}

$url = "/uploads/sellers/$userId/events/$type/$filename";

echo json_encode([
    "success" => true,
    "url" => $url
]);

exit;
?>
