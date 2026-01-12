<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* ===============================
   CORS
================================ */
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

/* ===============================
   INCLUDES
================================ */
require_once __DIR__ . "/../../../../config/config.php";
require_once __DIR__ . "/../../../../src/database.php";


/* ===============================
   AUTH
================================ */
$data = json_decode(file_get_contents("php://input"), true);

$token = $data['token'] ?? null;

if (!$token) {
  echo json_encode([
    "success" => false,
    "message" => "Unauthorized"
  ]);
  exit;
}

$payload = json_decode(base64_decode($token), true);
$userId = $payload['user_id'] ?? null;

if (!$userId) {
  echo json_encode([
    "success" => false,
    "message" => "Invalid token"
  ]);
  exit;
}

/* ===============================
   INPUT
================================ */
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
  echo json_encode(["success" => false, "message" => "Invalid payload"]);
  exit;
}

/* ===============================
   FIELD MAP (FRONTEND → DB)
================================ */
$fieldMap = [
  "cashInHand"         => "cash_in_hand",
  "razorpayKeyId"      => "razorpay_key_id",
  "phonepeSaltKey"     => "phonepe_salt_key",
  "phonepeSaltIndex"   => "phonepe_salt_index",
  "phonepeMerchantId"  => "phonepe_merchant_id",
  "payuApiKey"         => "payu_api_key",
  "payuSalt"           => "payu_salt",
];

$set = [];
$values = [];

foreach ($fieldMap as $frontendKey => $dbColumn) {
  if (array_key_exists($frontendKey, $data)) {
    $set[] = "$dbColumn = ?";
    $values[] = $data[$frontendKey];
  }
}

if (empty($set)) {
  echo json_encode(["success" => false, "message" => "No valid fields"]);
  exit;
}

/* ===============================
   UPDATE DB
================================ */
$pdo = getDbConnection();

$sql = "UPDATE site_settings SET " . implode(", ", $set) . " WHERE user_id = ?";
$values[] = $userId;

$stmt = $pdo->prepare($sql);
$stmt->execute($values);

echo json_encode([
  "success" => true,
  "message" => "Payment settings updated successfully"
]);
