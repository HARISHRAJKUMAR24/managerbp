<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$user_id = $_GET["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit();
}

$year = date("Y");
$month = date("m");
$day = date("d");

$folder = "../../../public/uploads/sellers/$user_id/services/$year/$month/$day/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

if (!isset($_FILES["file"])) {
    echo json_encode(["success" => false, "message" => "No file received"]);
    exit();
}

$file = $_FILES["file"];
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = uniqid("srv_") . "." . $ext;

$target = $folder . $filename;

if (move_uploaded_file($file["tmp_name"], $target)) {

    // RETURN RELATIVE PATH
    $path = "sellers/$user_id/services/$year/$month/$day/$filename";

    echo json_encode([
        "success" => true,
        "filename" => $path
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}
