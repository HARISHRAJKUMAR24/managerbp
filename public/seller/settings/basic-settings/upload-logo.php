<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

$user_id = $_GET["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID missing"]);
    exit();
}

if (!isset($_FILES["file"])) {
    echo json_encode(["success" => false, "message" => "No file uploaded"]);
    exit();
}

// SAME AS FAVICON - MATCHED FIX
$relativePath = "sellers/$user_id/site-settings/logo/";
$uploadDir = "../../../uploads/" . $relativePath;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$file = $_FILES["file"];
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = uniqid("logo_") . "." . $ext;

if (move_uploaded_file($file["tmp_name"], $uploadDir . $filename)) {
    echo json_encode([
        "success" => true,
        "filename" => $relativePath . $filename
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}
?>
