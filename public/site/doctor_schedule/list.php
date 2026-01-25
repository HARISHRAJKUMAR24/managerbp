<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../../../config/config.php";
require_once __DIR__ . "/../../../src/database.php";

$pdo = getDbConnection();

$userId = (int)($_GET['user_id'] ?? 0);

if (!$userId) {
    echo json_encode([
        "success" => false,
        "records" => [],
        "message" => "user_id required"
    ]);
    exit;
}

/***************************
 *  MAIN DOCTOR QUERY
 ***************************/
$stmt = $pdo->prepare("
    SELECT 
        ds.id,
        ds.name,
        ds.slug,
        ds.amount,
        ds.token_limit,
        ds.doctor_image AS doctorImage,
        ds.weekly_schedule,
        ds.leave_dates,
        ds.category_id,

        c.name AS category_name,
        c.doctor_name,
        c.specialization,
        c.qualification,
        c.experience,
        c.reg_number,
        c.doctor_image AS cat_doctor_image,
        c.user_id

    FROM doctor_schedule ds
    LEFT JOIN categories c 
        ON c.category_id = ds.category_id 
        AND c.user_id = ds.user_id
    WHERE ds.user_id = ?
");
$stmt->execute([$userId]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

/***************************
 *  GET BOOKED TOKEN DATA
 ***************************/
$bookingStmt = $pdo->prepare("
    SELECT appointment_date, batch_id, SUM(token_count) AS booked
    FROM customer_payment
    WHERE user_id = ?
      AND status = 'paid'
    GROUP BY appointment_date, batch_id
");
$bookingStmt->execute([$userId]);

$bookings = []; // date_batch → count

foreach ($bookingStmt->fetchAll(PDO::FETCH_ASSOC) as $b) {
    $key = $b["appointment_date"] . "_" . $b["batch_id"];
    $bookings[$key] = (int)$b["booked"];
}

/***************************
 *  PROCESS RECORDS
 ***************************/
foreach ($records as &$row) {

    /***** Weekly Schedule *****/
    $weeklySchedule = !empty($row['weekly_schedule'])
        ? json_decode($row['weekly_schedule'], true)
        : [];
    $row['weeklySchedule'] = $weeklySchedule;

    /***** Leave Dates *****/
    $row['leaveDates'] = !empty($row['leave_dates'])
        ? json_decode($row['leave_dates'], true)
        : [];

    /***** Token Limit *****/
    $tokenLimit = isset($row['token_limit']) ? (int)$row['token_limit'] : 1;
    $row['token_limit'] = $tokenLimit;

    /***** Build capacity list: batch_id → total tokens *****/
    $slotCapacity = [];

    foreach ($weeklySchedule as $day => $data) {
        if (!empty($data['slots'])) {
            foreach ($data['slots'] as $slot) {
                $batchId = $slot["batch_id"];
                $slotCapacity[$batchId] = $tokenLimit;
            }
        }
    }

    $row['slot_capacity'] = $slotCapacity;

    unset($row['weekly_schedule'], $row['leave_dates']);

    /***** Merge doctor/category images *****/
    if (!empty($row['cat_doctor_image'])) {
        $row['doctorImage'] = $row['cat_doctor_image'];
    }
    unset($row['cat_doctor_image']);
}

/***************************
 *  RETURN API RESULT
 ***************************/
echo json_encode([
    "success" => true,
    "records" => $records,
    "bookings" => $bookings // ⭐ FRONTEND WILL USE THIS
]);
