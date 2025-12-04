<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

$userId = $_GET['user_id'] ?? 0;

if (!isset($_FILES['file'])) {
    echo json_encode(["success" => false, "message" => "No file uploaded"]);
    exit;
}

$folder = "../../../uploads/user/$userId/profile/";
if (!file_exists($folder)) mkdir($folder, 0777, true);

$filename = time() . "_" . basename($_FILES["file"]["name"]);
$target = $folder . $filename;

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target)) {
    echo json_encode([
        "success" => true,
        "filename" => "user/$userId/profile/" . $filename
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}
