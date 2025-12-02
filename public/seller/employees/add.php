<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

// Read JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// Validate JSON
if (!$data || !is_array($data)) {
    echo json_encode(["success" => false, "message" => "Invalid or empty request"]);
    exit;
}

// Required fields
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

$user_id       = $data['user_id'];
$employee_id   = $data['employee_id'];
$name          = $data['name'];
$position      = $data['position'] ?? null;
$email         = $data['email'] ?? null;
$phone         = $data['phone'];
$address       = $data['address'] ?? null;

// ⭐ NEW — Read image
$image         = $data['image'] ?? null;

// ⭐ FIX — convert to YYYY-MM-DD (remove time)
$joining_date  = $data['joining_date'] ?? null;
if (!empty($joining_date)) {
    $joining_date = date("Y-m-d", strtotime($joining_date));
}

$pdo = getDbConnection();

// ⭐ UPDATED QUERY — added image column
$stmt = $pdo->prepare("
    INSERT INTO employees 
    (employee_id, user_id, name, position, email, phone, address, joining_date, image)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$ok = $stmt->execute([
    $employee_id,
    $user_id,
    $name,
    $position,
    $email,
    $phone,
    $address,
    $joining_date,
    $image    // ⭐ SAVED
]);

if ($ok) {
    echo json_encode([
        "success" => true,
        "message" => "Employee added successfully"
    ]);
    exit;
}

$error = $stmt->errorInfo();
echo json_encode([
    "success" => false,
    "message" => $error[2] ?: "Database insert failed"
]);
exit;
