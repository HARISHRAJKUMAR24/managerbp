<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode([
        "success" => false,
        "message" => "ID required"
    ]);
    exit;
}

try {
    /* =========================
       FETCH DOCTOR SCHEDULE
    ========================= */
    $stmt = $pdo->prepare("
        SELECT 
            id,
            user_id,
            category_id,
            name,
            slug,
            amount,
            token_limit,          -- ✅ IMPORTANT
            description,
            specialization,
            qualification,
            experience,
            doctor_image,
            weekly_schedule,
            leave_dates,
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
        echo json_encode([
            "success" => false,
            "message" => "Not found"
        ]);
        exit;
    }

    /* =========================
       SAFE JSON DECODE
    ========================= */
    $weeklySchedule = !empty($data['weekly_schedule'])
        ? json_decode($data['weekly_schedule'], true)
        : [];

    $leaveDates = !empty($data['leave_dates'])
        ? json_decode($data['leave_dates'], true)
        : [];

    /* =========================
       NORMALIZED RESPONSE
    ========================= */
    echo json_encode([
        "success" => true,
        "data" => [
            "id" => $data['id'],
            "serviceId" => $data['id'],
            "userId" => $data['user_id'],
            "categoryId" => (string)($data['category_id'] ?? ""),

            "name" => $data['name'] ?? "",
            "doctor_name" => $data['name'] ?? "",
            "slug" => $data['slug'] ?? "",
            "amount" => $data['amount'] !== null ? (string)$data['amount'] : "0",

            // ✅🔥 THIS IS THE FIX
            "token_limit" => (string)($data['token_limit'] ?? "0"),

            "description" => $data['description'] ?? "",
            "specialization" => $data['specialization'] ?? "",
            "qualification" => $data['qualification'] ?? "",
            "experience" => $data['experience'] !== null ? (string)$data['experience'] : "0",

            "doctorImage" => $data['doctor_image'] ?? "",
            "doctor_image" => $data['doctor_image'] ?? "",

            "weeklySchedule" => $weeklySchedule,
            "leaveDates" => $leaveDates,

            "metaTitle" => $data['meta_title'] ?? "",
            "metaDescription" => $data['meta_description'] ?? "",

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
    ]);

} catch (Exception $e) {
    error_log("GET.PHP ERROR: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Error fetching doctor schedule"
    ]);
}
