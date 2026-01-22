<?php
require_once "../../../src/functions.php";

// managerbp/public/customers/payment/create-payu-order.php
// ✔ Option-A Browser Redirect Flow
// ✔ Correct PayU Hash Format
// ✔ Works on localhost (no ngrok needed)

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

try {
    $user_id       = intval($data['user_id']);
    $customer_id   = intval($data['customer_id']);
    $amount        = floatval($data['total_amount']);
    $name          = trim($data['customer_name'] ?? "Customer");
    $email         = trim($data['customer_email'] ?? "");
    $phone         = trim($data['customer_phone'] ?? "");

$appointment_id = generateAppointmentId($user_id, $pdo);
    // Fetch PayU credentials
    $stmt = $pdo->prepare("
        SELECT payu_api_key, payu_salt 
        FROM site_settings 
        WHERE user_id = ? LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $cred = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cred || empty($cred['payu_api_key']) || empty($cred['payu_salt'])) {
        throw new Exception("PayU is not configured for this seller");
    }

    $merchantKey = trim($cred['payu_api_key']);
    $salt        = trim($cred['payu_salt']);

    // Generate transaction ID
    $txnid = "TXN" . time() . rand(1000, 9999);

    // Amount must be formatted
    $amountFormatted = number_format($amount, 2, '.', '');

    // Product info
    $productinfo = "Booking Payment";

    // UDF fields (PayU requires udf1-udf5 in hash)
    $udf1 = $appointment_id;
    $udf2 = $customer_id;
    $udf3 = $user_id;
    $udf4 = "";
    $udf5 = "";

    // ✔ Correct PayU Hash Format
    $hashString =
        $merchantKey . "|" .
        $txnid . "|" .
        $amountFormatted . "|" .
        $productinfo . "|" .
        $name . "|" .
        $email . "|" .
        $udf1 . "|" .
        $udf2 . "|" .
        $udf3 . "|" .
        $udf4 . "|" .
        $udf5 . "|" .
        "" . "|" . "" . "|" . "" . "|" . "" . "|" . "" . "|" .
        $salt;

    $hash = strtolower(hash("sha512", $hashString));

    // Browser-based redirect (works on localhost)
    $surl = "http://localhost/managerbp/public/customers/payment/payu-success.php";
    $furl = "http://localhost/managerbp/public/customers/payment/payu-failure.php";

    echo json_encode([
        "success"       => true,
        "endpoint"      => "https://test.payu.in/_payment",
        "key"           => $merchantKey,
        "txnid"         => $txnid,
        "amount"        => $amountFormatted,
        "productinfo"   => $productinfo,
        "firstname"     => $name,
        "email"         => $email,
        "phone"         => $phone,
        "surl"          => $surl,
        "furl"          => $furl,
        "hash"          => $hash,
        "service_provider" => "payu_paisa",

        // Important UDFs passed back to success page
        "udf1" => $udf1,
        "udf2" => $udf2,
        "udf3" => $udf3,
        "udf4" => $udf4,
        "udf5" => $udf5
    ]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
