<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* ----------------------------------------------------
   READ JSON BODY
-----------------------------------------------------*/
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!is_array($data)) $data = [];

/* ----------------------------------------------------
   GET TOKEN
-----------------------------------------------------*/
$token = $data["token"] ?? ($_COOKIE["token"] ?? "");

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing token"]);
    exit();
}

/* ----------------------------------------------------
   VALIDATE USER USING TOKEN
-----------------------------------------------------*/
$stmt = $pdo->prepare("SELECT * FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetchObject();

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit();
}

$user_id = $user->user_id;

/* ----------------------------------------------------
   VALIDATE REQUIRED FIELDS
-----------------------------------------------------*/
$name = trim($data["name"] ?? "");

if ($name === "") {
    echo json_encode(["success" => false, "message" => "Department name is required"]);
    exit();
}

/* ----------------------------------------------------
   DEBUG: Log incoming data
-----------------------------------------------------*/
error_log("CREATE DEPARTMENT DATA: " . print_r($data, true));

/* ----------------------------------------------------
   COLLECT ALL FIELDS - NO TYPE FIELD
-----------------------------------------------------*/
$fields = [
    'department_id' => "DEPT_" . uniqid(),
    'user_id' => $user_id,
    'name' => $name,
    'slug' => trim($data["slug"] ?? ""),
    'image' => trim($data["image"] ?? ""),
    'meta_title' => $data["meta_title"] ?? null,
    'meta_description' => $data["meta_description"] ?? null,
    'type_main_name' => $data["type_main_name"] ?? null,
    'type_main_amount' => isset($data["type_main_amount"]) && $data["type_main_amount"] !== "" ? floatval($data["type_main_amount"]) : null,
];

// Add type fields 1-25
for ($i = 1; $i <= 25; $i++) {
    $typeNameKey = "type_{$i}_name";
    $typeAmountKey = "type_{$i}_amount";
    
    $fields[$typeNameKey] = $data[$typeNameKey] ?? null;
    
    if (isset($data[$typeAmountKey]) && $data[$typeAmountKey] !== "") {
        // Convert to decimal value
        $fields[$typeAmountKey] = floatval($data[$typeAmountKey]);
    } else {
        $fields[$typeAmountKey] = null;
    }
}

/* ----------------------------------------------------
   DEBUG: Log fields before insert
-----------------------------------------------------*/
error_log("FIELDS TO INSERT: " . print_r($fields, true));

/* ----------------------------------------------------
   BUILD INSERT QUERY
-----------------------------------------------------*/
$columns = [];
$placeholders = [];
$bindValues = [];

foreach ($fields as $key => $value) {
    $columns[] = "`$key`";
    $placeholders[] = ":$key";
    $bindValues[":$key"] = $value;
}

$columnsStr = implode(", ", $columns);
$placeholdersStr = implode(", ", $placeholders);

$sql = "INSERT INTO departments ($columnsStr, created_at) VALUES ($placeholdersStr, NOW(3))";

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
    
    $ok = $stmt->execute();
    
    if (!$ok) {
        error_log("SQL ERROR: " . print_r($stmt->errorInfo(), true));
        echo json_encode([
            "success" => false,
            "message" => "Department insert failed",
            "error" => $stmt->errorInfo()
        ]);
        exit();
    }
    
    echo json_encode([
        "success" => true,
        "message" => "Department created successfully",
        "department_id" => $fields['department_id']
    ]);
    
} catch (Exception $e) {
    error_log("EXCEPTION: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}

exit();
?>