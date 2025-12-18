<?php
// seller/settings/available-days/get.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

try {
    $pdo = getDbConnection();
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit();
}

// Get user ID from query parameters
$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User ID required"
    ]);
    exit();
}

try {
    // Query to get business hours
    $sql = "SELECT 
                sunday, sunday_starts, sunday_ends,
                monday, monday_starts, monday_ends,
                tuesday, tuesday_starts, tuesday_ends,
                wednesday, wednesday_starts, wednesday_ends,
                thursday, thursday_starts, thursday_ends,
                friday, friday_starts, friday_ends,
                saturday, saturday_starts, saturday_ends
            FROM site_settings 
            WHERE user_id = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no settings exist, return default values
    if (!$settings) {
        $settings = [
            'sunday' => 0,
            'sunday_starts' => '',
            'sunday_ends' => '',
            'monday' => 1,
            'monday_starts' => '',
            'monday_ends' => '',
            'tuesday' => 1,
            'tuesday_starts' => '',
            'tuesday_ends' => '',
            'wednesday' => 1,
            'wednesday_starts' => '',
            'wednesday_ends' => '',
            'thursday' => 1,
            'thursday_starts' => '',
            'thursday_ends' => '',
            'friday' => 1,
            'friday_starts' => '',
            'friday_ends' => '',
            'saturday' => 0,
            'saturday_starts' => '',
            'saturday_ends' => '',
        ];
    } else {
        // Convert NULL values to empty strings
        foreach ($settings as $key => $value) {
            if ($value === null) {
                $settings[$key] = '';
            }
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $settings
    ]);

} catch (PDOException $e) {
    error_log("Database error in get.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
}