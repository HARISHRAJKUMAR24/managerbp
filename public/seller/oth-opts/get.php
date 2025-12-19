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

$searchSql = "";
$params = [':user_id' => $user_id];

if (!empty($q)) {
    $searchSql = " AND (d.name LIKE :search OR d.slug LIKE :search OR d.type LIKE :search) ";
    $params[':search'] = "%$q%";
}

$countSql = "SELECT COUNT(*) 
             FROM departments d
             WHERE d.user_id = :user_id  
             $searchSql";

$countStmt = $pdo->prepare($countSql);
if (!empty($q)) $countStmt->bindValue(':search', "%$q%", PDO::PARAM_STR);
$countStmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$countStmt->execute();

$totalRecords = $countStmt->fetchColumn();

$baseImageUrl = "http://localhost/managerbp/public/uploads/";

$sql = "SELECT 
            d.id,
            d.department_id,
            d.user_id,
            d.name,
            d.type,
            d.slug,

            CASE 
                WHEN d.image IS NULL OR d.image = '' 
                    THEN NULL
                ELSE CONCAT('$baseImageUrl', d.image) 
            END AS image,

            d.meta_title,
            d.meta_description,
            d.created_at,
            d.updated_at

        FROM departments d
        WHERE d.user_id = :user_id 
        $searchSql

        ORDER BY d.id DESC
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

exit();
?>