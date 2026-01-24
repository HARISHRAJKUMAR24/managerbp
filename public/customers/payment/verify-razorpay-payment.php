<?php
// managerbp/public/customers/payment/verify-razorpay-payment.php

/* -------------------------------
   CORS SETTINGS
-------------------------------- */
$allowedOrigins = [
    "http://localhost:3000",
    "http://localhost:3001",
    "http://localhost"
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";
require_once "../../../src/functions.php";

/* -------------------------------
   READ INPUT
-------------------------------- */
$input = json_decode(file_get_contents("php://input"), true);

$required = [
    "razorpay_payment_id",
    "razorpay_order_id",
    "razorpay_signature"
];

foreach ($required as $field) {
    if (empty($input[$field])) {
        echo json_encode([
            "success" => false,
            "message" => "Missing field: $field"
        ]);
        exit;
    }
}

$razorpay_payment_id = $input["razorpay_payment_id"];
$razorpay_order_id   = $input["razorpay_order_id"];
$razorpay_signature  = $input["razorpay_signature"];

// Appointment details
$appointment_date = $input["appointment_date"] ?? null;
$slot_from        = $input["slot_from"] ?? null;
$slot_to          = $input["slot_to"] ?? null;
$token_count      = intval($input["token_count"] ?? 1);

// ⭐ Get category_id from frontend
$category_id = $input["category_id"] ?? null;

// ⭐ NEW: Get batch_id from frontend
$batch_id = $input["batch_id"] ?? null;

$db = getDbConnection();

/* -------------------------------
   FETCH ORDER FROM DB
-------------------------------- */
$stmt = $db->prepare("
    SELECT * FROM customer_payment 
    WHERE payment_id = ? 
    LIMIT 1
");
$stmt->execute([$razorpay_order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo json_encode([
        "success" => false,
        "message" => "Order not found in database"
    ]);
    exit;
}

$user_id = $order["user_id"];
$customer_id = $order["customer_id"];

/* -------------------------------
   GET SELLER RAZORPAY KEYS
-------------------------------- */
$stmt2 = $db->prepare("
    SELECT razorpay_key_id, razorpay_secret_key 
    FROM site_settings 
    WHERE user_id = ? LIMIT 1
");
$stmt2->execute([$user_id]);
$settings = $stmt2->fetch(PDO::FETCH_ASSOC);

if (!$settings) {
    echo json_encode([
        "success" => false,
        "message" => "Razorpay settings missing for seller"
    ]);
    exit;
}

$key_secret = $settings["razorpay_secret_key"];

/* -------------------------------
   VERIFY SIGNATURE
-------------------------------- */
$generated_signature = hash_hmac(
    "sha256",
    $razorpay_order_id . "|" . $razorpay_payment_id,
    $key_secret
);

if ($generated_signature !== $razorpay_signature) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid signature - Payment tampered"
    ]);
    exit;
}

/* -------------------------------
   ⭐ UPDATE PAYMENT WITH PAYMENT_ID, BATCH_ID & APPOINTMENT DETAILS
-------------------------------- */
$update = $db->prepare("
    UPDATE customer_payment 
    SET 
        payment_id = ?,      -- Store Razorpay Payment ID
        signature = ?, 
        status = 'paid',
        appointment_date = ?,
        slot_from = ?,
        slot_to = ?,
        token_count = ?,
        batch_id = ?         -- ⭐ Store batch_id
    WHERE id = ?
");

$update->execute([
    $razorpay_payment_id,
    $razorpay_signature,
    $appointment_date,
    $slot_from,
    $slot_to,
    $token_count,
    $batch_id,              // ⭐ Add batch_id here
    $order["id"]
]);

/* -------------------------------
   ⭐ STORE CATEGORY REFERENCE (CAT_xxx)
-------------------------------- */
if ($category_id) {
    // Use the specific category_id from frontend
    $serviceResult = updatePaymentWithCategoryReference(
        $user_id, 
        $customer_id, 
        $razorpay_payment_id,
        $category_id  // CAT_xxx
    );
} else {
    // Fallback to old method (get first category)
    $serviceResult = updatePaymentWithCategoryReference(
        $user_id, 
        $customer_id, 
        $razorpay_payment_id
    );
}

/* -------------------------------
   ⭐ UPDATE TOKEN AVAILABILITY FOR THIS BATCH
-------------------------------- */
if ($batch_id && $appointment_date) {
    try {
        // Extract day index and slot index from batch_id (format: "dayIndex:slotIndex")
        $batchParts = explode(':', $batch_id);
        if (count($batchParts) === 2) {
            $dayIndex = intval($batchParts[0]); // 0=Sun, 1=Mon, etc.
            $slotIndex = intval($batchParts[1]); // Slot index within that day
            
            // Convert appointment date to day name
            $dayName = date('D', strtotime($appointment_date));
            
            // Get doctor schedule for this category
            $stmtDoctor = $db->prepare("
                SELECT weekly_schedule 
                FROM doctor_schedule 
                WHERE category_id = ? 
                AND user_id = ?
                LIMIT 1
            ");
            $stmtDoctor->execute([$category_id, $user_id]);
            $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);
            
            if ($doctor && $doctor['weekly_schedule']) {
                $weeklySchedule = json_decode($doctor['weekly_schedule'], true);
                
                // Reduce token availability for this specific batch
                if (isset($weeklySchedule[$dayName]['slots'][$slotIndex])) {
                    $currentTokens = intval($weeklySchedule[$dayName]['slots'][$slotIndex]['token'] ?? 0);
                    $newTokens = max(0, $currentTokens - $token_count);
                    $weeklySchedule[$dayName]['slots'][$slotIndex]['token'] = strval($newTokens);
                    
                    // Update the schedule
                    $updateSchedule = $db->prepare("
                        UPDATE doctor_schedule 
                        SET weekly_schedule = ? 
                        WHERE category_id = ? 
                        AND user_id = ?
                    ");
                    $updateSchedule->execute([
                        json_encode($weeklySchedule),
                        $category_id,
                        $user_id
                    ]);
                    
                    $tokenUpdateMessage = "Token availability updated for batch $batch_id: $currentTokens -> $newTokens";
                }
            }
        }
    } catch (Exception $e) {
        // Log error but don't fail the payment
        error_log("Batch token update error: " . $e->getMessage());
    }
}

/* -------------------------------
   SUCCESS RESPONSE
-------------------------------- */
echo json_encode([
    "success" => true,
    "message" => "Payment verified successfully",
    "appointment_id" => $order["appointment_id"],
    "razorpay_payment_id" => $razorpay_payment_id,
    "service_reference" => $serviceResult,
    "redirect_url" => "/payment-success",
    "stored_data" => [
        "appointment_date" => $appointment_date,
        "slot_from" => $slot_from,
        "slot_to" => $slot_to,
        "token_count" => $token_count,
        "category_id" => $category_id,
        "batch_id" => $batch_id  // ⭐ Confirm batch_id was stored
    ],
    "token_update" => $tokenUpdateMessage ?? "No token update performed"
]);
exit;
?>