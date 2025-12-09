<?php
// managerbp/public/seller/payment/get-payment-details.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// Get invoice number from query parameter
$invoiceNumber = isset($_GET['invoice']) ? intval($_GET['invoice']) : 0;

if (!$invoiceNumber) {
    echo json_encode([
        "success" => false,
        "message" => "Invoice number is required"
    ]);
    exit;
}

// Get payment details from subscription_histories
$sql = "SELECT 
            sh.*,
            sp.name as plan_name,
            sp.duration as plan_duration,
            u.email as user_email,
            u.name as user_name
        FROM subscription_histories sh
        LEFT JOIN subscription_plans sp ON sh.plan_id = sp.id
        LEFT JOIN users u ON sh.user_id = u.id
        WHERE sh.invoice_number = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$invoiceNumber]);
$paymentDetails = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paymentDetails) {
    echo json_encode([
        "success" => false,
        "message" => "Payment details not found"
    ]);
    exit;
}

// Get company info from settings
$settingsSql = "SELECT 
                    app_name, 
                    address, 
                    logo, 
                    gst_number as company_gst_number,
                    razorpay_key_id
                FROM settings 
                LIMIT 1";
$settingsStmt = $pdo->prepare($settingsSql);
$settingsStmt->execute();
$companyInfo = $settingsStmt->fetch(PDO::FETCH_ASSOC);

// Format the response
$formattedResponse = [
    "success" => true,
    "data" => [
        "invoice" => [
            "invoice_number" => $paymentDetails['invoice_number'],
            "date" => $paymentDetails['created_at'],
            "due_date" => date('Y-m-d H:i:s', strtotime($paymentDetails['created_at'] . ' + 30 days')),
            "status" => "Paid"
        ],
        "company" => [
            "name" => $companyInfo['app_name'] ?? "Book Pannu",
            "address" => $companyInfo['address'] ?? "",
            "gst_number" => $companyInfo['company_gst_number'] ?? "",
            "logo" => $companyInfo['logo'] ?? ""
        ],
        "customer" => [
            "name" => $paymentDetails['name'],
            "email" => $paymentDetails['email'],
            "phone" => $paymentDetails['phone'],
            "address_1" => $paymentDetails['address_1'],
            "address_2" => $paymentDetails['address_2'],
            "city" => $paymentDetails['city'],
            "state" => $paymentDetails['state'],
            "pin_code" => $paymentDetails['pin_code'],
            "country" => $paymentDetails['country'],
            "gst_number" => $paymentDetails['gst_number'] ?? ""
        ],
        "plan" => [
            "name" => $paymentDetails['plan_name'],
            "duration" => $paymentDetails['plan_duration'],
            "plan_id" => $paymentDetails['plan_id']
        ],
        "payment" => [
            "method" => $paymentDetails['payment_method'],
            "payment_id" => $paymentDetails['payment_id'],
            "currency" => $paymentDetails['currency'],
            "amount" => intval($paymentDetails['amount']),
            "gst_amount" => intval($paymentDetails['gst_amount']),
            "gst_type" => $paymentDetails['gst_type'],
            "gst_percentage" => intval($paymentDetails['gst_percentage']),
            "discount" => intval($paymentDetails['discount']),
            "total" => intval($paymentDetails['amount']) + intval($paymentDetails['gst_amount']) - intval($paymentDetails['discount'])
        ],
        "items" => [
            [
                "description" => $paymentDetails['plan_name'] . " Subscription",
                "quantity" => 1,
                "unit_price" => intval($paymentDetails['amount']),
                "total" => intval($paymentDetails['amount'])
            ]
        ]
    ]
];

echo json_encode($formattedResponse);
exit;