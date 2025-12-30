<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* ----------------------------------------------------
   1️⃣ READ TOKEN
---------------------------------------------------- */
$token = $_COOKIE["token"] ?? "";

if (!$token) {
    echo json_encode([]);
    exit;
}

/* ----------------------------------------------------
   2️⃣ FETCH USER
---------------------------------------------------- */
$stmt = $pdo->prepare(
    "SELECT user_id FROM users WHERE api_token = ? LIMIT 1"
);
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if (!$user) {
    echo json_encode([]);
    exit;
}

$user_id = $user->user_id;

/* ----------------------------------------------------
   3️⃣ FETCH ITEM CATEGORIES (NO ITEM COUNT YET)
---------------------------------------------------- */
$stmt = $pdo->prepare("
    SELECT 
        id,
        name,
        0 AS items
    FROM item_categories
    WHERE user_id = ?
    ORDER BY id DESC
");

$stmt->execute([$user_id]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
exit;
