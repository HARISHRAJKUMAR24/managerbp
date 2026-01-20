<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* ===============================
   CORS
================================ */
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");
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

$stmt = $pdo->prepare("SELECT user_id FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit;
}

$user_id = (int)$user['user_id'];

/* ===============================
   INPUT
================================ */
$id = (int)($_GET['id'] ?? 0);
$name = $_POST['name'] ?? '';
$instructions = $_POST['instructions'] ?? '';
$upi_id = $_POST['upi_id'] ?? ''; // 🔥 NEW FIELD

if (!$id || $name === '' || $instructions === '') {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
    exit;
}

/* ===============================
   FILE UPLOADS
================================ */
$year = date('Y');
$month = date('m');
$day = date('d');

$basePublicPath = dirname(__DIR__, 5) . "/public/uploads/sellers/{$user_id}/manual_payment";

$iconPath = null;
$imagePath = null;

/* ---------- LOGO ---------- */
if (!empty($_FILES['icon']['name'])) {
    $logoDir = "{$basePublicPath}/logo/{$year}/{$month}/{$day}/";

    if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);

    $logoName = time() . "_logo_" . basename($_FILES['icon']['name']);
    move_uploaded_file($_FILES['icon']['tmp_name'], $logoDir . $logoName);

    $iconPath = "uploads/sellers/{$user_id}/manual_payment/logo/{$year}/{$month}/{$day}/{$logoName}";
}

/* ---------- IMAGE / QR ---------- */
if (!empty($_FILES['image']['name'])) {
    $imageDir = "{$basePublicPath}/image/{$year}/{$month}/{$day}/";

    if (!is_dir($imageDir)) mkdir($imageDir, 0777, true);

    $imageName = time() . "_image_" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imageDir . $imageName);

    $imagePath = "uploads/sellers/{$user_id}/manual_payment/image/{$year}/{$month}/{$day}/{$imageName}";
}

/* ===============================
   UPDATE QUERY
================================ */
$sql = "
    UPDATE manual_payment_methods 
    SET name = ?, instructions = ?, upi_id = ?";

$params = [$name, $instructions, $upi_id];

/* Append uploaded file paths */
if ($iconPath) {
    $sql .= ", icon = ?";
    $params[] = $iconPath;
}

if ($imagePath) {
    $sql .= ", image = ?";
    $params[] = $imagePath;
}

$sql .= " WHERE id = ? AND user_id = ?";
$params[] = $id;
$params[] = $user_id;

/* Execute Update */
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

/* ===============================
   RESPONSE
================================ */
echo json_encode([
    "success" => true,
    "message" => "Manual payment method updated successfully"
]);
