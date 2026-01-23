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
    
    // ⭐ GET GST DETAILS FROM JSON
    $gst_type = $details['gst_type'] ?? '';
    $gst_percent = $details['gst_percent'] ?? 0;
    $gst_amount = $details['gst_amount'] ?? 0;
    $sub_total = $details['sub_total'] ?? $amount;

    // Update payment with success status and signature if available
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
            amount = ?  -- Update with subtotal
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

    echo "<script>
        alert('Payment Successful!');
        window.location.href='http://localhost:3001/payment-success?appointment_id={$udf1}';
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
        window.location.href='http://localhost:3000/payment-failed';
    </script>";
}
?>