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
   COLLECT ALL FIELDS
-----------------------------------------------------*/
$fields = [
    'department_id' => "DEPT_" . uniqid(),
    'user_id' => $user_id,
    'name' => $name,
    'type' => trim($data["type"] ?? ""),
    'slug' => trim($data["slug"] ?? ""),
    'image' => trim($data["image"] ?? ""),
    'meta_title' => $data["meta_title"] ?? null,
    'meta_description' => $data["meta_description"] ?? null,
    'type_main_name' => $data["type_main_name"] ?? null,
    'type_main_amount' => $data["type_main_amount"] ?? null,
];

// Add type fields 1-25
for ($i = 1; $i <= 25; $i++) {
    $fields["type_{$i}_name"] = $data["type_{$i}_name"] ?? null;
    $fields["type_{$i}_amount"] = $data["type_{$i}_amount"] ?? null;
}

/* ----------------------------------------------------
   BUILD INSERT QUERY
-----------------------------------------------------*/
$columns = implode(", ", array_keys($fields));
$placeholders = ":" . implode(", :", array_keys($fields));

$sql = "INSERT INTO departments ($columns, created_at) VALUES ($placeholders, NOW(3))";

try {
    $stmt = $pdo->prepare($sql);
    
    // Bind all values
    foreach ($fields as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    
    $ok = $stmt->execute();
    
    if (!$ok) {
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
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}

exit();
?>