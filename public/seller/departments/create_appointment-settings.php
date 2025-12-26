<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
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
$data = json_decode(file_get_contents("php://input"), true) ?? [];

/* ----------------------------------------------------
   AUTH
-----------------------------------------------------*/
$token = $data["token"] ?? ($_COOKIE["token"] ?? "");

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing token"]);
    exit();
}

$stmt = $pdo->prepare("SELECT user_id FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit();
}

$user_id = $user["user_id"];

/* ----------------------------------------------------
   INPUT
-----------------------------------------------------*/
$department_id = trim($data["department_id"] ?? "");
$appointment_settings = $data["appointment_settings"] ?? null;

if (!$department_id || !is_array($appointment_settings)) {
    echo json_encode(["success" => false, "message" => "Invalid payload"]);
    exit();
}

/* ----------------------------------------------------
   NORMALIZE (DO NOT DESTROY DATA)
-----------------------------------------------------*/
$days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
$final_settings = [];

foreach ($days as $day) {
    $dayData = $appointment_settings[$day] ?? null;

    $final_settings[$day] = [
        "enabled" => (bool)($dayData["enabled"] ?? false),
        "slots" => []
    ];

    if (!empty($dayData["slots"]) && is_array($dayData["slots"])) {
        foreach ($dayData["slots"] as $slot) {
            $final_settings[$day]["slots"][] = [
                "from"      => trim($slot["from"] ?? ""),
                "to"        => trim($slot["to"] ?? ""),
                "breakFrom" => trim($slot["breakFrom"] ?? ""),
                "breakTo"   => trim($slot["breakTo"] ?? ""),
                "token"     => intval($slot["token"] ?? 0),
            ];
        }
    }
}

/* ----------------------------------------------------
   SAVE
-----------------------------------------------------*/
$stmt = $pdo->prepare("
    UPDATE departments
    SET appointment_settings = ?, updated_at = NOW(3)
    WHERE department_id = ? AND user_id = ?
");

$stmt->execute([
    json_encode($final_settings, JSON_UNESCAPED_SLASHES),
    $department_id,
    $user_id
]);

echo json_encode([
    "success" => true,
    "message" => "Appointment settings saved successfully",
    "appointment_settings" => $final_settings
]);

exit();
