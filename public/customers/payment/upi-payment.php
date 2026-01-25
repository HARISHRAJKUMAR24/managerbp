<?php
// managerbp/public/customers/payment/upi-payment.php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            "success" => false,
            "message" => "Only POST requests are allowed"
        ]);
        exit;
    }

    $json = file_get_contents('php://input');
    
    if (empty($json)) {
        echo json_encode([
            "success" => false,
            "message" => "No data received"
        ]);
        exit;
    }

    $input = json_decode($json, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid JSON: " . json_last_error_msg()
        ]);
        exit;
    }

    // Required fields
    if (empty($input['user_id']) || empty($input['customer_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Missing required fields"
        ]);
        exit;
    }

    // Include required files
    $config_path = __DIR__ . '/../../../config/config.php';
    $database_path = __DIR__ . '/../../../src/database.php';
    $functions_path = __DIR__ . '/../../../src/functions.php';
    
    require_once $config_path;
    require_once $database_path;
    require_once $functions_path;

    $db = getDbConnection();
    
    // Extract data
    $user_id = (int) $input['user_id'];
    $customer_id = (int) $input['customer_id'];
    
    // Booking details
    $appointment_date = $input['appointment_date'] ?? '';
    $slot_from = $input['slot_from'] ?? '';
    $slot_to = $input['slot_to'] ?? '';
    $token_count = (int) ($input['token_count'] ?? 1);
    $category_id = $input['category_id'] ?? null;
    $batch_id = $input['batch_id'] ?? null;
    
    // Payment details
    $total_amount = (float) ($input['total_amount'] ?? 0);
    $sub_total = (float) ($input['sub_total'] ?? $total_amount);
    $gst_type = $input['gst_type'] ?? '';
    $gst_percent = (float) ($input['gst_percent'] ?? 0);
    $gst_amount = (float) ($input['gst_amount'] ?? 0);
    
    // Customer details
    $customer_name = $input['customer_name'] ?? '';
    $customer_email = $input['customer_email'] ?? '';
    $customer_phone = $input['customer_phone'] ?? '';
    
    // Generate appointment ID
    $appointment_id = generateAppointmentId($user_id, $db);
    
    // Generate receipt
    $receipt = "UPI_" . time() . "_" . rand(1000, 9999);
    
    // Get service name if category_id provided
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
            $service_ref_id = $category['category_id'];
            $service_ref_type = 'category_id';
            $service_name = $category['doctor_name'] ?? $category['name'];
        }
    }
    
    // CORRECTED SQL query with all required columns including payment_method as 'upi'
    $sql = "INSERT INTO customer_payment 
            (user_id, customer_id, appointment_id, receipt, amount, total_amount, currency,
             status, payment_method, appointment_date, slot_from, slot_to, token_count,
             service_reference_id, service_reference_type, service_name,
             gst_type, gst_percent, gst_amount, batch_id)
            VALUES (?, ?, ?, ?, ?, ?, 'INR', 'pending', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    
    // EXECUTE with 20 values for 20 placeholders
    $success = $stmt->execute([
        $user_id,                    // 1. user_id
        $customer_id,                // 2. customer_id
        $appointment_id,             // 3. appointment_id
        $receipt,                    // 4. receipt
        $sub_total,                  // 5. amount
        $total_amount,               // 6. total_amount
        // 'INR' is hardcoded in SQL - placeholder 7
        // 'pending' is hardcoded in SQL - placeholder 8
        'upi',                       // 9. payment_method (set as 'upi')
        $appointment_date,           // 10. appointment_date
        $slot_from,                  // 11. slot_from
        $slot_to,                    // 12. slot_to
        $token_count,                // 13. token_count
        $service_ref_id,             // 14. service_reference_id
        $service_ref_type,           // 15. service_reference_type
        $service_name,               // 16. service_name
        $gst_type,                   // 17. gst_type
        $gst_percent,                // 18. gst_percent
        $gst_amount,                 // 19. gst_amount
        $batch_id                    // 20. batch_id
    ]);
    
    if ($success) {
        $payment_id = $db->lastInsertId();
        
        // Update token availability if batch_id exists
        if ($batch_id && $appointment_date && $category_id) {
            try {
                $batchParts = explode(':', $batch_id);
                if (count($batchParts) === 2) {
                    $dayIndex = intval($batchParts[0]);
                    $slotIndex = intval($batchParts[1]);
                    
                    $dayName = date('D', strtotime($appointment_date));
                    
                    $stmtDoctor = $db->prepare("
                        SELECT weekly_schedule 
                        FROM doctor_schedule 
                        WHERE category_id = ? 
                        AND user_id = ?
                        LIMIT 1
                    ");
                    $stmtDoctor->execute([$category_id, $user_id]);
                    $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);
                    
                    if ($doctor && $doctor['weekly_schedule']) {
                        $weeklySchedule = json_decode($doctor['weekly_schedule'], true);
                        
                        if (isset($weeklySchedule[$dayName]['slots'][$slotIndex])) {
                            $currentTokens = intval($weeklySchedule[$dayName]['slots'][$slotIndex]['token'] ?? 0);
                            $newTokens = max(0, $currentTokens - $token_count);
                            $weeklySchedule[$dayName]['slots'][$slotIndex]['token'] = strval($newTokens);
                            
                            $updateSchedule = $db->prepare("
                                UPDATE doctor_schedule 
                                SET weekly_schedule = ? 
                                WHERE category_id = ? 
                                AND user_id = ?
                            ");
                            $updateSchedule->execute([
                                json_encode($weeklySchedule),
                                $category_id,
                                $user_id
                            ]);
                        }
                    }
                }
            } catch (Exception $e) {
                error_log("UPI Batch token update error: " . $e->getMessage());
            }
        }
        
        // Return success response - just like COH
        echo json_encode([
            "success" => true,
            "message" => "UPI payment order created successfully",
            "payment_id" => $payment_id,
            "appointment_id" => $appointment_id,
            "receipt" => $receipt,
            "status" => "pending",
            "payment_method" => "upi",
            "data" => [
                "customer_name" => $customer_name,
                "customer_email" => $customer_email,
                "customer_phone" => $customer_phone,
                "total_amount" => $total_amount,
                "appointment_date" => $appointment_date,
                "slot_time" => $slot_from . " to " . $slot_to
            ]
        ]);
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode([
            "success" => false,
            "message" => 'Database error: ' . ($errorInfo[2] ?? 'Unknown error')
        ]);
    }
    
} catch (Exception $e) {
    error_log("UPI Payment Error: " . $e->getMessage());
    
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage(),
        "error" => true,
        "timestamp" => date('Y-m-d H:i:s')
    ]);
}

exit;
?>