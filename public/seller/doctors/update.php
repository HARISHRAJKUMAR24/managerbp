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

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$input = json_decode(file_get_contents("php://input"), true);

$category_id   = $input["category_id"] ?? null;
$doctor_name   = $input["doctor_name"] ?? null;
$specialization = $input["specialization"] ?? null;
$qualification = $input["qualification"] ?? null;
$experience    = $input["experience"] ?? null;
$reg_number    = $input["reg_number"] ?? null;
$doctor_image  = $input["doctor_image"] ?? null;

if (!$category_id) {
    echo json_encode([
        "success" => false,
        "message" => "category_id required for update"
    ]);
    exit();
}

$sql = "UPDATE doctors SET 
        doctor_name = :doctor_name,
        specialization = :specialization,
        qualification = :qualification,
        experience = :experience,
        reg_number = :reg_number,
        doctor_image = :doctor_image
        WHERE category_id = :category_id";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(":doctor_name", $doctor_name);
$stmt->bindValue(":specialization", $specialization);
$stmt->bindValue(":qualification", $qualification);
$stmt->bindValue(":experience", $experience);
$stmt->bindValue(":reg_number", $reg_number);
$stmt->bindValue(":doctor_image", $doctor_image);
$stmt->bindValue(":category_id", $category_id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Doctor updated successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Doctor update failed"
    ]);
}
