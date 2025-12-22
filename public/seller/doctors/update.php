<?php
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$input = json_decode(file_get_contents("php://input"), true);

$user_id      = $input["user_id"] ?? null;  // ⭐ MUST ADD THIS
$category_id  = $input["category_id"] ?? null;
$doctor_name  = $input["doctor_name"] ?? "";
$specialization = $input["specialization"] ?? "";
$qualification = $input["qualification"] ?? "";
$experience   = $input["experience"] ?? null;
$reg_number   = $input["reg_number"] ?? "";
$doctor_image = $input["doctor_image"] ?? null;

try {

    $sql = "INSERT INTO doctors
            (user_id, category_id, doctor_name, specialization, qualification, experience, reg_number, doctor_image)
            VALUES 
            (:user_id, :category_id, :doctor_name, :specialization, :qualification, :experience, :reg_number, :doctor_image)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':user_id' => $user_id,
        ':category_id' => $category_id,
        ':doctor_name' => $doctor_name,
        ':specialization' => $specialization,
        ':qualification' => $qualification,
        ':experience' => $experience,
        ':reg_number' => $reg_number,
        ':doctor_image' => $doctor_image
    ]);

    echo json_encode(["success" => true]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
