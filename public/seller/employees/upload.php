<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// -----------------------------
// Validate user ID
// -----------------------------
if (!isset($_GET["user_id"])) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit();
}

$userId = $_GET["user_id"];

// -----------------------------
// Create folder: uploads/sellers/{user_id}/employees/YYYY/MM/DD
// -----------------------------
$year = date("Y");
$month = date("m");
$day = date("d");

$uploadDir = "../../uploads/sellers/$userId/employees/$year/$month/$day/";

// Create directories
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// -----------------------------
// Validate file
// -----------------------------
if (!isset($_FILES["file"])) {
    echo json_encode(["success" => false, "message" => "No file received"]);
    exit();
}

$file = $_FILES["file"];
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = uniqid("emp_") . "." . $ext;

$path = $uploadDir . $filename;

// -----------------------------
// Save file
// -----------------------------
if (move_uploaded_file($file["tmp_name"], $path)) {

    // relative path saved in DB:
    // sellers/{user_id}/employees/YYYY/MM/DD/file.ext
    $relativePath = "$userId/employees/$year/$month/$day/$filename";

    echo json_encode([
        "success" => true,
        "filename" => $relativePath
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}
