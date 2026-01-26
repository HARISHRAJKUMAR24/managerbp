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
 *  GET BOOKED TOKEN DATA - FOR TOKEN AVAILABILITY CHECK
 ***************************/
$bookingStmt = $pdo->prepare("
    SELECT 
        appointment_date, 
        batch_id, 
        SUM(token_count) AS booked
    FROM customer_payment
    WHERE user_id = ?
      AND status IN ('paid', 'pending', 'confirmed')
    GROUP BY appointment_date, batch_id
");
$bookingStmt->execute([$userId]);

$bookings = []; // Format: date_batch => count
foreach ($bookingStmt->fetchAll(PDO::FETCH_ASSOC) as $b) {
    $key = $b["appointment_date"] . "_" . $b["batch_id"];
    $bookings[$key] = (int)$b["booked"];
}

/***************************
 *  PROCESS RECORDS WITH TOKEN AVAILABILITY
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

    /***** Build slot capacity *****/
    $slotCapacity = [];
    $slotTokens = []; // Store per-slot token limits

    foreach ($weeklySchedule as $day => $data) {
        if (!empty($data['slots'])) {
            foreach ($data['slots'] as $slot) {
                $batchId = $slot["batch_id"] ?? '';
                if ($batchId) {
                    // Get token limit for this specific batch
                    $slotToken = isset($slot['token']) ? (int)$slot['token'] : $tokenLimit;
                    $slotTokens[$batchId] = $slotToken;
                    $slotCapacity[$batchId] = $slotToken;
                }
            }
        }
    }

    $row['slot_capacity'] = $slotCapacity;
    $row['slot_tokens'] = $slotTokens;

    /***** Calculate availability for next 30 days *****/
    $futureAvailability = [];
    $today = new DateTime();
    
    for ($i = 0; $i < 30; $i++) {
        $date = clone $today;
        $date->modify("+{$i} days");
        $dateStr = $date->format('Y-m-d');
        $dayOfWeek = $date->format('D');
        
        // Check if date is a leave day
        $isLeaveDay = in_array($dateStr, $row['leaveDates']);
        
        // Check if doctor has schedule for this day
        $hasSchedule = isset($weeklySchedule[$dayOfWeek]) && 
                      $weeklySchedule[$dayOfWeek]['enabled'] &&
                      !empty($weeklySchedule[$dayOfWeek]['slots']);
        
        if (!$isLeaveDay && $hasSchedule) {
            $daySlots = $weeklySchedule[$dayOfWeek]['slots'];
            $availableSlots = [];
            
            foreach ($daySlots as $slot) {
                $batchId = $slot["batch_id"] ?? '';
                if ($batchId) {
                    // Check token availability
                    $key = $dateStr . "_" . $batchId;
                    $bookedCount = $bookings[$key] ?? 0;
                    $slotTokenLimit = $slotTokens[$batchId] ?? $tokenLimit;
                    
                    if ($slotTokenLimit > $bookedCount) {
                        $slotData = [
                            'batch_id' => $batchId,
                            'from' => $slot['from'],
                            'to' => $slot['to'],
                            'token' => $slotTokenLimit,
                            'booked' => $bookedCount,
                            'total' => $slotTokenLimit,
                            'available' => $slotTokenLimit - $bookedCount
                        ];
                        
                        // Add token count to slot
                        if (isset($slot['token'])) {
                            $slotData['original_token'] = $slot['token'];
                        }
                        
                        $availableSlots[] = $slotData;
                    }
                }
            }
            
            if (count($availableSlots) > 0) {
                $futureAvailability[$dateStr] = [
                    'date' => $dateStr,
                    'day' => $dayOfWeek,
                    'enabled' => true,
                    'slots' => $availableSlots,
                    'available_slots' => count($availableSlots),
                    'isLeaveDay' => false
                ];
            }
        }
    }
    
    $row['futureSchedule'] = $futureAvailability;
    $row['hasWeeklySchedule'] = !empty($weeklySchedule);

    unset($row['weekly_schedule'], $row['leave_dates']);

    /***** Merge doctor/category images *****/
    if (!empty($row['cat_doctor_image'])) {
        $row['doctorImage'] = $row['cat_doctor_image'];
    }
    unset($row['cat_doctor_image']);
}

/***************************
 *  RETURN API RESULT WITH BOOKINGS DATA
 ***************************/
echo json_encode([
    "success" => true,
    "records" => $records,
    "bookings" => $bookings, // Send bookings data to frontend
    "message" => "Data retrieved with token availability"
]);
?>