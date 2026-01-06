<?php
// seller/dashboard-messages/get.php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

/*
|--------------------------------------------------------------------------
| CORRECT PATHS (same pattern as coupons)
|--------------------------------------------------------------------------
| File location:
| public/seller/dashboard-messages/get.php
| Go up 3 levels → project root
*/
require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/*
|--------------------------------------------------------------------------
| INPUT
|--------------------------------------------------------------------------
*/
$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User ID required",
        "data" => null
    ]);
    exit();
}

/*
|--------------------------------------------------------------------------
| FETCH ACTIVE DASHBOARD MESSAGE
|--------------------------------------------------------------------------
| - expiry_date must be in future
| - latest message only
*/
$sql = "
    SELECT
        id,
        title,
        description,
        expiry_date,
        seller_type,
        just_created_seller
    FROM dashboard_messages
    WHERE expiry_date > NOW()
    ORDER BY created_at DESC
    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$message = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| RESPONSE
|--------------------------------------------------------------------------
*/
echo json_encode([
    "success" => true,
    "data" => $message ?: null
]);
exit();
