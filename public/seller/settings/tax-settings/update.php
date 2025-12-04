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

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Debug: Check what we received
error_log("Received data: " . print_r($data, true));

// Validate required data
if (!isset($data['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User ID is required'
    ]);
    exit();
}

$user_id = $data['user_id'];

// Extract data with defaults
$gst_number = isset($data['gstNumber']) ? trim($data['gstNumber']) : '';
$gst_type = isset($data['gstType']) ? trim($data['gstType']) : '';
$tax_percent = isset($data['taxPercent']) ? $data['taxPercent'] : null;
$country = isset($data['country']) ? trim($data['country']) : '';
$state = isset($data['state']) ? trim($data['state']) : '';

// Check if this is a clear action
$isClearAction = false;
if (isset($data['gstNumber']) && $data['gstNumber'] === null) {
    $isClearAction = true;
    $gst_number = null;
    $gst_type = null;
    $tax_percent = null;
    $country = null;
    $state = null;
}

if (!$isClearAction) {
    // Validate required fields for save
    if (empty($gst_number)) {
        echo json_encode(['success' => false, 'message' => 'GST Number is required']);
        exit();
    }
    if (empty($gst_type)) {
        echo json_encode(['success' => false, 'message' => 'GST Type is required']);
        exit();
    }
    if ($tax_percent === null || $tax_percent === '') {
        echo json_encode(['success' => false, 'message' => 'Tax Percentage is required']);
        exit();
    }
    
    // Convert tax percent to float
    $tax_percent = floatval($tax_percent);
}

// Database connection
$host = 'localhost';
$dbname = 'admin_bookpannu';
$username = 'root';  // Change if different
$password = '';      // Change if different

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if record exists
    $checkSql = "SELECT COUNT(*) FROM site_settings WHERE user_id = ?";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([$user_id]);
    $exists = $checkStmt->fetchColumn() > 0;
    
    if ($exists) {
        // Update existing record
        $sql = "UPDATE site_settings SET 
                gst_number = ?, 
                gst_type = ?,
                tax_percent = ?,
                country = ?,
                state = ?
                WHERE user_id = ?";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            $gst_number,
            $gst_type,
            $tax_percent,
            $country,
            $state,
            $user_id
        ]);
    } else {
        // Insert new record
        $sql = "INSERT INTO site_settings 
                (user_id, gst_number, gst_type, tax_percent, country, state, currency) 
                VALUES (?, ?, ?, ?, ?, ?, 'INR')";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            $user_id,
            $gst_number,
            $gst_type,
            $tax_percent,
            $country,
            $state
        ]);
    }
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => $isClearAction ? 'Tax settings cleared successfully' : 'Tax settings saved successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to save tax settings'
        ]);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    
    // Check for duplicate GST number
    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
        echo json_encode([
            'success' => false,
            'message' => 'This GST number is already registered by another user'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
    exit();
}