<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// GET params
$user_id = $_GET['user_id'] ?? '';
$limit   = $_GET['limit'] ?? 10;
$page    = $_GET['page'] ?? 1;
$q       = $_GET['q'] ?? '';

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "user_id is required"
    ]);
    exit();
}

$offset = ($page - 1) * $limit;

// 🔍 Search filter
$searchSql = "";
$params = [':user_id' => $user_id];

if (!empty($q)) {
    $searchSql = " AND (name LIKE :search OR slug LIKE :search) ";
    $params[':search'] = "%$q%";
}

// Count total
$countSql = "SELECT COUNT(*) FROM categories WHERE user_id = :user_id $searchSql";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalRecords = $countStmt->fetchColumn();

// ⭐ FIXED: Correct URL for stored category images
$baseImageUrl = "http://localhost/managerbp/public/uploads/";

$sql = "SELECT 
            id, 
            category_id, 
            user_id, 
            name, 
            slug, 
CASE 
    WHEN image IS NULL OR image = '' 
        THEN NULL 
    ELSE CONCAT('$baseImageUrl', image) 
END AS image,
            meta_title, 
            meta_description, 
            created_at
        FROM categories
        WHERE user_id = :user_id $searchSql
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
if (!empty($q)) $stmt->bindValue(':search', "%$q%", PDO::PARAM_STR);
$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "records" => $records,
    "totalRecords" => (int)$totalRecords,
    "totalPages" => ceil($totalRecords / $limit)
]);
