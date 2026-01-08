<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../../../config/config.php";
require_once __DIR__ . "/../../../src/database.php";

$pdo = getDbConnection();

/* =====================
   PUBLIC ACCESS (NO AUTH)
===================== */
$userId = (int)($_GET['user_id'] ?? 0);

if (!$userId) {
    echo json_encode([
        "success" => false,
        "records" => [],
        "message" => "user_id required"
    ]);
    exit;
}

/* =====================
   FETCH DOCTOR SCHEDULES
===================== */
$stmt = $pdo->prepare("
    SELECT
        id,
        name,
        slug,
        amount,
        doctor_image AS doctorImage,
        weekly_schedule,
        leave_dates
    FROM doctor_schedule
    WHERE user_id = ?
");
$stmt->execute([$userId]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =====================
   DECODE JSON FIELDS
===================== */
foreach ($records as &$row) {
    // Weekly schedule
    $row['weeklySchedule'] = !empty($row['weekly_schedule'])
        ? json_decode($row['weekly_schedule'], true)
        : [];

    // Leave dates
    $row['leaveDates'] = !empty($row['leave_dates'])
        ? json_decode($row['leave_dates'], true)
        : [];

    unset($row['weekly_schedule'], $row['leave_dates']);
}

echo json_encode([
    "success" => true,
    "records" => $records
]);
