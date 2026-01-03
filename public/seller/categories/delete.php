<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* -----------------------------------------
   READ JSON BODY
----------------------------------------- */
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

/* -----------------------------------------
   GET PARAMS (JSON > GET fallback)
----------------------------------------- */
$category_id = $data['category_id'] ?? $_GET['category_id'] ?? null;
$user_id     = $data['user_id'] ?? $_GET['user_id'] ?? null;

/* -----------------------------------------
   VALIDATION
----------------------------------------- */
if (!$category_id) {
    echo json_encode([
        "success" => false,
        "message" => "Category ID missing"
    ]);
    exit();
}

/* -----------------------------------------
   DELETE (SECURE)
----------------------------------------- */
$sql = "DELETE FROM categories 
        WHERE category_id = :category_id 
        AND user_id = :user_id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':category_id' => $category_id,
    ':user_id'     => $user_id,
]);

if ($stmt->rowCount() === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Category not found or already deleted"
    ]);
    exit();
}

/* -----------------------------------------
   SUCCESS
----------------------------------------- */
echo json_encode([
    "success" => true,
    "message" => "Category deleted successfully"
]);
exit();
