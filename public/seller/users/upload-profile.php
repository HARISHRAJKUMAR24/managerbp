<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// Get user ID
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($userId <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid user ID"
    ]);
    exit;
}

// Check file
if (!isset($_FILES['file'])) {
    echo json_encode([
        "success" => false,
        "message" => "No file uploaded"
    ]);
    exit;
}

// Build correct upload directory:
// managerbp/public/uploads/sellers/<userId>/profile/
$basePath = __DIR__ . "/../../../public/uploads/sellers/$userId/profile/";

// Create folder if needed
if (!is_dir($basePath)) {
    mkdir($basePath, 0777, true);
}

// Sanitize filename
$originalName = basename($_FILES["file"]["name"]);
$cleanName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $originalName);
$filename = time() . "_" . $cleanName;

// Final server path
$targetFile = $basePath . $filename;

// Move file
if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {

    // Return the path EXACT as your requirement
    echo json_encode([
        "success" => true,
        "filename" => "sellers/$userId/profile/$filename"
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Upload failed"
    ]);
}
