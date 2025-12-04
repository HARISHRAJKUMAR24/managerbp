<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$sql = "SELECT * FROM subscription_plans WHERE is_disabled = 0 ORDER BY amount ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert feature_lists string → array
foreach ($data as &$row) {
    $list = $row["feature_lists"];

    // split by comma, trim spaces
    $arr = array_filter(array_map('trim', explode(",", $list)));

    // return as array instead of string
    $row["feature_lists"] = $arr;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);
