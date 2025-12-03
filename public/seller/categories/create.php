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

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID missing"]);
    exit();
}

// Read JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid JSON"]);
    exit();
}

// Generate category id
$category_id = "CAT_" . uniqid();

// Required fields
$name  = trim($data['name'] ?? '');
$slug  = trim($data['slug'] ?? '');

// Image filename (must be non-null)
$image = $data['image'] ?? '';
if ($image === null) $image = "";

// Optional fields (snake_case!)
$meta_title = $data['meta_title'] ?? null;
$meta_desc  = $data['meta_description'] ?? null;

if ($name === '' || $slug === '') {
    echo json_encode(["success" => false, "message" => "Name & slug required"]);
    exit();
}

$sql = "INSERT INTO categories 
        (category_id, user_id, name, slug, image, meta_title, meta_description, created_at)
        VALUES (:cid, :uid, :name, :slug, :image, :mtitle, :mdesc, NOW(3))";

$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    ':cid' => $category_id,
    ':uid' => $user_id,
    ':name' => $name,
    ':slug' => $slug,
    ':image' => $image,
    ':mtitle' => $meta_title,
    ':mdesc' => $meta_desc
]);

echo json_encode([
    "success" => $result,
    "message" => $result ? "Category created" : "Insert failed",
    "category_id" => $category_id
]);
