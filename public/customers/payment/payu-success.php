<?php
// managerbp/public/customers/payment/payu-success.php

// Log everything for debugging
file_put_contents(__DIR__."/payu_success.log", print_r($_POST, true) . "\n", FILE_APPEND);

$status = $_POST['status'] ?? '';
$txnid = $_POST['txnid'] ?? '';
$amount = $_POST['amount'] ?? '';
$udf1 = $_POST['udf1'] ?? ''; // appointment_id
$udf2 = $_POST['udf2'] ?? ''; // customer_id
$udf3 = $_POST['udf3'] ?? ''; // user_id
$udf4 = $_POST['udf4'] ?? ''; // appointment_date
$udf5 = $_POST['udf5'] ?? ''; // all details JSON

require_once "../../../src/database.php";
require_once "../../../src/functions.php"; // Include function file

$db = getDbConnection();

if ($status == "success") {
    
    // Decode all details from UDF5
    $details = [];
    if (!empty($udf5)) {
        $details = json_decode($udf5, true);
    }
    
    $slot_from = $details['slot_from'] ?? null;
    $slot_to = $details['slot_to'] ?? null;
    $token_count = $details['token_count'] ?? 1;
    
    // ⭐ GET CATEGORY ID FROM JSON
    $category_id = $details['category_id'] ?? null;
    
    // ⭐ NEW: GET BATCH ID FROM JSON
    $batch_id = $details['batch_id'] ?? null;
    
    // ⭐ GET RECEIPT FROM JSON
    $receipt = $details['receipt'] ?? null;
    
    // ⭐ GET GST DETAILS FROM JSON
    $gst_type = $details['gst_type'] ?? '';
    $gst_percent = $details['gst_percent'] ?? 0;
    $gst_amount = $details['gst_amount'] ?? 0;
    $sub_total = $details['sub_total'] ?? $amount;

    // ⭐ UPDATE: Include batch_id and receipt in the update
    $updateStmt = $db->prepare("
        UPDATE customer_payment 
        SET status = 'paid',
            signature = ?,
            slot_from = ?,
            slot_to = ?,
            token_count = ?,
            gst_type = ?,
            gst_percent = ?,
            gst_amount = ?,
            amount = ?,      -- Update with subtotal
            batch_id = ?,    -- ⭐ Store batch_id
            receipt = ?      -- ⭐ Store receipt (if not already set)
        WHERE payment_id = ? AND user_id = ?
    ");

    $signature = $_POST['hash'] ?? '';
    
    $updateStmt->execute([
        $signature,
        $slot_from,
        $slot_to,
        $token_count,
        $gst_type,
        $gst_percent,
        $gst_amount,
        $sub_total,
        $batch_id,          // ⭐ Add batch_id
        $receipt,           // ⭐ Add receipt
        $txnid,
        $udf3
    ]);
    
    // ⭐ UPDATE SERVICE REFERENCE ID IF CATEGORY PROVIDED
    if ($category_id) {
        updatePaymentWithCategoryReference(
            $udf3,  // user_id
            $udf2,  // customer_id  
            $txnid, // payment_id
            $category_id  // CAT_xxx
        );
    } else {
        // Fallback to first category
        updatePaymentWithCategoryReference(
            $udf3,  // user_id
            $udf2,  // customer_id  
            $txnid  // payment_id
        );
    }
    
    // ⭐ UPDATE TOKEN AVAILABILITY FOR THIS BATCH
    if ($batch_id && $udf4) {
        try {
            // Extract day index and slot index from batch_id (format: "dayIndex:slotIndex")
            $batchParts = explode(':', $batch_id);
            if (count($batchParts) === 2) {
                $dayIndex = intval($batchParts[0]); // 0=Sun, 1=Mon, etc.
                $slotIndex = intval($batchParts[1]); // Slot index within that day
                
                // Convert appointment date to day name
                $dayName = date('D', strtotime($udf4));
                
                // Get doctor schedule for this category
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
                    
                    // Reduce token availability for this specific batch
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
                        
                        // Log the update for debugging
                        file_put_contents(__DIR__."/payu_token_update.log", 
                            "Batch ID: $batch_id\n" .
                            "Day: $dayName\n" .
                            "Slot Index: $slotIndex\n" .
                            "Old Tokens: $currentTokens\n" .
                            "Tokens Booked: $token_count\n" .
                            "New Tokens: $newTokens\n" .
                            "Date: " . date('Y-m-d H:i:s') . "\n\n", 
                            FILE_APPEND
                        );
                    }
                }
            }
        } catch (Exception $e) {
            // Log error but don't fail the payment
            error_log("PayU Batch token update error: " . $e->getMessage());
            file_put_contents(__DIR__."/payu_error.log", 
                "Error: " . $e->getMessage() . "\n" .
                "Batch ID: $batch_id\n" .
                "Date: $udf4\n" .
                "Time: " . date('Y-m-d H:i:s') . "\n\n", 
                FILE_APPEND
            );
        }
    }

    // Redirect to success page with appointment details
    echo "<script>
        alert('Payment Successful!');
        window.location.href='http://localhost:3001/payment-success?" . 
        "appointment_id={$udf1}&" .
        "receipt={$receipt}&" .
        "payment_id={$txnid}&" .
        "status=paid&" .
        "method=payu';
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
        "appointment_id={$udf1}&" .
        "payment_id={$txnid}&" .
        "status=failed';
    </script>";
}
?>