<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* =========================
   OPTIONS PREFLIGHT
========================= */
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

/* =========================
   READ INPUT
========================= */
$rawInput = file_get_contents("php://input");
$input = json_decode($rawInput, true);

if (!$input || empty($input["id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid input or ID missing"
    ]);
    exit;
}

$id = (int)$input["id"];

/* =========================
   NORMALIZE INPUT
========================= */
$category_id = isset($input["categoryId"]) && $input["categoryId"] !== ""
    ? (int)$input["categoryId"]
    : null;

$name = $input["name"] ?? ($input["doctor_name"] ?? "");
$slug = $input["slug"] ?? "";

$amount = isset($input["amount"]) && is_numeric($input["amount"])
    ? (float)$input["amount"]
    : 0;

/* =========================
   TOKEN LIMIT (✅ FIX)
========================= */
$tokenRaw = $input["tokenLimit"] ?? null;

if ($tokenRaw === "" || $tokenRaw === null) {
    $token_limit = 0; // unlimited
} else {
    $token_limit = (int)$tokenRaw;
}

if ($token_limit < 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid token limit"
    ]);
    exit;
}

$description = $input["description"] ?? "";
$specialization = $input["specialization"] ?? "";
$qualification = $input["qualification"] ?? "";

$experience = isset($input["experience"]) && is_numeric($input["experience"])
    ? (int)$input["experience"]
    : 0;

$doctor_image = $input["doctorImage"] ?? ($input["doctor_image"] ?? "");
$meta_title = $input["metaTitle"] ?? "";
$meta_description = $input["metaDescription"] ?? "";

/* =========================
   LOCATION
========================= */
$loc = $input["doctorLocation"] ?? [];

$country  = $loc["country"] ?? "";
$state    = $loc["state"] ?? "";
$city     = $loc["city"] ?? "";
$pincode  = $loc["pincode"] ?? "";
$address  = $loc["address"] ?? "";
$map_link = $loc["mapLink"] ?? "";

/* =========================
   SCHEDULES
========================= */
$weekly_schedule = json_encode(
    $input["weeklySchedule"] ?? [],
    JSON_UNESCAPED_UNICODE
);

$leave_dates = json_encode(
    $input["leaveDates"] ?? [],
    JSON_UNESCAPED_UNICODE
);

/* =========================
   UPDATE QUERY (✅ FIX)
========================= */
$sql = "
UPDATE doctor_schedule SET
    category_id      = :category_id,
    name             = :name,
    slug             = :slug,
    amount           = :amount,
    token_limit      = :token_limit,
    description      = :description,
    specialization   = :specialization,
    qualification    = :qualification,
    experience       = :experience,
    doctor_image     = :doctor_image,
    meta_title       = :meta_title,
    meta_description = :meta_description,
    country          = :country,
    state            = :state,
    city             = :city,
    pincode          = :pincode,
    address          = :address,
    map_link         = :map_link,
    weekly_schedule  = :weekly_schedule,
    leave_dates      = :leave_dates,
    updated_at       = NOW()
WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id,
    ":category_id" => $category_id,
    ":name" => $name,
    ":slug" => $slug,
    ":amount" => $amount,
    ":token_limit" => $token_limit, // ✅ FIX
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
    ":leave_dates" => $leave_dates
]);

/* =========================
   RESPONSE
========================= */
echo json_encode([
    "success" => true,
    "message" => "Doctor schedule updated successfully",
    "updated_id" => $id,
    "token_limit_saved" => $token_limit
]);
