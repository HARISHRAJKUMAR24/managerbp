<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$department_uid = $_GET['department_id'] ?? '';
$user_id = $_GET['user_id'] ?? '';

if (!$department_uid) {
    echo json_encode(["success" => false, "message" => "Department ID required"]);
    exit();
}

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID required"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    echo json_encode(["success" => false, "message" => "Invalid JSON"]);
    exit();
}

/* remove restricted fields */
unset($data["token"]);
unset($data["created_at"]);
unset($data["updated_at"]);
unset($data["department_id"]);
unset($data["user_id"]);

/* find department */
$stmt = $pdo->prepare("SELECT id FROM departments WHERE department_id = ? AND user_id = ? LIMIT 1");
$stmt->execute([$department_uid, $user_id]);
$department = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$department) {
    echo json_encode(["success" => false, "message" => "Department not found"]);
    exit();
}

/* -----------------------------
    UPDATE DEPARTMENTS TABLE
------------------------------*/
$fields = [];
$params = [];

foreach ($data as $key => $value) {
    $fields[] = "$key = ?";
    $params[] = $value ?? null;
}

$params[] = $department_uid;
$params[] = $user_id;

$sql = "UPDATE departments SET " . implode(", ", $fields) . " WHERE department_id = ? AND user_id = ?";
$stmt = $pdo->prepare($sql);
$ok = $stmt->execute($params);

echo json_encode([
    "success" => $ok,
    "message" => $ok ? "Department updated successfully" : "Update failed"
]);
exit();
?>