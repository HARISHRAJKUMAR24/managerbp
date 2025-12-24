<?php
// CORS headers
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include database configuration
require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* ----------------------------------------------------
   GET JSON BODY
-----------------------------------------------------*/
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);
if (!is_array($data)) $data = [];

/* ----------------------------------------------------
   TOKEN AUTHENTICATION
-----------------------------------------------------*/
$token = $data["token"] ?? ($_COOKIE["token"] ?? "");

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing token"]);
    exit();
}

// Validate user
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
$department_id = trim($data["department_id"] ?? "");
$appointment_settings = $data["appointment_settings"] ?? [];

if (!$department_id) {
    echo json_encode(["success" => false, "message" => "Department ID is required"]);
    exit();
}

if (!is_array($appointment_settings)) {
    echo json_encode(["success" => false, "message" => "Appointment settings must be an array"]);
    exit();
}

/* ----------------------------------------------------
   VALIDATE AND FORMAT APPOINTMENT SETTINGS
-----------------------------------------------------*/
$days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
$validated_settings = [];

foreach ($days as $day) {
    if (isset($appointment_settings[$day]) && is_array($appointment_settings[$day])) {
        $day_data = $appointment_settings[$day];
        
        // Ensure the structure is valid
        $validated_settings[$day] = [
            "enabled" => isset($day_data["enabled"]) ? (bool)$day_data["enabled"] : false,
            "slots" => []
        ];
        
        // Validate slots if enabled
        if ($validated_settings[$day]["enabled"] && isset($day_data["slots"]) && is_array($day_data["slots"])) {
            foreach ($day_data["slots"] as $slot) {
                $validated_slot = [
                    "from" => isset($slot["from"]) ? trim($slot["from"]) : "09:00",
                    "to" => isset($slot["to"]) ? trim($slot["to"]) : "17:00",
                    "breakFrom" => isset($slot["breakFrom"]) ? trim($slot["breakFrom"]) : "13:00",
                    "breakTo" => isset($slot["breakTo"]) ? trim($slot["breakTo"]) : "14:00",
                    "token" => isset($slot["token"]) ? intval($slot["token"]) : 10
                ];
                
                // Validate time formats (basic validation)
                if (preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $validated_slot["from"]) &&
                    preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $validated_slot["to"]) &&
                    preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $validated_slot["breakFrom"]) &&
                    preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $validated_slot["breakTo"])) {
                    
                    $validated_settings[$day]["slots"][] = $validated_slot;
                }
            }
        }
    } else {
        // Default for disabled days
        $validated_settings[$day] = [
            "enabled" => false,
            "slots" => []
        ];
    }
}

/* ----------------------------------------------------
   UPDATE DEPARTMENT WITH APPOINTMENT SETTINGS
-----------------------------------------------------*/
try {
    // Check if department exists and belongs to user
    $stmt = $pdo->prepare("SELECT id FROM departments WHERE department_id = ? AND user_id = ? LIMIT 1");
    $stmt->execute([$department_id, $user_id]);
    $department = $stmt->fetchObject();
    
    if (!$department) {
        echo json_encode(["success" => false, "message" => "Department not found or access denied"]);
        exit();
    }
    
    // Convert appointment settings to JSON
    $appointment_settings_json = json_encode($validated_settings, JSON_PRETTY_PRINT);
    
    // Update the department
    $stmt = $pdo->prepare("UPDATE departments SET appointment_settings = ?, updated_at = NOW(3) WHERE department_id = ? AND user_id = ?");
    $stmt->execute([$appointment_settings_json, $department_id, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Appointment settings saved successfully",
            "appointment_settings" => $validated_settings,
            "department_id" => $department_id
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update department",
            "department_id" => $department_id
        ]);
    }
    
} catch (Exception $e) {
    error_log("APPOINTMENT SETTINGS ERROR: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Database error",
        "error" => $e->getMessage()
    ]);
    exit();
}

exit();
?>