<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$user_id = $_GET['user_id'] ?? '';

if(!$user_id){
    echo json_encode([
        "success" => false,
        "message" => "user_id required"
    ]);
    exit();
}

$sql = "SELECT 
          id,
          user_id,
          category_id,
          doctor_name,
          specialization,
          qualification,
          experience,
          reg_number,
          image,
          created_at
        FROM doctors
        WHERE user_id = :user_id
        ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "records" => $data
]);
exit();
