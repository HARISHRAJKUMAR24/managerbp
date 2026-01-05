<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID required"]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT 
            id,
            user_id,
            category_id,
            name,
            slug,
            amount,
            description,
            specialization,
            qualification,
            experience,
            doctor_image,
            weekly_schedule,
            meta_title,
            meta_description,
            country,
            state,
            city,
            pincode,
            address,
            map_link,
            created_at,
            updated_at
        FROM doctor_schedule
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode(["success" => false, "message" => "Not found"]);
        exit;
    }

    // CRITICAL: Convert category_id to string
    $data['category_id'] = isset($data['category_id']) ? strval($data['category_id']) : "";

    // Decode JSON
    $weeklySchedule = [];
    if (!empty($data['weekly_schedule'])) {
        $decoded = json_decode($data['weekly_schedule'], true);
        $weeklySchedule = $decoded ?: [];
    }

    // Build response
    $response = [
        "success" => true,
        "data" => [
            "id" => $data['id'],
            "serviceId" => $data['id'],
            "userId" => $data['user_id'],
            "categoryId" => $data['category_id'], // This is the CRITICAL field
            "name" => $data['name'] ?? '',
            "doctor_name" => $data['name'] ?? '',
            "slug" => $data['slug'] ?? '',
            "amount" => $data['amount'] ? strval($data['amount']) : "0",
            "description" => $data['description'] ?? '',
            "specialization" => $data['specialization'] ?? '',
            "qualification" => $data['qualification'] ?? '',
            "experience" => $data['experience'] ? strval($data['experience']) : "0",
            "doctorImage" => $data['doctor_image'] ?? '',
            "doctor_image" => $data['doctor_image'] ?? '',
            "weeklySchedule" => $weeklySchedule,
            "metaTitle" => $data['meta_title'] ?? '',
            "metaDescription" => $data['meta_description'] ?? '',
            "doctorLocation" => [
                "country" => $data['country'] ?? "",
                "state" => $data['state'] ?? "",
                "city" => $data['city'] ?? "",
                "pincode" => $data['pincode'] ?? "",
                "address" => $data['address'] ?? "",
                "mapLink" => $data['map_link'] ?? ""
            ],
            "createdAt" => $data['created_at'],
            "updatedAt" => $data['updated_at']
        ]
    ];

    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("GET.PHP ERROR: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}