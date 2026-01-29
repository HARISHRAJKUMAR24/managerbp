<?php
// managerbp/public/customers/payment/payu-success.php

// Start session to get the data that was stored before redirect
// session_start();

// Log everything for debugging
$logData = [
    'timestamp' => date('Y-m-d H:i:s'),
    'POST_data' => $_POST,
    'GET_data' => $_GET,
    'SESSION_data' => isset($_SESSION['payu_pending_data']) ? 'Exists' : 'Not exists'
];

file_put_contents(__DIR__."/payu_success.log", print_r($logData, true) . "\n", FILE_APPEND);

$status = $_POST['status'] ?? '';
$txnid = $_POST['txnid'] ?? '';
$amount = $_POST['amount'] ?? '';
$udf1 = $_POST['udf1'] ?? ''; // appointment_id
$udf2 = $_POST['udf2'] ?? ''; // customer_id
$udf3 = $_POST['udf3'] ?? ''; // user_id
$udf4 = $_POST['udf4'] ?? ''; // appointment_date
$udf5 = $_POST['udf5'] ?? ''; // all details JSON

require_once "../../../src/database.php";
require_once "../../../src/functions.php";

$db = getDbConnection();

if ($status == "success") {
    
    // ⭐ FIX: FIRST GET THE ORIGINAL PENDING RECORD
    // Find the pending payment record first
    $stmt = $db->prepare("
        SELECT * FROM customer_payment 
        WHERE payment_id = ? 
        AND user_id = ? 
        AND status = 'pending'
        LIMIT 1
    ");
    $stmt->execute([$txnid, $udf3]);
    $pendingRecord = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$pendingRecord) {
        // Try alternative search
        $stmt = $db->prepare("
            SELECT * FROM customer_payment 
            WHERE receipt LIKE ? 
            AND user_id = ? 
            AND status = 'pending'
            LIMIT 1
        ");
        $stmt->execute(["%" . $txnid . "%", $udf3]);
        $pendingRecord = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if (!$pendingRecord) {
        // Last try: check by appointment_id
        $stmt = $db->prepare("
            SELECT * FROM customer_payment 
            WHERE appointment_id = ? 
            AND user_id = ? 
            AND status = 'pending'
            LIMIT 1
        ");
        $stmt->execute([$udf1, $udf3]);
        $pendingRecord = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if (!$pendingRecord) {
        error_log("PayU Success: No pending record found for txnid: $txnid, user_id: $udf3");
        echo "<script>
            alert('Payment record not found! Please contact support.');
            window.location.href='http://localhost:3000/payment-failed?error=record_not_found';
        </script>";
        exit;
    }
    
    // ⭐ USE VALUES FROM PENDING RECORD INSTEAD OF POST DATA
    // These are the values that were stored when the order was created
    $slot_from = $pendingRecord['slot_from'] ?? null;
    $slot_to = $pendingRecord['slot_to'] ?? null;
    $token_count = $pendingRecord['token_count'] ?? 1;
    $batch_id = $pendingRecord['batch_id'] ?? null;
    $category_id = $pendingRecord['service_reference_id'] ?? null;
    $receipt = $pendingRecord['receipt'] ?? null;
    $gst_type = $pendingRecord['gst_type'] ?? '';
    $gst_percent = $pendingRecord['gst_percent'] ?? 0;
    $gst_amount = $pendingRecord['gst_amount'] ?? 0;
    $sub_total = $pendingRecord['amount'] ?? $amount;
    
    // Get existing service name from pending record
    $existing_service_name = $pendingRecord['service_name'] ?? null;
    
    // Log what we found
    error_log("PayU Success - Found pending record: slot_from=$slot_from, slot_to=$slot_to, batch_id=$batch_id, category_id=$category_id");
    
    // Decode UDF5 only if available and needed
    $details = [];
    if (!empty($udf5)) {
        $details = json_decode($udf5, true);
        // If UDF5 has data, use it as fallback
        if (!empty($details['slot_from'])) $slot_from = $details['slot_from'];
        if (!empty($details['slot_to'])) $slot_to = $details['slot_to'];
        if (!empty($details['batch_id'])) $batch_id = $details['batch_id'];
        if (!empty($details['category_id'])) $category_id = $details['category_id'];
        if (!empty($details['token_count'])) $token_count = $details['token_count'];
        if (!empty($details['receipt'])) $receipt = $details['receipt'];
    }
    
    $signature = $_POST['hash'] ?? '';
    
    // ⭐ FIXED UPDATE: ONLY UPDATE STATUS AND SIGNATURE, DON'T OVERWRITE OTHER FIELDS
    // We already have all the appointment details from the pending record
    $updateStmt = $db->prepare("
        UPDATE customer_payment 
        SET status = 'paid',
            signature = ?
        WHERE payment_id = ? AND user_id = ? AND status = 'pending'
    ");
    
    $updateResult = $updateStmt->execute([$signature, $txnid, $udf3]);
    
    if (!$updateResult) {
        $errorInfo = $updateStmt->errorInfo();
        error_log("PayU Update Error: " . json_encode($errorInfo));
    }
    
    $rowsUpdated = $updateStmt->rowCount();
    error_log("PayU Updated rows: $rowsUpdated");
    
    // If no rows updated, check if already paid
    if ($rowsUpdated === 0) {
        $checkStmt = $db->prepare("SELECT status FROM customer_payment WHERE payment_id = ? AND user_id = ?");
        $checkStmt->execute([$txnid, $udf3]);
        $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($checkResult && $checkResult['status'] === 'paid') {
            error_log("PayU: Payment already marked as paid");
        } else {
            error_log("PayU: No rows updated, but status is not 'paid'");
        }
    }
    
    // ⭐ UPDATE TOKEN AVAILABILITY FOR THIS BATCH
    $tokenUpdateMessage = null;
    if ($batch_id && $udf4 && $category_id) {
        try {
            // Extract day index and slot index from batch_id
            $batchParts = explode(':', $batch_id);
            if (count($batchParts) === 2) {
                $dayIndex = intval($batchParts[0]);
                $slotIndex = intval($batchParts[1]);
                
                // Convert appointment date to day name
                $dayName = date('D', strtotime($udf4));
                
                // Get doctor schedule
                $stmtDoctor = $db->prepare("
                    SELECT weekly_schedule 
                    FROM doctor_schedule 
                    WHERE category_id = ? 
                    AND user_id = ?
                    LIMIT 1
                ");
                $stmtDoctor->execute([$category_id, $udf3]);
                $doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);
                
                if ($doctor && $doctor['weekly_schedule']) {
                    $weeklySchedule = json_decode($doctor['weekly_schedule'], true);
                    
                    // Reduce token availability
                    if (isset($weeklySchedule[$dayName]['slots'][$slotIndex])) {
                        $currentTokens = intval($weeklySchedule[$dayName]['slots'][$slotIndex]['token'] ?? 0);
                        $newTokens = max(0, $currentTokens - $token_count);
                        $weeklySchedule[$dayName]['slots'][$slotIndex]['token'] = strval($newTokens);
                        
                        // Update the schedule
                        $updateSchedule = $db->prepare("
                            UPDATE doctor_schedule 
                            SET weekly_schedule = ? 
                            WHERE category_id = ? 
                            AND user_id = ?
                        ");
                        $updateSchedule->execute([
                            json_encode($weeklySchedule),
                            $category_id,
                            $udf3
                        ]);
                        
                        $tokenUpdateMessage = "Token availability updated for batch $batch_id: $currentTokens -> $newTokens";
                        error_log("PayU Token Update: $tokenUpdateMessage");
                    }
                }
            }
        } catch (Exception $e) {
            error_log("PayU Batch token update error: " . $e->getMessage());
        }
    }

    // Get service name for display
    $serviceDisplay = "Service";
    
    // First try to get from pending record
    if ($existing_service_name) {
        try {
            $serviceData = json_decode($existing_service_name, true);
            if (isset($serviceData['doctor_name'])) {
                $serviceDisplay = $serviceData['doctor_name'];
                if (!empty($serviceData['specialization'])) {
                    $serviceDisplay .= " - " . $serviceData['specialization'];
                }
            } elseif (isset($serviceData['department_name'])) {
                $serviceDisplay = $serviceData['department_name'];
            } elseif (isset($serviceData['service_name'])) {
                $serviceDisplay = $serviceData['service_name'];
            }
        } catch (Exception $e) {
            error_log("Error parsing service JSON: " . $e->getMessage());
        }
    }
    
    // If still not found, try from database
    if ($serviceDisplay === "Service") {
        $stmt = $db->prepare("SELECT service_name FROM customer_payment WHERE payment_id = ? AND user_id = ? LIMIT 1");
        $stmt->execute([$txnid, $udf3]);
        $paymentRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($paymentRecord && $paymentRecord['service_name']) {
            try {
                $serviceData = json_decode($paymentRecord['service_name'], true);
                if (isset($serviceData['doctor_name'])) {
                    $serviceDisplay = $serviceData['doctor_name'];
                    if (!empty($serviceData['specialization'])) {
                        $serviceDisplay .= " - " . $serviceData['specialization'];
                    }
                } elseif (isset($serviceData['department_name'])) {
                    $serviceDisplay = $serviceData['department_name'];
                } elseif (isset($serviceData['service_name'])) {
                    $serviceDisplay = $serviceData['service_name'];
                }
            } catch (Exception $e) {
                error_log("Error parsing service JSON from DB: " . $e->getMessage());
            }
        }
    }

    // Debug log
    error_log("PayU Success Redirect - appointment_id: $udf1, receipt: $receipt, txnid: $txnid");
    
    // Redirect to success page
    echo "<script>
        alert('Payment Successful!\\\\nService: " . addslashes($serviceDisplay) . "');
        window.location.href='http://localhost:3001/payment-success?" . 
        "appointment_id=" . urlencode($udf1) . "&" .
        "receipt=" . urlencode($receipt) . "&" .
        "payment_id=" . urlencode($txnid) . "&" .
        "status=paid&" .
        "method=payu&" .
        "service_name=" . urlencode($serviceDisplay) . "';
    </script>";
    
} else {
    // Update as failed
    $stmt = $db->prepare("
        UPDATE customer_payment 
        SET status = 'failed'
        WHERE payment_id = ? AND user_id = ?
    ");
    
    $stmt->execute([$txnid, $udf3]);

    echo "<script>
        alert('Payment Failed!');
        window.location.href='http://localhost:3000/payment-failed?" .
        "appointment_id=" . urlencode($udf1) . "&" .
        "payment_id=" . urlencode($txnid) . "&" .
        "status=failed';
    </script>";
}
?>