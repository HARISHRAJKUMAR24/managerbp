<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$service_id = $_GET["service_id"];
$baseUrl = "http://localhost/managerbp/public/uploads/";

// ----------------------
// Get main service data
// ----------------------
$sql = "SELECT *, 
        CASE WHEN image='' OR image IS NULL THEN NULL 
             ELSE image END AS image
        FROM services 
        WHERE service_id = :sid";

$stmt = $pdo->prepare($sql);
$stmt->execute([":sid" => $service_id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    echo json_encode(["success" => false, "message" => "Service not found"]);
    exit();
}

// ----------------------
// Get additional images
// ----------------------
$sql2 = "SELECT image FROM service_images WHERE service_id = :sid";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([":sid" => $service_id]);
$images = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Convert to relative (no baseUrl here)
$service["additionalImages"] = $images;

// ----------------------
// Output
// ----------------------
echo json_encode([
    "success" => true,
    "data" => $service
]);
