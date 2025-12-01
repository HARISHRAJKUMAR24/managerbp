<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

// Read raw JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// Validate JSON
if (!$data || !is_array($data)) {
    echo json_encode(["success" => false, "message" => "Invalid or empty request"]);
    exit;
}

// Validate required fields properly
$required = ["user_id", "employee_id", "name", "phone"];
foreach ($required as $field) {
    if (!isset($data[$field]) || trim($data[$field]) === "") {
        echo json_encode([
            "success" => false,
            "message" => "Missing required field: $field"
        ]);
        exit;
    }
}

$user_id     = $data['user_id'];
$employee_id = $data['employee_id'];
$name        = $data['name'];
$position    = $data['position'] ?? null;
$email       = $data['email'] ?? null;
$phone       = $data['phone'];
$address     = $data['address'] ?? null;

$pdo = getDbConnection();

$stmt = $pdo->prepare("
    INSERT INTO employees (employee_id, user_id, name, position, email, phone, address)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$ok = $stmt->execute([
    $employee_id,
    $user_id,
    $name,
    $position,
    $email,
    $phone,
    $address
]);

if ($ok) {
    echo json_encode([
        "success" => true,
        "message" => "Employee added successfully"
    ]);
    exit;
}

// full detailed SQL error
$error = $stmt->errorInfo();

echo json_encode([
    "success" => false,
    "message" => $error[2] ?: "Database insert failed"
]);
exit;
