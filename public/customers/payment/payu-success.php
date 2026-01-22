<?php
// BASIC REDIRECT SUCCESS HANDLER (NO SERVER VERIFICATION)

// Log everything
file_put_contents(__DIR__."/payu_success.log", print_r($_POST, true), FILE_APPEND);

$status = $_POST['status'] ?? '';
$txnid = $_POST['txnid'] ?? '';
$amount = $_POST['amount'] ?? '';
$udf1 = $_POST['udf1'] ?? ''; // appointment_id
$udf2 = $_POST['udf2'] ?? ''; // customer_id
$udf3 = $_POST['udf3'] ?? ''; // user_id

require_once "../../../src/database.php";
$db = getDbConnection();

if ($status == "success") {

    // Insert payment
    $stmt = $db->prepare("
        INSERT INTO customer_payment 
        (user_id, customer_id, appointment_id, payment_id, amount, total_amount, currency, status, payment_method, created_at)
        VALUES (?, ?, ?, ?, ?, ?, 'INR', 'paid', 'payu', NOW())
    ");

    $stmt->execute([
        $udf3, $udf2, $udf1,
        $txnid,
        $amount, $amount
    ]);

    echo "<script>
        alert('Payment Successful!');
        window.location.href='http://localhost:3001/payment-success?appointment_id={$udf1}';
    </script>";
} else {

    echo "<script>
        alert('Payment Failed!');
        window.location.href='http://localhost:3000/payment-failed';
    </script>";
}
?>
