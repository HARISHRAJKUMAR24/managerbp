<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();
$user_id = $_GET["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "user_id missing"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

try {
    // Check if settings exist for this user
    $checkStmt = $pdo->prepare("SELECT id FROM site_settings WHERE user_id = :user_id");
    $checkStmt->execute([":user_id" => $user_id]);
    $existingSettings = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingSettings) {
        // Update existing settings - ONLY BASIC FIELDS
        $sql = "UPDATE site_settings SET 
                logo = :logo,
                favicon = :favicon,
                email = :email,
                phone = :phone,
                whatsapp = :whatsapp,
                currency = :currency,
                country = :country,
                state = :state,
                address = :address
                WHERE user_id = :user_id";
    } else {
        // Insert new settings with only basic fields, others will be NULL/default
        $sql = "INSERT INTO site_settings 
                (user_id, logo, favicon, email, phone, whatsapp, currency, country, state, address)
                VALUES 
                (:user_id, :logo, :favicon, :email, :phone, :whatsapp, :currency, :country, :state, :address)";
    }

    $stmt = $pdo->prepare($sql);
    
    $result = $stmt->execute([
        ":user_id" => $user_id,
        ":logo" => $data["logo"] ?? null,
        ":favicon" => $data["favicon"] ?? null,
        ":email" => $data["email"] ?? null,
        ":phone" => $data["phone"] ?? null,
        ":whatsapp" => $data["whatsapp"] ?? null,
        ":currency" => $data["currency"] ?? "INR",
        ":country" => $data["country"] ?? null,
        ":state" => $data["state"] ?? null,
        ":address" => $data["address"] ?? null
    ]);

    if ($result) {
        // Get updated settings to return
        $getStmt = $pdo->prepare("SELECT logo, favicon, email, phone, whatsapp, currency, country, state, address 
                                 FROM site_settings WHERE user_id = :user_id");
        $getStmt->execute([":user_id" => $user_id]);
        $updatedSettings = $getStmt->fetch(PDO::FETCH_ASSOC);
        
        // Add full URLs for images
        $baseUrl = "http://localhost/managerbp/public/uploads/";
        if ($updatedSettings['logo']) {
            $updatedSettings['logo'] = $baseUrl . $updatedSettings['logo'];
        }
        if ($updatedSettings['favicon']) {
            $updatedSettings['favicon'] = $baseUrl . $updatedSettings['favicon'];
        }
        
        echo json_encode([
            "success" => true,
            "message" => "Basic settings updated successfully",
            "data" => $updatedSettings
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update settings"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>