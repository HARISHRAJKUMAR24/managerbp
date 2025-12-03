<?php
// managerbp/public/seller/settings/tax-settings/update.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();

$data = json_decode(file_get_contents("php://input"), true);

// Debug: Log received data
error_log("Tax Settings Update - Received: " . json_encode($data));

// Get user ID
$user_id = $data['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID required"]);
    exit();
}

// Check what action is being performed
$gst_number = isset($data['gstNumber']) ? trim($data['gstNumber']) : '';
$gst_type = isset($data['gstType']) ? trim($data['gstType']) : '';
$tax_percent = isset($data['taxPercent']) ? $data['taxPercent'] : '';

// ✅ Determine if this is "clear all" or "save data"
// If all values are explicitly null, it's a "clear" action
$isClearAction = 
    (isset($data['gstNumber']) && $data['gstNumber'] === null) &&
    (isset($data['gstType']) && $data['gstType'] === null) &&
    (isset($data['taxPercent']) && $data['taxPercent'] === null);

if ($isClearAction) {
    // ✅ Clear all tax settings (turn OFF GST)
    $gst_number = null;
    $gst_type = null;
    $tax_percent = null;
} else {
    // ✅ Save/Update tax settings (turn ON GST)
    // Validate all required fields
    if (empty($gst_number)) {
        echo json_encode(["success" => false, "message" => "GST Number is required"]);
        exit();
    }
    
    if (empty($gst_type)) {
        echo json_encode(["success" => false, "message" => "GST Type is required"]);
        exit();
    }
    
    if (empty($tax_percent) && $tax_percent !== '0') {
        echo json_encode(["success" => false, "message" => "Tax Percentage is required"]);
        exit();
    }
    
    $tax_percent = (float)$tax_percent;
}

// Check if settings already exist for user
$checkSql = "SELECT COUNT(*) FROM users_settings WHERE user_id = :user_id";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([':user_id' => $user_id]);
$exists = $checkStmt->fetchColumn() > 0;

if ($exists) {
    // Update existing record
    $sql = "UPDATE users_settings 
            SET gst_number = :gst_number, 
                gst_type = :gst_type, 
                tax_percent = :tax_percent 
            WHERE user_id = :user_id";
} else {
    // Insert new record
    $sql = "INSERT INTO users_settings (user_id, gst_number, gst_type, tax_percent) 
            VALUES (:user_id, :gst_number, :gst_type, :tax_percent)";
}

$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    ':user_id' => $user_id,
    ':gst_number' => $gst_number,
    ':gst_type' => $gst_type,
    ':tax_percent' => $tax_percent
]);

if ($result) {
    $action = $isClearAction ? "cleared" : "saved";
    error_log("Tax settings $action for user: $user_id");
    echo json_encode([
        "success" => true,
        "message" => $isClearAction ? "Tax settings cleared" : "Tax settings saved successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to update tax settings"
    ]);
}