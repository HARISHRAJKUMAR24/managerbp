<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* ===============================
   CORS
================================ */
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin === 'http://localhost:3000') {
    header("Access-Control-Allow-Origin: $origin");
}
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

/* ===============================
   INCLUDES
================================ */
require_once dirname(__DIR__, 5) . "/src/database.php";

$pdo = getDbConnection();

/* ===============================
   AUTH
================================ */
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

if (strpos($authHeader, 'Bearer ') !== 0) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$token = trim(substr($authHeader, 7));

$stmt = $pdo->prepare("
    SELECT user_id
    FROM users
    WHERE api_token = ?
    LIMIT 1
");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit;
}

$user_id = (int)$user['user_id']; // ✅ matches FK

/* ===============================
   FETCH
================================ */
$stmt = $pdo->prepare("
    SELECT id, name, instructions, icon, image, created_at
    FROM manual_payment_methods
    WHERE user_id = ?
    ORDER BY id DESC
");
$stmt->execute([$user_id]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "records" => $records
]);
