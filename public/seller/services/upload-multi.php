<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if (!isset($_GET["user_id"])) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit();
}

$userId = $_GET["user_id"];

$year = date("Y");
$month = date("m");
$day = date("d");

$uploadDir = "../../uploads/sellers/$userId/services/additional/$year/$month/$day/";

if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

if (!isset($_FILES["files"])) {
    echo json_encode(["success" => false, "message" => "No files"]);
    exit();
}

$files = $_FILES["files"];

$stored = [];

for ($i = 0; $i < count($files["name"]); $i++) {
    $ext = pathinfo($files["name"][$i], PATHINFO_EXTENSION);
    $filename = uniqid("svc_add_") . "." . $ext;
    $path = $uploadDir . $filename;

    if (move_uploaded_file($files["tmp_name"][$i], $path)) {
        $stored[] = "$userId/services/additional/$year/$month/$day/$filename";
    }
}

echo json_encode([
    "success" => true,
    "files" => $stored
]);
?>
