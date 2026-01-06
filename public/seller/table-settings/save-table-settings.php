<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* ===============================
   CORS (MATCHES YOUR PROJECT)
================================ */
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

/* ===============================
   LOAD PROJECT CONFIG (IMPORTANT)
================================ */
require_once "../../../config/config.php";
require_once "../../../src/database.php";

/* ===============================
   DB CONNECTION (PDO)
================================ */
try {
    $pdo = getDbConnection();
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed",
        "error" => $e->getMessage()
    ]);
    exit;
}

/* ===============================
   READ RAW JSON
================================ */
$raw = file_get_contents("php://input");

if (!$raw || trim($raw) === "") {
    echo json_encode([
        "success" => false,
        "message" => "Empty request body"
    ]);
    exit;
}

$data = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON"
    ]);
    exit;
}

/* ===============================
   EXTRACT DATA
================================ */
$timing = $data["timing"] ?? null;
$operatingDays = $data["operatingDays"] ?? [];
$tables = $data["tables"] ?? [];
$breakSchedule = $data["breakSchedule"] ?? null;

if (!$timing) {
    echo json_encode([
        "success" => false,
        "message" => "Timing data missing"
    ]);
    exit;
}

/* ===============================
   INSERT RESTAURANT SETTINGS
================================ */
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO restaurant_settings
        (start_time, start_meridiem, end_time, end_meridiem, break_start, break_end, operating_days)
        VALUES (:start_time, :start_meridiem, :end_time, :end_meridiem, :break_start, :break_end, :operating_days)
    ");

    $stmt->execute([
        ":start_time"      => $timing["startTime"],
        ":start_meridiem"  => $timing["startMeridiem"],
        ":end_time"        => $timing["endTime"],
        ":end_meridiem"    => $timing["endMeridiem"],
        ":break_start"     => $breakSchedule["breakStart"] ?? null,
        ":break_end"       => $breakSchedule["breakEnd"] ?? null,
        ":operating_days"  => json_encode($operatingDays),
    ]);

    $settingsId = $pdo->lastInsertId();

    /* ===============================
       INSERT TABLES
    ================================ */
    $tableStmt = $pdo->prepare("
        INSERT INTO tables (table_number, seats, settings_id)
        VALUES (:table_number, :seats, :settings_id)
    ");

    foreach ($tables as $table) {
        $tableStmt->execute([
            ":table_number" => $table["tableNumber"],
            ":seats"        => (int)$table["seats"],
            ":settings_id"  => $settingsId
        ]);
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Settings saved successfully",
        "settings_id" => $settingsId
    ]);
    exit;

} catch (Exception $e) {
    $pdo->rollBack();

    echo json_encode([
        "success" => false,
        "message" => "Failed to save settings",
        "error" => $e->getMessage()
    ]);
    exit;
}
