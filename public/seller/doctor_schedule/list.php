<?php
// ------------------------
// CORS FIX (REQUIRED)
// ------------------------
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// Read JSON body for POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = file_get_contents("php://input");
    $input = json_decode($raw, true);
    $userId = $input["user_id"] ?? null;
} else {
    $userId = $_GET["user_id"] ?? null;
}

// Validation
if (empty($userId)) {
    echo json_encode([
        "success" => false,
        "message" => "user_id required"
    ]);
    exit;
}

try {
    // Fetch doctor schedules
    $sql = "SELECT 
        ds.*,
        c.doctor_name,
        c.specialization,
        c.qualification,
        c.experience,
        c.doctor_image,
        c.doctor_fee
    FROM doctor_schedule ds
    LEFT JOIN categories c ON ds.category_id = c.id
    WHERE ds.user_id = :user_id
    ORDER BY ds.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([":user_id" => $userId]);
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Decode JSON fields
    foreach ($schedules as &$schedule) {
        if (!empty($schedule['weekly_schedule'])) {
            $schedule['weekly_schedule'] = json_decode($schedule['weekly_schedule'], true);
        } else {
            $schedule['weekly_schedule'] = [];
        }

        if (!empty($schedule['additional_images'])) {
            $schedule['additional_images'] = json_decode($schedule['additional_images'], true);
        } else {
            $schedule['additional_images'] = [];
        }
    }

    echo json_encode([
        "success" => true,
        "message" => "Doctor schedules fetched successfully",
        "data" => $schedules,
        "count" => count($schedules)
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage(),
        "error_details" => $e->getTraceAsString()
    ]);
}
?>