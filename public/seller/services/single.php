<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();
$service_id_param = $_GET["service_id"] ?? null;

if (!$service_id_param) {
    echo json_encode(["success" => false, "message" => "service_id missing"]);
    exit();
}

$baseUrl = "http://localhost/managerbp/public/uploads/";

try {
    // Get main service data
    $serviceStmt = $pdo->prepare("
        SELECT *, 
        CASE WHEN image IS NULL OR image = '' THEN NULL 
             ELSE CONCAT('$baseUrl', image) END AS image
        FROM services 
        WHERE service_id = :sid
    ");
    $serviceStmt->execute([":sid" => $service_id_param]);
    $service = $serviceStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) {
        echo json_encode(["success" => false, "message" => "Service not found"]);
        exit();
    }
    
    // Get additional images
    $imagesStmt = $pdo->prepare("
        SELECT 
        CASE WHEN image IS NULL OR image = '' THEN NULL 
             ELSE CONCAT('$baseUrl', image) END AS image
        FROM service_images 
        WHERE service_id = :service_id 
        ORDER BY id
    ");
    $imagesStmt->execute([":service_id" => $service['id']]);
    $additionalImages = $imagesStmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
    $service["additionalImages"] = $additionalImages ?: [];
    
    echo json_encode([
        "success" => true,
        "data" => $service
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>