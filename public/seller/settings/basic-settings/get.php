<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();

// PUBLIC user_id from cookie (NOT primary key)
$public_user_id = $_GET["user_id"] ?? null;

if (!$public_user_id) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit();
}

// 🔥 Get REAL primary key users.id
$sql = "SELECT id FROM users WHERE id = :uid LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([":uid" => $public_user_id]);
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userRow) {
    echo json_encode(["success" => false, "message" => "Invalid user_id"]);
    exit();
}

$real_user_id = $userRow["id"]; // ⭐ REAL FK

try {
    $sql = "SELECT logo, favicon, email, phone, whatsapp, currency, country, state, address 
            FROM site_settings WHERE user_id = :user_id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":user_id" => $real_user_id]);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);

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
    }

    $baseUrl = "http://localhost/managerbp/public/uploads/";

    $settings['logo_url'] = $settings['logo'] ? $baseUrl . $settings['logo'] : null;
    $settings['favicon_url'] = $settings['favicon'] ? $baseUrl . $settings['favicon'] : null;

    // Return REAL DB ID
    $settings['user_id'] = $real_user_id;

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
