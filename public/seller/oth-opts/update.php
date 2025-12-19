<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

/* Handle preflight */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* --------------------------------
   GET DEPARTMENT ID
-------------------------------- */
$department_uid = $_GET['department_id'] ?? '';

if (!$department_uid) {
    echo json_encode([
        "success" => false,
        "message" => "Department ID required"
    ]);
    exit();
}

/* --------------------------------
   READ JSON BODY
-------------------------------- */
$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON data"
    ]);
    exit();
}

/* --------------------------------
   REMOVE PROTECTED FIELDS
-------------------------------- */
unset($data['id']);
unset($data['department_id']);
unset($data['user_id']);
unset($data['created_at']);
unset($data['updated_at']);
unset($data['token']);

/* --------------------------------
   CHECK IF DEPARTMENT EXISTS
-------------------------------- */
$stmt = $pdo->prepare(
    "SELECT id, user_id FROM departments WHERE department_id = ? LIMIT 1"
);
$stmt->execute([$department_uid]);
$department = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$department) {
    echo json_encode([
        "success" => false,
        "message" => "Department not found"
    ]);
    exit();
}

/* --------------------------------
   PREPARE UPDATE QUERY
-------------------------------- */
$fields = [];
$params = [];

foreach ($data as $key => $value) {
    $fields[] = "`$key` = ?";
    $params[] = $value;
}

if (empty($fields)) {
    echo json_encode([
        "success" => false,
        "message" => "Nothing to update"
    ]);
    exit();
}

$params[] = $department_uid;

$sql = "UPDATE departments 
        SET " . implode(", ", $fields) . " 
        WHERE department_id = ?";

$stmt = $pdo->prepare($sql);
$success = $stmt->execute($params);

/* --------------------------------
   RESPONSE
-------------------------------- */
echo json_encode([
    "success" => $success,
    "message" => $success 
        ? "Department updated successfully" 
        : "Update failed"
]);
exit();
