<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../seller/functions.php';

$pdo = getDbConnection();

$user_id = $_GET['user_id'] ?? null;
$limit   = intval($_GET['limit'] ?? 10);
$page    = intval($_GET['page'] ?? 1);
$q       = trim($_GET['q'] ?? "");

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "user_id missing",
        "records" => [],
        "totalPages" => 1,
        "totalRecords" => 0
    ]);
    exit;
}

$offset = ($page - 1) * $limit;

// COUNT
$countSql = "SELECT COUNT(*) FROM events WHERE user_id = :user_id";
$countParams = ["user_id" => $user_id];

if ($q !== "") {
    $countSql .= " AND (title LIKE :q OR location LIKE :q OR organizer LIKE :q)";
    $countParams["q"] = "%$q%";
}

$stmt = $pdo->prepare($countSql);
$stmt->execute($countParams);
$totalRecords = $stmt->fetchColumn();

// GET RECORDS
$sql = "SELECT * FROM events WHERE user_id = :user_id";
$params = ["user_id" => $user_id];

if ($q !== "") {
    $sql .= " AND (title LIKE :q OR location LIKE :q OR organizer LIKE :q)";
    $params["q"] = "%$q%";
}

$sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue(":$key", $value);
}
$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "records" => $records,
    "totalRecords" => $totalRecords,
    "totalPages" => ceil($totalRecords / $limit)
]);
?>
