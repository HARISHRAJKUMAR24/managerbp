<?php
// seller/settings/social-settings/get.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

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
    // Query to get only social settings
    $sql = "SELECT facebook, twitter, instagram, linkedin, youtube, pinterest 
            FROM users_settings 
            WHERE user_id = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no settings exist, return default empty values
    if (!$settings) {
        $settings = [
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'linkedin' => '',
            'youtube' => '',
            'pinterest' => ''
        ];
    } else {
        // Convert NULL values to empty strings for React
        foreach ($settings as $key => $value) {
            if ($value === null) {
                $settings[$key] = '';
            }
        }
    }

    // Return success with data
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