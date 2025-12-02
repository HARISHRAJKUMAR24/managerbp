<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

$uploadDir = "../../uploads/employees/"; // FIXED PATH

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES['file'])) {
    echo json_encode(["success" => false, "message" => "No file received"]);
    exit;
}

$file = $_FILES['file'];
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = uniqid() . "." . $ext;
$path = $uploadDir . $filename;

if (move_uploaded_file($file["tmp_name"], $path)) {
    echo json_encode([
        "success" => true,
        "filename" => $filename   // IMPORTANT → send filename
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}
