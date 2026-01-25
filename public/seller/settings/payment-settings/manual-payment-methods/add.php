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
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);
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
    echo json_encode([
        "success" => false,
        "message" => "Invalid token"
    ]);
    exit;
}

$user_id = (int)$user['user_id'];

/* ===============================
   INPUT VALIDATION
================================ */
$name = trim($_POST['name'] ?? '');
$instructions = trim($_POST['instructions'] ?? '');
$upi_id = trim($_POST['upi_id'] ?? ''); // ✅ UPI ID field

if (empty($name) || empty($instructions)) {
    echo json_encode([
        "success" => false,
        "message" => "Name and instructions are required"
    ]);
    exit;
}

/* ===============================
   FILE UPLOAD HANDLING (ICON ONLY)
================================ */
$year  = date('Y');
$month = date('m');
$day   = date('d');

$basePublicPath = dirname(__DIR__, 5) . "/public/uploads/sellers/{$user_id}/manual_payment";

$iconPath = null;
if (!empty($_FILES['icon']['name']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
    $iconDir = "{$basePublicPath}/{$year}/{$month}/{$day}/";
    
    if (!is_dir($iconDir)) {
        mkdir($iconDir, 0777, true);
    }

    // Generate unique filename
    $fileExt = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
    $uniqueName = time() . "_" . uniqid() . "." . $fileExt;
    
    $targetPath = $iconDir . $uniqueName;
    
    if (move_uploaded_file($_FILES['icon']['tmp_name'], $targetPath)) {
        $iconPath = "uploads/sellers/{$user_id}/manual_payment/{$year}/{$month}/{$day}/{$uniqueName}";
    }
}

/* ===============================
   INSERT QUERY (UPDATED - NO IMAGE FIELD)
================================ */
$stmt = $pdo->prepare("
    INSERT INTO manual_payment_methods
    (user_id, name, upi_id, instructions, icon, created_at)
    VALUES (?, ?, ?, ?, ?, NOW(3))
");

$success = $stmt->execute([
    $user_id,
    $name,
    $upi_id ?: null, // Store null if empty
    $instructions,
    $iconPath ?: null
]);

if (!$success) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to save payment method"
    ]);
    exit;
}

/* ===============================
   SUCCESS RESPONSE
================================ */
echo json_encode([
    "success" => true,
    "message" => "Manual payment method added successfully",
    "id" => $pdo->lastInsertId()
]);