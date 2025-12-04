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

$service_id = $_GET["service_id"] ?? null;
$user_id = $_GET["user_id"] ?? null;

if (!$service_id || !$user_id) {
    echo json_encode(["success" => false, "message" => "Missing service_id or user_id"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

/* -----------------------------
   UPDATE MAIN SERVICE RECORD
------------------------------ */
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
        WHERE service_id = :sid AND user_id = :uid";

$stmt = $pdo->prepare($sql);

$result = $stmt->execute([
    ":name" => $data["name"],
    ":slug" => $data["slug"],
    ":amount" => $data["amount"],
    ":pamount" => $data["previousAmount"],
    ":image" => $data["image"],
    ":cat" => $data["categoryId"],
    ":slot" => $data["timeSlotInterval"],
    ":itype" => $data["intervalType"],
    ":descr" => $data["description"],
    ":gst" => $data["gstPercentage"],
    ":mtitle" => $data["metaTitle"],
    ":mdesc" => $data["metaDescription"],
    ":status" => $data["status"],
    ":sid" => $service_id,
    ":uid" => $user_id
]);

/* -----------------------------
   UPDATE ADDITIONAL IMAGES
------------------------------ */

if (isset($data["additionalImages"]) && is_array($data["additionalImages"])) {

    // Remove old images
    $pdo->prepare("DELETE FROM service_images WHERE service_id = ?")->execute([$service_id]);

    // Insert new images
    $insertImg = $pdo->prepare("INSERT INTO service_images (service_id, image) VALUES (:sid, :img)");

    foreach ($data["additionalImages"] as $imgPath) {
        $insertImg->execute([
            ":sid" => $service_id,
            ":img" => $imgPath
        ]);
    }
}

echo json_encode([
    "success" => true,
    "message" => "Service updated successfully"
]);
