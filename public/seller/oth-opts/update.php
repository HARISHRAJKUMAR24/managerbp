<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, PUT, OPTIONS");
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

if (!$department_uid) {
    echo json_encode([
        "success" => false,
        "message" => "Department ID required"
    ]);
    exit();
}

$rawData = file_get_contents("php://input");
error_log("UPDATE RAW DATA: " . $rawData);
$data = json_decode($rawData, true);

if (!is_array($data)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON data"
    ]);
    exit();
}

/* ----------------------------------------------------
   DEBUG: Log incoming data
-----------------------------------------------------*/
error_log("UPDATE DEPARTMENT DATA: " . print_r($data, true));

/* ----------------------------------------------------
   REMOVE PROTECTED FIELDS
-----------------------------------------------------*/
$protected = ['id', 'department_id', 'user_id', 'created_at', 'updated_at', 'token'];
foreach ($protected as $field) {
    unset($data[$field]);
}

/* ----------------------------------------------------
   CHECK IF DEPARTMENT EXISTS
-----------------------------------------------------*/
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

/* ----------------------------------------------------
   PREPARE UPDATE QUERY
-----------------------------------------------------*/
$fields = [];
$bindValues = [];
$params = [];

foreach ($data as $key => $value) {
    // Skip empty string values that should be null
    if ($value === '') {
        $value = null;
    }
    
    // Convert amount fields to float
    if (strpos($key, '_amount') !== false && $value !== null) {
        $value = floatval($value);
    }
    
    $fields[] = "`$key` = :$key";
    $bindValues[":$key"] = $value;
}

if (empty($fields)) {
    echo json_encode([
        "success" => false,
        "message" => "Nothing to update"
    ]);
    exit();
}

$bindValues[':department_id'] = $department_uid;

$sql = "UPDATE departments 
        SET " . implode(", ", $fields) . ", updated_at = NOW(3)
        WHERE department_id = :department_id";

error_log("UPDATE SQL: " . $sql);
error_log("UPDATE BIND VALUES: " . print_r($bindValues, true));

try {
    $stmt = $pdo->prepare($sql);
    
    // Bind all values
    foreach ($bindValues as $param => $value) {
        if (is_null($value)) {
            $stmt->bindValue($param, null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue($param, $value);
        }
    }
    
    $success = $stmt->execute();
    
    if (!$success) {
        error_log("UPDATE ERROR: " . print_r($stmt->errorInfo(), true));
    }
    
    echo json_encode([
        "success" => $success,
        "message" => $success 
            ? "Department updated successfully" 
            : "Update failed"
    ]);
    
} catch (Exception $e) {
    error_log("UPDATE EXCEPTION: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
exit();
?>