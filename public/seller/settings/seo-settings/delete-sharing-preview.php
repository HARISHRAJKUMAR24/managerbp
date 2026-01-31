<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Content-Type: application/json");

// Read old file BEFORE upload
$oldFile = $_POST["old_file"] ?? "";

// ========================
// DELETE OLD FILE (if any)
// ========================
if (!empty($oldFile)) {

    // Normalize
    $clean = str_replace(["../uploads/", "/uploads/"], "", $oldFile);
    $clean = ltrim($clean, "/");

    if (!str_starts_with($clean, "sellers/")) {
        $clean = "sellers/" . $clean;
    }

    $uploadsRoot = realpath(__DIR__ . "/../../../uploads");
    $oldFilePath = $uploadsRoot . "/" . $clean;

    if (file_exists($oldFilePath)) {
        unlink($oldFilePath);
    }
}

// ========================
// VALIDATE NEW FILE
// ========================
if (!isset($_FILES["file"])) {
    echo json_encode(["success" => false, "message" => "No file uploaded"]);
    exit;
}

$userId = $_POST["user_id"] ?? "unknown";

// KEEP SAME FOLDER ALWAYS — NOT DATE BASED
$folderPath = __DIR__ . "/../../../uploads/sellers/$userId/seo-settings/preview-image/";

if (!is_dir($folderPath)) {
    mkdir($folderPath, 0777, true);
}

// New filename
$original = $_FILES["file"]["name"];
$cleanName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $original);
$filename = "preview_" . uniqid() . "_" . $cleanName;

$targetFile = $folderPath . $filename;

// Save new file
if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
    exit;
}

// Return path without date folder
$returnPath = "sellers/$userId/seo-settings/preview-image/$filename";

echo json_encode([
    "success" => true,
    "filename" => $returnPath
]);
