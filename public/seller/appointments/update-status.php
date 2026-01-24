<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Origin, Accept");
header("Access-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* =======================
   AUTH BY TOKEN
======================= */
$token = $_COOKIE["token"] ?? null;

if (!$token) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$stmt = $pdo->prepare("SELECT user_id FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit;
}

$userId = $user["user_id"];

/* =======================
   GET JSON INPUT
======================= */
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Debug logging - remove in production
error_log("Update Status Request: " . print_r($data, true));

$appointmentId = $data['appointment_id'] ?? null;
$newStatus = $data['status'] ?? null;

if (!$appointmentId || !$newStatus) {
    echo json_encode([
        "success" => false, 
        "message" => "Missing required fields",
        "debug" => ["appointment_id" => $appointmentId, "status" => $newStatus]
    ]);
    exit;
}

// Normalize status values (cancel -> cancelled)
if (strtolower($newStatus) === 'cancel') {
    $newStatus = 'cancelled';
}

// Validate status values
$allowedStatuses = ['paid', 'pending', 'waiting', 'cancelled'];
$newStatusLower = strtolower($newStatus);
if (!in_array($newStatusLower, $allowedStatuses)) {
    echo json_encode([
        "success" => false, 
        "message" => "Invalid status. Allowed: paid, pending, waiting, cancelled",
        "received" => $newStatus
    ]);
    exit;
}

/* =======================
   CHECK IF APPOINTMENT EXISTS AND BELONGS TO USER
======================= */
$checkStmt = $pdo->prepare("
    SELECT id FROM customer_payment 
    WHERE appointment_id = ? AND user_id = ?
");
$checkStmt->execute([$appointmentId, $userId]);
$appointment = $checkStmt->fetch(PDO::FETCH_ASSOC);

if (!$appointment) {
    echo json_encode([
        "success" => false, 
        "message" => "Appointment not found or you don't have permission"
    ]);
    exit;
}

/* =======================
   UPDATE THE STATUS
======================= */
$updateStmt = $pdo->prepare("
    UPDATE customer_payment 
    SET status = ? 
    WHERE appointment_id = ? AND user_id = ?
");

try {
    $updateStmt->execute([$newStatusLower, $appointmentId, $userId]);
    
    if ($updateStmt->rowCount() > 0) {
        // Fetch updated record to return
        $fetchStmt = $pdo->prepare("
            SELECT * FROM customer_payment 
            WHERE appointment_id = ? AND user_id = ?
        ");
        $fetchStmt->execute([$appointmentId, $userId]);
        $updatedRecord = $fetchStmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode([
            "success" => true,
            "message" => "Status updated successfully",
            "data" => [
                "appointment_id" => $appointmentId,
                "new_status" => $newStatusLower,
                "record" => $updatedRecord
            ]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No changes made. Status might already be set to: " . $newStatusLower
        ]);
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Database error",
        "error" => $e->getMessage()
    ]);
}