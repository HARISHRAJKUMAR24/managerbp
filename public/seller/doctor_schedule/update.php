<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// Get raw input
$rawInput = file_get_contents("php://input");
error_log("=== UPDATE.PHP DEBUG ===");
error_log("Raw input: " . $rawInput);

$input = json_decode($rawInput, true);

if (!$input) {
    error_log("No input or invalid JSON");
    echo json_encode(["success" => false, "message" => "No data received or invalid JSON"]);
    exit;
}

if (!isset($input["id"])) {
    error_log("No ID in input");
    echo json_encode(["success" => false, "message" => "ID required"]);
    exit;
}

error_log("Input received: " . json_encode($input));

try {
    // Extract data EXACTLY as get.php sends it
    $id = $input["id"] ?? null;
    $category_id = isset($input["categoryId"]) && $input["categoryId"] !== "" ? intval($input["categoryId"]) : null;
    $name = $input["name"] ?? ($input["doctor_name"] ?? '');
    $slug = $input["slug"] ?? '';
    
    // Amount handling
    $amount = 0;
    if (isset($input["amount"])) {
        if (is_numeric($input["amount"])) {
            $amount = floatval($input["amount"]);
        } elseif (is_string($input["amount"])) {
            $amount = floatval($input["amount"]);
        }
    }
    
    $description = $input["description"] ?? '';
    $specialization = $input["specialization"] ?? '';
    $qualification = $input["qualification"] ?? '';
    
    // Experience handling
    $experience = 0;
    if (isset($input["experience"])) {
        if (is_numeric($input["experience"])) {
            $experience = intval($input["experience"]);
        } elseif (is_string($input["experience"])) {
            $experience = intval($input["experience"]);
        }
    }
    
    $doctor_image = $input["doctorImage"] ?? ($input["doctor_image"] ?? '');
    $meta_title = $input["metaTitle"] ?? '';
    $meta_description = $input["metaDescription"] ?? '';
    
    // Location handling - EXACTLY as get.php structure
    $doctorLocation = $input["doctorLocation"] ?? [];
    $country = $doctorLocation["country"] ?? '';
    $state = $doctorLocation["state"] ?? '';
    $city = $doctorLocation["city"] ?? '';
    $pincode = $doctorLocation["pincode"] ?? '';
    $address = $doctorLocation["address"] ?? '';
    $map_link = $doctorLocation["mapLink"] ?? '';
    
    // Weekly schedule - EXACTLY as get.php structure
    $weekly_schedule = isset($input["weeklySchedule"]) ? json_encode($input["weeklySchedule"]) : json_encode([]);
    
    error_log("Parsed data:");
    error_log("ID: $id");
    error_log("Category ID: " . ($category_id ?? 'NULL'));
    error_log("Name: $name");
    error_log("Amount: $amount");
    error_log("Weekly Schedule: $weekly_schedule");
    
    // Prepare SQL - UPDATE ONLY fields that exist in your table
    $sql = "UPDATE doctor_schedule SET
        category_id = :category_id,
        name = :name,
        slug = :slug,
        amount = :amount,
        description = :description,
        specialization = :specialization,
        qualification = :qualification,
        experience = :experience,
        doctor_image = :doctor_image,
        meta_title = :meta_title,
        meta_description = :meta_description,
        country = :country,
        state = :state,
        city = :city,
        pincode = :pincode,
        address = :address,
        map_link = :map_link,
        weekly_schedule = :weekly_schedule,
        updated_at = NOW()
        WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $params = [
        ":id" => $id,
        ":category_id" => $category_id,
        ":name" => $name,
        ":slug" => $slug,
        ":amount" => $amount,
        ":description" => $description,
        ":specialization" => $specialization,
        ":qualification" => $qualification,
        ":experience" => $experience,
        ":doctor_image" => $doctor_image,
        ":meta_title" => $meta_title,
        ":meta_description" => $meta_description,
        ":country" => $country,
        ":state" => $state,
        ":city" => $city,
        ":pincode" => $pincode,
        ":address" => $address,
        ":map_link" => $map_link,
        ":weekly_schedule" => $weekly_schedule,
    ];

    error_log("Executing with params: " . json_encode($params));
    
    $result = $stmt->execute($params);
    $affectedRows = $stmt->rowCount();

    error_log("Update result: " . ($result ? "SUCCESS" : "FAILED"));
    error_log("Affected rows: $affectedRows");

    if ($affectedRows > 0) {
        echo json_encode([
            "success" => true, 
            "message" => "Doctor schedule updated successfully",
            "updated_id" => $id
        ]);
    } else {
        echo json_encode([
            "success" => true, 
            "message" => "No changes detected or record not found",
            "warning" => true
        ]);
    }
    
} catch (PDOException $e) {
    error_log("UPDATE.PHP PDO ERROR: " . $e->getMessage());
    error_log("SQL Error Code: " . $e->getCode());
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage(),
        "error_code" => $e->getCode()
    ]);
} catch (Exception $e) {
    error_log("UPDATE.PHP ERROR: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Update failed: " . $e->getMessage()
    ]);
}