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
   UPDATE PAYMENT STATUS
-------------------------------- */
$update = $db->prepare("
    UPDATE customer_payment 
    SET 
        payment_id = ?,            
        signature  = ?, 
        status     = 'paid'
    WHERE payment_id = ?
");

$update->execute([
    $razorpay_payment_id,
    $razorpay_signature,
    $razorpay_order_id
]);

/* ---------------------------------------
   REDUCE TOKEN (FRONTEND MUST SEND DATA)
-----------------------------------------*/
$doctorId     = $input["doctor_id"]      ?? null;
$selectedDate = $input["selected_date"]  ?? null;
$slotFrom     = $input["slot_from"]      ?? null;
$slotTo       = $input["slot_to"]        ?? null;
$bookedTokens = intval($input["token"]   ?? 0);

if ($doctorId && $selectedDate && $slotFrom && $slotTo && $bookedTokens > 0) {

    $docStmt = $db->prepare("
        SELECT weekly_schedule 
        FROM doctor_schedule 
        WHERE id = ? LIMIT 1
    ");
    $docStmt->execute([$doctorId]);
    $doctorData = $docStmt->fetch(PDO::FETCH_ASSOC);

    if ($doctorData) {

        $schedule = json_decode($doctorData["weekly_schedule"], true);

        $day = date("D", strtotime($selectedDate)); // "Mon", "Tue", etc.

        if (isset($schedule[$day]["slots"])) {

            foreach ($schedule[$day]["slots"] as $i => $slot) {

                if ($slot["from"] === $slotFrom && $slot["to"] === $slotTo) {

                    $current = intval($slot["token"]);
                    $newToken = max(0, $current - $bookedTokens);

                    $schedule[$day]["slots"][$i]["token"] = $newToken;
                }
            }

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
        }
    }
}

/* -------------------------------
   SUCCESS RESPONSE
-------------------------------- */
echo json_encode([
    "success" => true,
    "message" => "Payment verified successfully",
    "appointment_id" => $order["appointment_id"],
    "redirect_url" => "/payment-success"
]);
exit;

?>
