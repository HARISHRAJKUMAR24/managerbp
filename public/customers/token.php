<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* ===============================
   CORS
================================ */
$allowedOrigin = "http://localhost:3001";
header("Access-Control-Allow-Origin: $allowedOrigin");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../config/config.php";
require_once "../../src/database.php";

/* ===============================
   TOKEN FROM COOKIE
================================ */
if (!isset($_COOKIE['token'])) {
    echo json_encode(null);
    exit;
}

$payload = json_decode(base64_decode($_COOKIE['token']), true);

if (!$payload || !isset($payload['customer_id'])) {
    echo json_encode(null);
    exit;
}

$pdo = getDbConnection();

$stmt = $pdo->prepare("
  SELECT customer_id, name, phone, email , photo 
  FROM customers
  WHERE customer_id = ?
  LIMIT 1
");
$stmt->execute([$payload['customer_id']]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo json_encode(null);
    exit;
}

echo json_encode($customer); 