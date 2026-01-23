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

// ⭐ NEW: Get the specific service/doctor ID that was booked
$specific_service_id = $input["service_id"] ?? $input["doctor_id"] ?? $input["category_id"] ?? null;

$db = getDbConnection();

/* -------------------------------
   FETCH ORDER FROM DB (using order_id)
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
   UPDATE PAYMENT WITH PAYMENT_ID & APPOINTMENT DETAILS
-------------------------------- */
$update = $db->prepare("
    UPDATE customer_payment 
    SET 
        payment_id = ?,  -- Store Razorpay Payment ID (not order ID)
        signature = ?, 
        status = 'paid',
        appointment_date = ?,
        slot_from = ?,
        slot_to = ?,
        token_count = ?
    WHERE id = ?  -- Use primary key to be safe
");

$update->execute([
    $razorpay_payment_id,
    $razorpay_signature,
    $appointment_date,
    $slot_from,
    $slot_to,
    $token_count,
    $order["id"]
]);

/* -------------------------------
   ⭐ STORE SPECIFIC SERVICE REFERENCE (NEW - NO LIMIT 1)
   This stores the ACTUAL doctor/department the user selected
-------------------------------- */
$serviceResult = [
    'success' => false,
    'message' => 'No service ID provided'
];

if ($specific_service_id) {
    // Determine if it's a category or department ID
    $is_category = (strpos($specific_service_id, 'CAT_') === 0);
    $is_department = (strpos($specific_service_id, 'DEPT_') === 0);
    
    $reference_id = null;
    $reference_type = null;
    $reference_name = null;
    
    if ($is_category) {
        // It's a category/doctor ID
        $stmt = $db->prepare("
            SELECT category_id as ref_id, name, doctor_name 
            FROM categories 
            WHERE category_id = ? 
            AND user_id = ?
        ");
        $stmt->execute([$specific_service_id, $user_id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($service) {
            $reference_id = $service['ref_id'];
            $reference_type = 'category_id';
            $reference_name = $service['doctor_name'] ?? $service['name'];
        }
    } elseif ($is_department) {
        // It's a department ID
        $stmt = $db->prepare("
            SELECT department_id as ref_id, name 
            FROM departments 
            WHERE department_id = ? 
            AND user_id = ?
        ");
        $stmt->execute([$specific_service_id, $user_id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($service) {
            $reference_id = $service['ref_id'];
            $reference_type = 'department_id';
            $reference_name = $service['name'];
        }
    }
    
    if ($reference_id) {
        // Update the payment record with specific service
        $updateService = $db->prepare("
            UPDATE customer_payment 
            SET 
                service_reference_id = ?,
                service_reference_type = ?,
                service_name = ?
            WHERE user_id = ? 
            AND customer_id = ? 
            AND payment_id = ?
            LIMIT 1
        ");
        
        $updateService->execute([
            $reference_id,
            $reference_type,
            $reference_name,
            $user_id,
            $customer_id,
            $razorpay_payment_id
        ]);
        
        $serviceResult = [
            'success' => true,
            'message' => 'Specific service reference stored',
            'data' => [
                'reference_id' => $reference_id,
                'reference_type' => $reference_type,
                'service_name' => $reference_name
            ]
        ];
    } else {
        $serviceResult = [
            'success' => false,
            'message' => 'Service not found with ID: ' . $specific_service_id
        ];
    }
}

/* -------------------------------
   REDUCE TOKEN COUNT IN DOCTOR SCHEDULE (Optional - if you have this feature)
-------------------------------- */
$doctorId = $input["doctor_db_id"] ?? null; // Doctor's database ID (not category_id)
if ($doctorId && $appointment_date && $slot_from && $slot_to && $token_count > 0) {
    try {
        $docStmt = $db->prepare("
            SELECT weekly_schedule 
            FROM doctor_schedule 
            WHERE id = ? LIMIT 1
        ");
        $docStmt->execute([$doctorId]);
        $doctorData = $docStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($doctorData && $doctorData["weekly_schedule"]) {
            $schedule = json_decode($doctorData["weekly_schedule"], true);
            $day = date("D", strtotime($appointment_date)); // "Mon", "Tue", etc.
            
            if (isset($schedule[$day]["slots"])) {
                foreach ($schedule[$day]["slots"] as $i => $slot) {
                    if ($slot["from"] === $slot_from && $slot["to"] === $slot_to) {
                        $current = intval($slot["token"] ?? 0);
                        $newToken = max(0, $current - $token_count);
                        
                        $schedule[$day]["slots"][$i]["token"] = $newToken;
                        
                        // Save updated schedule
                        $updateSchedule = $db->prepare("
                            UPDATE doctor_schedule 
                            SET weekly_schedule = ?
                            WHERE id = ?
                        ");
                        $updateSchedule->execute([
                            json_encode($schedule, JSON_UNESCAPED_SLASHES),
                            $doctorId
                        ]);
                        break;
                    }
                }
            }
        }
    } catch (Exception $e) {
        // Log error but don't fail payment
        error_log("Token reduction error: " . $e->getMessage());
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
    "service_reference" => $serviceResult, // Include service reference info
    "redirect_url" => "/payment-success",
    "stored_data" => [
        "appointment_date" => $appointment_date,
        "slot_from" => $slot_from,
        "slot_to" => $slot_to,
        "token_count" => $token_count,
        "service_id" => $specific_service_id
    ]
]);
exit;
?>