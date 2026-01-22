<?php
// test-payu-hash.php - Test hash calculation

$key = "gtKFFx";
$salt = "4R38IvwiV57FwVpsgOvTXBdLE4tHUXFW";
$txnid = "test123456789";
$amount = "57.00";
$productinfo = "Booking Payment - APT-123";
$firstname = "Deepak";
$email = "deepakchitravel@gmail.com";
$udf1 = "APT-123";
$udf2 = "695539";
$udf3 = "85960";
$udf4 = "0";
$udf5 = "inclusive";

// PayU hash format
$hashString = $key . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . 
              $firstname . '|' . $email . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . 
              $udf4 . '|' . $udf5 . '||||||' . $salt;

$hash = hash('sha512', $hashString);

echo "<h2>PayU Hash Test</h2>";
echo "<pre>";
echo "Key: " . $key . "\n";
echo "Salt: " . $salt . "\n";
echo "TXNID: " . $txnid . "\n";
echo "Amount: " . $amount . "\n";
echo "Product Info: " . $productinfo . "\n";
echo "First Name: " . $firstname . "\n";
echo "Email: " . $email . "\n";
echo "UDF1: " . $udf1 . "\n";
echo "UDF2: " . $udf2 . "\n";
echo "UDF3: " . $udf3 . "\n";
echo "UDF4: " . $udf4 . "\n";
echo "UDF5: " . $udf5 . "\n";
echo "\nHash String:\n" . $hashString . "\n";
echo "\nGenerated Hash (" . strlen($hash) . " chars):\n" . $hash . "\n";
echo "</pre>";

// Create test form
?>
<form method="POST" action="https://test.payu.in/_payment">
    <input type="hidden" name="key" value="<?php echo $key; ?>" />
    <input type="hidden" name="txnid" value="<?php echo $txnid; ?>" />
    <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>" />
    <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
    <input type="hidden" name="email" value="<?php echo $email; ?>" />
    <input type="hidden" name="phone" value="9345604653" />
    <input type="hidden" name="surl" value="http://localhost/payment-success" />
    <input type="hidden" name="furl" value="http://localhost/payment-failed" />
    <input type="hidden" name="hash" value="<?php echo $hash; ?>" />
    <input type="hidden" name="service_provider" value="payu_paisa" />
    <input type="hidden" name="udf1" value="<?php echo $udf1; ?>" />
    <input type="hidden" name="udf2" value="<?php echo $udf2; ?>" />
    <input type="hidden" name="udf3" value="<?php echo $udf3; ?>" />
    <input type="hidden" name="udf4" value="<?php echo $udf4; ?>" />
    <input type="hidden" name="udf5" value="<?php echo $udf5; ?>" />
    
    <button type="submit">Test PayU Payment</button>
</form>