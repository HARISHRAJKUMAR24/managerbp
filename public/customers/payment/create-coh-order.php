<?php
// managerbp/public/customers/payment/create-coh-order.php

/* -------------------------------
   CORS SETTINGS
-------------------------------- */
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Handle OPTIONS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Start output buffering
ob_start();

try {
    // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Only POST requests are allowed');
    }

    // Get the raw POST data
    $json = file_get_contents('php://input');
    
    if (empty($json)) {
        throw new Exception('No data received');
    }

    // Decode JSON
    $input = json_decode($json, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }

    // Check required fields
    if (empty($input['user_id']) || empty($input['customer_id']) || empty($input['appointment_id'])) {
        throw new Exception('Missing required fields: user_id, customer_id, or appointment_id');
    }

    // Include database connection
    $config_path = __DIR__ . '/../../../config/config.php';
    $database_path = __DIR__ . '/../../../src/database.php';
    $functions_path = __DIR__ . '/../../../src/functions.php';
    
    require_once $config_path;
    require_once $database_path;
    
    if (file_exists($functions_path)) {
        require_once $functions_path;
    }

    $db = getDbConnection();
    
    // Extract data with defaults
    $user_id = (int) $input['user_id'];
    $customer_id = (int) $input['customer_id'];
    $appointment_id = $input['appointment_id'];
    $customer_name = $input['customer_name'] ?? '';
    $customer_email = $input['customer_email'] ?? '';
    $customer_phone = $input['customer_phone'] ?? '';
    $total_amount = (float) ($input['amount'] ?? 0);
    
    // Appointment details
    $appointment_date = $input['appointment_date'] ?? date('Y-m-d');
    $slot_from = $input['slot_from'] ?? '';
    $slot_to = $input['slot_to'] ?? '';
    $token_count = (int) ($input['token_count'] ?? 1);
    $category_id = $input['category_id'] ?? null;
    
    // GST Details
    $gst_type = $input['gst_type'] ?? '';
    $gst_percent = (float) ($input['gst_percent'] ?? 0);
    $gst_amount = (float) ($input['gst_amount'] ?? 0);
    $sub_total = (float) ($input['subTotal'] ?? $total_amount);
    
    // Check if cash_in_hand is enabled
    $settingsStmt = $db->prepare("
        SELECT cash_in_hand 
        FROM site_settings 
        WHERE user_id = ?
        LIMIT 1
    ");
    $settingsStmt->execute([$user_id]);
    $settings = $settingsStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$settings || $settings['cash_in_hand'] != 1) {
        throw new Exception('Cash on Hand is not enabled for this seller');
    }
    
    // Get category details if category_id provided
    $service_ref_id = null;
    $service_ref_type = null;
    $service_name = null;
    
    if ($category_id) {
        $catStmt = $db->prepare("
            SELECT category_id, name, doctor_name 
            FROM categories 
            WHERE category_id = ? 
            AND user_id = ?
            LIMIT 1
        ");
        $catStmt->execute([$category_id, $user_id]);
        $category = $catStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($category) {
            $service_ref_id = $category['category_id']; // CAT_xxx
            $service_ref_type = 'category_id';
            $service_name = $category['doctor_name'] ?? $category['name'];
        }
    }
    
    // Generate receipt for COH
    $receipt = "COH_" . time() . "_" . rand(1000, 9999);
    
    // Insert COH order into database with status "waiting"
    $sql = "INSERT INTO customer_payment 
            (user_id, customer_id, appointment_id, receipt, amount, total_amount, currency, 
             status, payment_method, appointment_date, slot_from, slot_to, token_count,
             service_reference_id, service_reference_type, service_name,
             gst_type, gst_percent, gst_amount, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'INR', 'pending', 'coh', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $db->prepare($sql);
    
    $success = $stmt->execute([
        $user_id,
        $customer_id,
        $appointment_id,
        $receipt,
        $sub_total,
        $total_amount,
        $appointment_date,
        $slot_from,
        $slot_to,
        $token_count,
        $service_ref_id,
        $service_ref_type,
        $service_name,
        $gst_type,
        $gst_percent,
        $gst_amount
    ]);
    
    // Clear any output buffer
    ob_clean();
    
    if ($success) {
        $payment_id = $db->lastInsertId();
        
        echo json_encode([
            "success" => true,
            "message" => "Cash on Hand appointment booked successfully",
            "payment_id" => $payment_id,
            "appointment_id" => $appointment_id,
            "receipt" => $receipt,
            "status" => "pending",
            "payment_method" => "coh",
            "data" => [
                "customer_name" => $customer_name,
                "customer_phone" => $customer_phone,
                "total_amount" => $total_amount,
                "appointment_date" => $appointment_date,
                "slot_from" => $slot_from,
                "slot_to" => $slot_to,
                "token_count" => $token_count
            ]
        ], JSON_PRETTY_PRINT);
    } else {
        $errorInfo = $stmt->errorInfo();
        throw new Exception('Database error: ' . ($errorInfo[2] ?? 'Unknown error'));
    }
    
} catch (Exception $e) {
    // Clear output buffer
    ob_clean();
    
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage(),
        "error" => true,
        "timestamp" => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT);
}

// End output buffering
ob_end_flush();
?>