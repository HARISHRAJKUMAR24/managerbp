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
   INPUT VALIDATION
================================ */
$id = (int)($_GET['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$instructions = trim($_POST['instructions'] ?? '');
$upi_id = trim($_POST['upi_id'] ?? ''); // ✅ UPI ID field

if (!$id || empty($name) || empty($instructions)) {
    echo json_encode([
        "success" => false, 
        "message" => "ID, name and instructions are required"
    ]);
    exit;
}

/* ===============================
   CHECK IF RECORD EXISTS AND BELONGS TO USER
================================ */
$checkStmt = $pdo->prepare("
    SELECT id FROM manual_payment_methods 
    WHERE id = ? AND user_id = ?
    LIMIT 1
");
$checkStmt->execute([$id, $user_id]);
$exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

if (!$exists) {
    echo json_encode([
        "success" => false, 
        "message" => "Payment method not found or unauthorized"
    ]);
    exit;
}

/* ===============================
   FILE UPLOAD (ICON ONLY)
================================ */
$iconPath = null;
if (!empty($_FILES['icon']['name']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    
    $basePublicPath = dirname(__DIR__, 5) . "/public/uploads/sellers/{$user_id}/manual_payment";
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
   UPDATE QUERY (NO IMAGE FIELD)
================================ */
// Build dynamic query based on whether icon is being updated
$sql = "UPDATE manual_payment_methods SET 
        name = ?, 
        upi_id = ?, 
        instructions = ?";
    
$params = [$name, $upi_id ?: null, $instructions];

// Add icon if uploaded
if ($iconPath) {
    $sql .= ", icon = ?";
    $params[] = $iconPath;
}

$sql .= " WHERE id = ? AND user_id = ?";
$params[] = $id;
$params[] = $user_id;

/* Execute Update */
$stmt = $pdo->prepare($sql);
$success = $stmt->execute($params);

if (!$success) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to update payment method"
    ]);
    exit;
}

/* ===============================
   SUCCESS RESPONSE
================================ */
echo json_encode([
    "success" => true,
    "message" => "Manual payment method updated successfully"
]);