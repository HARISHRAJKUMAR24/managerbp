<?php
// managerbp/public/customers/payment/payu-success.php

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$db = getDbConnection();

// Log all POST data for debugging
file_put_contents(__DIR__ . '/payu_success.log', 
    "[" . date('Y-m-d H:i:s') . "] POST DATA:\n" . 
    print_r($_POST, true) . "\n\n", 
    FILE_APPEND
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Extract all POST parameters
    $status = $_POST['status'] ?? '';
    $txnid = $_POST['txnid'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $productinfo = $_POST['productinfo'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $email = $_POST['email'] ?? '';
    $postedHash = $_POST['hash'] ?? '';
    
    // UDF fields from request
    $udf1 = $_POST['udf1'] ?? '';  // appointment_id
    $udf2 = $_POST['udf2'] ?? '';  // customer_id
    $udf3 = $_POST['udf3'] ?? '';  // user_id
    $udf4 = $_POST['udf4'] ?? '';  // gst_amount
    $udf5 = $_POST['udf5'] ?? '';  // gst_type
    $udf6 = $_POST['udf6'] ?? '';  // additional data (JSON)
    
    $key = $_POST['key'] ?? '';
    $additionalCharges = $_POST['additionalCharges'] ?? '0.00';
    
    // If udf3 is empty, try to get from pending_payments
    if (empty($udf3)) {
        $stmt = $db->prepare("SELECT user_id FROM pending_payments WHERE txnid = ? LIMIT 1");
        $stmt->execute([$txnid]);
        $pending = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($pending) {
            $udf3 = $pending['user_id'];
        }
    }
    
    if (empty($udf3)) {
        die("Error: User ID not found in transaction data.");
    }
    
    // Get merchant keys
    $stmt = $db->prepare("
        SELECT payu_api_key, payu_salt 
        FROM site_settings 
        WHERE user_id = ? 
        LIMIT 1
    ");
    $stmt->execute([$udf3]);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$settings) {
        die("Merchant settings not found for user ID: " . $udf3);
    }
    
    $salt = trim($settings['payu_salt']);
    
    // VERIFICATION HASH CALCULATION
    $hashString = '';
    if (empty($additionalCharges) || $additionalCharges == '0.00') {
        // Without additional charges
        $hashString = $salt . '|' . $status . '|||||||||||' . 
                     $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '|' . $udf6 . '|' . 
                     $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
    } else {
        // With additional charges
        $hashString = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . 
                     $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '|' . $udf6 . '|' . 
                     $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
    }
    
    $calculatedHash = hash('sha512', $hashString);
    $calculatedHash = strtolower($calculatedHash);
    $postedHash = strtolower($postedHash);
    
    // Log hash verification
    file_put_contents(__DIR__ . '/payu_success.log', 
        "Hash String: $hashString\n" .
        "Calculated Hash: $calculatedHash\n" .
        "Posted Hash: $postedHash\n" .
        "Status: $status\n\n", 
        FILE_APPEND
    );
    
    if ($status == 'success' && $calculatedHash === $postedHash) {
        
        // Parse additional data from udf6
        $additionalData = json_decode($udf6, true) ?: [];
        
        // Create receipt
        $receipt = "RC" . $udf3 . time() . rand(100, 999);
        
        // Insert into customer_payment
        $ins = $db->prepare("
            INSERT INTO customer_payment 
            (user_id, customer_id, appointment_id, payment_id, receipt, amount, currency, 
             gst_type, gst_percent, gst_amount, total_amount, status, payment_method, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'paid', 'payu', NOW())
        ");
        
        $ins->execute([
            intval($udf3),                      // user_id
            intval($udf2),                      // customer_id
            $udf1,                              // appointment_id
            $txnid,                             // payment_id (txnid)
            $receipt,                           // receipt
            floatval($amount),                  // amount
            'INR',                              // currency
            $udf5,                              // gst_type
            $additionalData['gst_percent'] ?? 0, // gst_percent
            floatval($udf4),                    // gst_amount
            floatval($amount),                  // total_amount
        ]);
        
        // Update pending payment
        $update = $db->prepare("
            UPDATE pending_payments 
            SET status = 'completed' 
            WHERE txnid = ?
        ");
        $update->execute([$txnid]);
        
        // Redirect to success page
        $frontend_url = "http://localhost:3000"; // Your frontend URL
        $redirect_url = $frontend_url . "/payment-success?appointment_id=" . urlencode($udf1) . "&txnid=" . urlencode($txnid);
        
        echo "<script>
            alert('Payment Successful!');
            window.location.href = '$redirect_url';
        </script>";
        
    } else {
        // Payment failed
        $update = $db->prepare("
            UPDATE pending_payments 
            SET status = 'failed' 
            WHERE txnid = ?
        ");
        $update->execute([$txnid]);
        
        $frontend_url = "http://localhost:3000";
        $redirect_url = $frontend_url . "/payment-failed?error=hash_verification_failed";
        
        echo "<script>
            alert('Payment verification failed!');
            window.location.href = '$redirect_url';
        </script>";
    }
    
} else {
    echo "Invalid request method.";
}
?>