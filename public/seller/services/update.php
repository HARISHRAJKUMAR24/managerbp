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

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$service_id_param = $_GET["service_id"] ?? null;
$user_id = $_GET["user_id"] ?? null;

if (!$service_id_param || !$user_id) {
    echo json_encode(["success" => false, "message" => "Missing service_id or user_id"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$pdo->beginTransaction();

try {
    // Get numeric ID
    $getIdStmt = $pdo->prepare("SELECT id FROM services WHERE service_id = :service_id AND user_id = :user_id");
    $getIdStmt->execute([
        ":service_id" => $service_id_param,
        ":user_id" => $user_id
    ]);
    $service = $getIdStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) {
        throw new Exception("Service not found or unauthorized");
    }
    
    $numeric_service_id = $service['id'];

    // Update main service
    $sql = "UPDATE services SET
                name = :name,
                slug = :slug,
                amount = :amount,
                previous_amount = :pamount,
                image = :image,
                category_id = :cat,
                time_slot_interval = :slot,
                interval_type = :itype,
                description = :descr,
                gst_percentage = :gst,
                meta_title = :mtitle,
                meta_description = :mdesc,
                status = :status
            WHERE id = :id AND user_id = :uid";

    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute([
        ":name" => $data["name"] ?? '',
        ":slug" => $data["slug"] ?? '',
        ":amount" => $data["amount"] ?? 0,
        ":pamount" => $data["previousAmount"] ?? null,
        ":image" => $data["image"] ?? null,
        ":cat" => $data["categoryId"] ?? null,
        ":slot" => $data["timeSlotInterval"] ?? null,
        ":itype" => $data["intervalType"] ?? null,
        ":descr" => $data["description"] ?? null,
        ":gst" => $data["gstPercentage"] ?? null,
        ":mtitle" => $data["metaTitle"] ?? null,
        ":mdesc" => $data["metaDescription"] ?? null,
        ":status" => $data["status"] ?? 0,
        ":id" => $numeric_service_id,
        ":uid" => $user_id
    ]);

    if (!$result) {
        throw new Exception("Failed to update service");
    }

    // Update additional images
    $deleteStmt = $pdo->prepare("DELETE FROM service_images WHERE service_id = :service_id");
    $deleteStmt->execute([":service_id" => $numeric_service_id]);
    
    if (isset($data["additionalImages"]) && is_array($data["additionalImages"]) && !empty($data["additionalImages"])) {
        $insertStmt = $pdo->prepare("INSERT INTO service_images (service_id, image, created_at) VALUES (:service_id, :img, NOW(3))");
        
        foreach ($data["additionalImages"] as $imgPath) {
            if (!empty($imgPath)) {
                $insertStmt->execute([
                    ":service_id" => $numeric_service_id,
                    ":img" => $imgPath
                ]);
            }
        }
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Service updated successfully"
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
    exit();
}
?>