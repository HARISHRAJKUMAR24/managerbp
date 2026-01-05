<?php
// managerbp/public/seller/settings/tax-settings/get.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get user ID from query parameters
$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        'success' => false,
        'message' => 'User ID is required'
    ]);
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'admin_bookpannu';
$username = 'root';  // Change if different
$password = '';      // Change if different

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT gst_number, gst_type, tax_percent, country, state 
            FROM site_settings 
            WHERE user_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$settings) {
        $settings = [
            'gst_number' => '',
            'gst_type' => '',
            'tax_percent' => '',
            'country' => '',
            'state' => ''
        ];
    } else {
        // Convert null values to empty strings
        if ($settings) {
            if ($settings['tax_percent'] !== null) {
                $settings['tax_percent'] = (float) $settings['tax_percent'];
            }
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $settings
    ]);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
}
