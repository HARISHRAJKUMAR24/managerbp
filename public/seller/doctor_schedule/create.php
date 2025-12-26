<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* ===============================
   READ INPUT
================================ */
$raw = file_get_contents("php://input");
$input = json_decode($raw, true);

/* ===============================
   DEBUG (KEEP TEMPORARILY)
================================ */
file_put_contents(
    __DIR__ . "/debug.log",
    date("Y-m-d H:i:s") . " | RAW=" . $raw . PHP_EOL,
    FILE_APPEND
);

/* ===============================
   BASIC VALIDATION
================================ */
if (empty($input["user_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "user_id required"
    ]);
    exit;
}

/* ===============================
   AMOUNT — BULLETPROOF FIX
================================ */

/* 1. Get raw value */
$amountRaw = $input["amount"] ?? "";

/* 2. Normalize */
if (is_string($amountRaw)) {
    $amountRaw = trim($amountRaw);
}

/* 3. Convert empty to zero */
if ($amountRaw === "" || $amountRaw === null) {
    $amountValue = 0;
} else {
    $amountValue = (float)$amountRaw;
}

/* 4. Final validation */
if (!is_numeric($amountValue) || $amountValue <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid amount",
        "debug" => [
            "received" => $input["amount"] ?? null
        ]
    ]);
    exit;
}

/* ===============================
   FETCH DOCTOR DETAILS
================================ */
$categoryId = !empty($input["categoryId"]) ? (int)$input["categoryId"] : null;
$doctorDetails = null;

if ($categoryId) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$categoryId]);
    $doctorDetails = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* ===============================
   SAFE VALUES
================================ */
$loc = $input["doctorLocation"] ?? [];

$doctorName     = $doctorDetails["doctor_name"] ?? "";
$specialization = $doctorDetails["specialization"] ?? "";
$qualification  = $doctorDetails["qualification"] ?? "";
$experience     = isset($doctorDetails["experience"])
    ? (int)$doctorDetails["experience"]
    : null;
$doctorImage    = $doctorDetails["doctor_image"] ?? "";

/* ===============================
   INSERT
================================ */
$sql = "INSERT INTO doctor_schedule (
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
    meta_title,
    meta_description,
    country,
    state,
    city,
    pincode,
    address,
    map_link,
    weekly_schedule,
    created_at
) VALUES (
    :user_id,
    :category_id,
    :name,
    :slug,
    :amount,
    :description,
    :specialization,
    :qualification,
    :experience,
    :doctor_image,
    :meta_title,
    :meta_description,
    :country,
    :state,
    :city,
    :pincode,
    :address,
    :map_link,
    :weekly_schedule,
    NOW()
)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":user_id" => (int)$input["user_id"],
    ":category_id" => $categoryId,
    ":name" => $doctorName,
    ":slug" => $input["slug"] ?? "",
    ":amount" => $amountValue,   // 🔥 FLOAT — PERFECT FOR DECIMAL
    ":description" => $input["description"] ?? "",
    ":specialization" => $specialization,
    ":qualification" => $qualification,
    ":experience" => $experience,
    ":doctor_image" => $doctorImage,
    ":meta_title" => $input["metaTitle"] ?? "",
    ":meta_description" => $input["metaDescription"] ?? "",
    ":country" => $loc["country"] ?? "",
    ":state" => $loc["state"] ?? "",
    ":city" => $loc["city"] ?? "",
    ":pincode" => $loc["pincode"] ?? "",
    ":address" => $loc["address"] ?? "",
    ":map_link" => $loc["mapLink"] ?? "",
    ":weekly_schedule" => json_encode($input["weeklySchedule"] ?? [])
]);

echo json_encode([
    "success" => true,
    "message" => "Doctor schedule created successfully",
    "id" => $pdo->lastInsertId(),
    "amount_saved" => $amountValue
]);
