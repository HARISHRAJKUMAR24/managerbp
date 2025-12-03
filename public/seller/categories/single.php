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

$category_id = $_GET['category_id'] ?? '';

if (!$category_id) {
    echo json_encode(["success" => false, "message" => "Category ID missing"]);
    exit();
}

$sql = "SELECT 
            id,
            category_id,
            user_id,
            name,
            slug,
            CONCAT('http://localhost/managerbp/public/uploads/categories/', image) AS image,
            meta_title,
            meta_description,
            created_at
        FROM categories 
        WHERE category_id = :cid
        LIMIT 1";


$stmt = $pdo->prepare($sql);
$stmt->execute([':cid' => $category_id]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Category not found"]);
    exit();
}

echo json_encode([
    "success" => true,
    "data" => $data
]);
