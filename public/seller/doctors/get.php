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

// read raw body for debug
$rawBody = file_get_contents("php://input");
error_log("RAW BODY = " . $rawBody);

$input = json_decode($rawBody, true);
$user_id = $input["user_id"] ?? null;

error_log("parsed user_id=" . print_r($user_id, true));

if (!$user_id) {
    error_log("❌ missing user_id in request");
    echo json_encode([
        "success" => false,
        "message" => "user_id required"
    ]);
    exit();
}

try {

    $sql = "SELECT 
              id,
              user_id,
              category_id,
              doctor_name,
              specialization,
              qualification,
              experience,
              reg_number,
              doctor_image,
              created_at
            FROM doctors
            WHERE user_id = :uid
            ORDER BY id DESC";

    error_log("Executing SQL for uid=" . $user_id);

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":uid", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("Doctor rows returned = " . print_r($rows, true));

    echo json_encode([
        "success" => true,
        "data" => $rows
    ]);
    exit();

} catch (PDOException $e) {
    error_log("SQL ERROR = " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
    exit();
}
