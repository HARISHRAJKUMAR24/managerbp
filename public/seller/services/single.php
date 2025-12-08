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

    // -----------------------------------------
    // Fetch main service record
    // -----------------------------------------
    $stmt = $pdo->prepare("
        SELECT *, 
        CASE 
            WHEN image IS NULL OR image = '' THEN NULL 
            ELSE CONCAT('$baseUrl', image) 
        END AS full_image
        FROM services
        WHERE service_id = :sid
    ");
    $stmt->execute([":sid" => $service_id_param]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$service) {
        echo json_encode(["success" => false, "message" => "Service not found"]);
        exit();
    }

    // ----------------------------------------------------
    // Normalize keys to match frontend naming conventions
    // ----------------------------------------------------
    $serviceData = [
        "id"                => $service["id"],
        "service_id"        => $service["service_id"],
        "user_id"           => $service["user_id"],
        "name"              => $service["name"],
        "slug"              => $service["slug"],
        "amount"            => $service["amount"],
        "previousAmount"    => $service["previous_amount"],
        "categoryId"        => $service["category_id"],
        "timeSlotInterval"  => $service["time_slot_interval"],
        "intervalType"      => $service["interval_type"],
        "description"       => $service["description"],
        "gstPercentage"     => $service["gst_percentage"],
        "metaTitle"         => $service["meta_title"],
        "metaDescription"   => $service["meta_description"],
        "status"            => $service["status"],
        "image"             => $service["full_image"],   // full URL
    ];

    // ----------------------------------------------------
    // Get additional images — return as objects, not strings
    // ----------------------------------------------------
    $imgStmt = $pdo->prepare("
        SELECT 
            CASE 
                WHEN image IS NULL OR image = '' THEN NULL
                ELSE CONCAT('$baseUrl', image)
            END AS full_image
        FROM service_images
        WHERE service_id = :sid
        ORDER BY id
    ");
    $imgStmt->execute([":sid" => $service["id"]]);

    $images = $imgStmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Convert to object format: [{ image: "URL" }]
    $serviceData["additionalImages"] = array_map(function($img) {
        return ["image" => $img];
    }, $images);

    // ----------------------------------------------------
    // Final response
    // ----------------------------------------------------
    echo json_encode([
        "success" => true,
        "data" => $serviceData
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>
