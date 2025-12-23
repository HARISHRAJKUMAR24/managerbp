<?php
// ------------------------
// CORS FIX (REQUIRED)
// ------------------------
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// Read JSON body
$raw = file_get_contents("php://input");
$input = json_decode($raw, true);

// Validation
if (empty($input["user_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "user_id required",
        "received" => $input
    ]);
    exit;
}

// Fix numeric fields
$categoryId = !empty($input["categoryId"]) ? intval($input["categoryId"]) : null;

try {

    $sql = "INSERT INTO doctor_schedule (
        user_id,
        category_id,
        name,
        slug,
        amount,
        previous_amount,
        description,

        specialization,
        qualification,
        experience,
        doctor_image,

        gst_percentage,
        meta_title,
        meta_description,

        country,
        state,
        city,
        pincode,
        address,
        map_link,

        weekly_schedule,
        additional_images,
        status
    ) VALUES (
        :user_id,
        :category_id,
        :name,
        :slug,
        :amount,
        :previous_amount,
        :description,

        :specialization,
        :qualification,
        :experience,
        :doctor_image,

        :gst_percentage,
        :meta_title,
        :meta_description,

        :country,
        :state,
        :city,
        :pincode,
        :address,
        :map_link,

        :weekly_schedule,
        :additional_images,
        :status
    )";

    $stmt = $pdo->prepare($sql);

    $loc = $input["doctorLocation"] ?? [];

    $stmt->execute([
        ":user_id" => $input["user_id"],
        ":category_id" => $categoryId,
        ":name" => $input["name"] ?? "",
        ":slug" => $input["slug"] ?? "",
        ":amount" => $input["amount"] ?? 0,
        ":previous_amount" => $input["previousAmount"] ?? null,
        ":description" => $input["description"] ?? "",

        ":specialization" => $input["specialization"] ?? "",
        ":qualification" => $input["qualification"] ?? "",
        ":experience" => $input["experience"] ?? "",
        ":doctor_image" => $input["doctorImage"] ?? "",

        ":gst_percentage" => $input["gstPercentage"] ?? null,
        ":meta_title" => $input["metaTitle"] ?? "",
        ":meta_description" => $input["metaDescription"] ?? "",

        ":country" => $loc["country"] ?? "",
        ":state" => $loc["state"] ?? "",
        ":city" => $loc["city"] ?? "",
        ":pincode" => $loc["pincode"] ?? "",
        ":address" => $loc["address"] ?? "",
        ":map_link" => $loc["mapLink"] ?? "",

        ":weekly_schedule" => json_encode($input["weeklySchedule"] ?? []),
        ":additional_images" => json_encode($input["additionalImages"] ?? []),

        ":status" => $input["status"] ?? 0,
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Doctor schedule created successfully"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
