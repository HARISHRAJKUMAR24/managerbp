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
    $searchSql = " AND (c.name LIKE :search OR c.slug LIKE :search) ";
    $params[':search'] = "%$q%";
}

$countSql = "SELECT COUNT(*) 
             FROM categories c
             WHERE c.user_id = :user_id  
             $searchSql";

$countStmt = $pdo->prepare($countSql);
$countStmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
if (!empty($q)) $countStmt->bindValue(':search', "%$q%", PDO::PARAM_STR);
$countStmt->execute();

$totalRecords = $countStmt->fetchColumn();

$baseImageUrl = "http://localhost/managerbp/public/uploads/";

$sql = "SELECT 
    c.id,
    c.category_id,
    c.user_id,
    c.name,
    c.slug,
    c.meta_title,
    c.meta_description,
    c.created_at,

    d.doctor_name,
    d.specialization,
    d.qualification,
    d.experience,
    d.reg_number,
    d.doctor_image

FROM categories c
LEFT JOIN doctors d
ON d.category_id = c.id
WHERE c.user_id = :user_id 
$searchSql
ORDER BY c.id DESC
LIMIT :limit OFFSET :offset";


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
if (!empty($q)) $stmt->bindValue(':search', "%$q%", PDO::PARAM_STR);
$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($records as &$row) {
    if (!empty($row['doctor_image'])) {
        $row['doctor_image'] = $baseImageUrl . $row['doctor_image'];
    }
}
unset($row);


error_log("----- CATEGORY GET.PHP LOG START -----");
error_log("USER_ID = " . $user_id);
error_log("RECORD COUNT = " . count($records));
error_log(print_r($records, true));
error_log("----- CATEGORY GET.PHP LOG END -----");

error_log("---- CATEGORY GET.PHP OUTPUT ----");
error_log(print_r($records, true));

echo json_encode([
    "success" => true,
    "records" => $records,
    "totalRecords" => (int)$totalRecords,
    "totalPages" => ceil($totalRecords / $limit)
]);
exit();
