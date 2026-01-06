<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* =====================================================
   1️⃣ READ TOKEN (JSON BODY OR COOKIE)
===================================================== */
$raw  = file_get_contents("php://input");
$data = json_decode($raw, true) ?? [];

$token =
    ($data["token"] ?? null)
    ?: ($_COOKIE["token"] ?? null);

if (!$token) {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized: Missing token"
    ]);
    exit;
}

/* =====================================================
   2️⃣ FETCH USER USING TOKEN
===================================================== */
$stmt = $pdo->prepare("
    SELECT user_id 
    FROM users 
    WHERE api_token = ? 
    LIMIT 1
");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid token"
    ]);
    exit;
}

$user_id = (int) $user["user_id"]; // ✅ 27395

/* =====================================================
   3️⃣ VALIDATE PAYLOAD
===================================================== */
$timing        = $data["timing"] ?? null;
$operatingDays = $data["operatingDays"] ?? [];
$tables        = $data["tables"] ?? [];
$breakSchedule = $data["breakSchedule"] ?? null;

if (!$timing || empty($tables)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid payload"
    ]);
    exit;
}

/* =====================================================
   4️⃣ TRANSACTION
===================================================== */
$pdo->beginTransaction();

try {

    /* UPSERT restaurant_settings */
    $stmt = $pdo->prepare("
        INSERT INTO restaurant_settings
        (user_id, start_time, start_meridiem, end_time, end_meridiem, break_start, break_end, operating_days)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            start_time = VALUES(start_time),
            start_meridiem = VALUES(start_meridiem),
            end_time = VALUES(end_time),
            end_meridiem = VALUES(end_meridiem),
            break_start = VALUES(break_start),
            break_end = VALUES(break_end),
            operating_days = VALUES(operating_days)
    ");

    $stmt->execute([
        $user_id,
        $timing["startTime"],
        $timing["startMeridiem"],
        $timing["endTime"],
        $timing["endMeridiem"],
        $breakSchedule["breakStart"] ?? null,
        $breakSchedule["breakEnd"] ?? null,
        json_encode($operatingDays)
    ]);

    /* REPLACE restaurant_tables */
    $pdo->prepare("
        DELETE FROM restaurant_tables WHERE user_id = ?
    ")->execute([$user_id]);

    $insert = $pdo->prepare("
        INSERT INTO restaurant_tables (user_id, table_number, seats)
        VALUES (?, ?, ?)
    ");

    foreach ($tables as $t) {
        $insert->execute([
            $user_id,
            $t["tableNumber"],
            (int) $t["seats"]
        ]);
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Table settings saved successfully"
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode([
        "success" => false,
        "message" => "Save failed",
        "error" => $e->getMessage()
    ]);
}
