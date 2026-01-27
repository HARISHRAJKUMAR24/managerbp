<?php
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

require_once __DIR__ . "/../../../config/config.php";
require_once __DIR__ . "/../../../src/database.php";

$pdo = getDbConnection();

/* READ SELLER ID */
$seller_id = (int)($_GET['seller_id'] ?? 0);

if (!$seller_id) {
    echo json_encode([
        "success" => false,
        "message" => "Missing seller_id"
    ]);
    exit;
}

/* FETCH DEPARTMENTS */
$stmt = $pdo->prepare("
    SELECT *
    FROM departments
    WHERE user_id = ?
    ORDER BY created_at DESC
");

$stmt->execute([$seller_id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* FORMAT SERVICES (type_1_name … type_25_amount) → single array */
$departments = array_map(function ($row) {

    $services = [];

    for ($i = 1; $i <= 25; $i++) {
        $name = $row["type_{$i}_name"];
        $amount = $row["type_{$i}_amount"];

        if ($name !== null && $name !== "") {
            $services[] = [
                "name" => $name,
                "amount" => (float)$amount,
                "hsn" => $row["type_{$i}_hsn"] ?? null
            ];
        }

        unset($row["type_{$i}_name"]);
        unset($row["type_{$i}_amount"]);
        unset($row["type_{$i}_hsn"]);
    }

    $row["services"] = $services;
    return $row;

}, $rows);

/* RESPONSE */
echo json_encode([
    "success" => true,
    "data" => $departments
]);
exit;
