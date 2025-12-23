<?php
header("Content-Type: application/json");
require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$input = json_decode(file_get_contents("php://input"), true);

if (!$input["id"]) {
    echo json_encode(["success" => false, "message" => "id required"]);
    exit;
}

try {
    $sql = "UPDATE doctor_schedule SET
        category_id = :category_id,
        name = :name,
        slug = :slug,
        amount = :amount,
        previous_amount = :previous_amount,
        description = :description,

        specialization = :specialization,
        qualification = :qualification,
        experience = :experience,
        doctor_image = :doctor_image,

        gst_percentage = :gst_percentage,
        meta_title = :meta_title,
        meta_description = :meta_description,

        country = :country,
        state = :state,
        city = :city,
        pincode = :pincode,
        address = :address,
        map_link = :map_link,

        weekly_schedule = :weekly_schedule,
        additional_images = :additional_images,

        status = :status

        WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":id" => $input["id"],
        ":category_id" => $input["categoryId"],
        ":name" => $input["name"],
        ":slug" => $input["slug"],
        ":amount" => $input["amount"],
        ":previous_amount" => $input["previousAmount"],
        ":description" => $input["description"],

        ":specialization" => $input["specialization"],
        ":qualification" => $input["qualification"],
        ":experience" => $input["experience"],
        ":doctor_image" => $input["doctorImage"],

        ":gst_percentage" => $input["gstPercentage"],
        ":meta_title" => $input["metaTitle"],
        ":meta_description" => $input["metaDescription"],

        ":country" => $input["doctorLocation"]["country"],
        ":state" => $input["doctorLocation"]["state"],
        ":city" => $input["doctorLocation"]["city"],
        ":pincode" => $input["doctorLocation"]["pincode"],
        ":address" => $input["doctorLocation"]["address"],
        ":map_link" => $input["doctorLocation"]["mapLink"],

        ":weekly_schedule" => json_encode($input["weeklySchedule"]),
        ":additional_images" => json_encode($input["additionalImages"]),

        ":status" => $input["status"],
    ]);

    echo json_encode(["success" => true, "message" => "Doctor schedule updated"]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
