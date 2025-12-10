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

$category_id = $_GET['category_id'] ?? '';

if (!$category_id) {
    echo json_encode(["success" => false, "message" => "Category ID required"]);
    exit();
}

// Read JSON body
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid JSON"]);
    exit();
}

// ❌ REMOVE token from update fields
if (isset($data["token"])) unset($data["token"]);

// ❌ DO NOT allow user_id OR category_id to be overwritten
unset($data["user_id"]);
unset($data["category_id"]);
unset($data["created_at"]);

// Check if category exists
$check = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE category_id = :cid");
$check->execute([':cid' => $category_id]);

if ($check->fetchColumn() == 0) {
    echo json_encode(["success" => false, "message" => "Category not found"]);
    exit();
}

// Build SQL dynamically
$fields = [];
$params = [':cid' => $category_id];

foreach ($data as $key => $value) {
    $fields[] = "$key = :$key";
    $params[":$key"] = $value ?? '';
}

$sql = "UPDATE categories SET " . implode(", ", $fields) . " WHERE category_id = :cid";

$stmt = $pdo->prepare($sql);
$result = $stmt->execute($params);

echo json_encode([
    "success" => $result,
    "message" => $result ? "Category updated successfully" : "Update failed"
]);
