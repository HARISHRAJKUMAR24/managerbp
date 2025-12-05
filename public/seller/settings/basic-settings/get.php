<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();
$user_id = $_GET["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit();
}

try {
    // Get basic settings for user
    $sql = "SELECT logo, favicon, email, phone, whatsapp, currency, country, state, address 
            FROM site_settings WHERE user_id = :user_id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":user_id" => $user_id]);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If no settings exist, return empty object
    if (!$settings) {
        $settings = [
            'logo' => null,
            'favicon' => null,
            'email' => null,
            'phone' => null,
            'whatsapp' => null,
            'currency' => 'INR',
            'country' => null,
            'state' => null,
            'address' => null
        ];
    } else {
        // Add full URL for images
        $baseUrl = "http://localhost/managerbp/public/uploads/";
        if ($settings['logo']) {
            $settings['logo'] = $baseUrl . $settings['logo'];
        }
        if ($settings['favicon']) {
            $settings['favicon'] = $baseUrl . $settings['favicon'];
        }
    }

    echo json_encode([
        "success" => true,
        "data" => $settings
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>