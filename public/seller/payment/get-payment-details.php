<?php
// managerbp/public/seller/payment/get-payment-details.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";
require_once "../../../src/functions.php"; // Include functions.php

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

// Check if subscription_histories table exists
$tableCheck = $pdo->query("SHOW TABLES LIKE 'subscription_histories'");
$tableExists = $tableCheck->rowCount() > 0;

$paymentDetails = null;

if ($tableExists) {
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
}

// If no record found, create a mock response
if (!$paymentDetails) {
    // Get company info from settings
    $settingsSql = "SELECT 
                        app_name, 
                        address, 
                        logo, 
                        gst_number as company_gst_number,
                        currency
                    FROM settings 
                    LIMIT 1";
    $settingsStmt = $pdo->prepare($settingsSql);
    $settingsStmt->execute();
    $companyInfo = $settingsStmt->fetch(PDO::FETCH_ASSOC);
    
    $currency = $companyInfo['currency'] ?? 'INR';
    $currency_symbol = getCurrencySymbol($currency);
    
    // Create mock payment details
    $currentTime = date('Y-m-d H:i:s');
    $dueDate = date('Y-m-d H:i:s', strtotime('+30 days'));
    
    // Get plan info if available from GET parameters
    $planId = isset($_GET['plan_id']) ? intval($_GET['plan_id']) : 0;
    $planName = "Unknown Plan";
    
    if ($planId > 0) {
        $planSql = "SELECT name FROM subscription_plans WHERE id = ?";
        $planStmt = $pdo->prepare($planSql);
        $planStmt->execute([$planId]);
        $plan = $planStmt->fetch(PDO::FETCH_ASSOC);
        if ($plan) {
            $planName = $plan['name'];
        }
    }
    
    echo json_encode([
        "success" => true,
        "data" => [
            "invoice" => [
                "invoice_number" => $invoiceNumber,
                "date" => $currentTime,
                "due_date" => $dueDate,
                "status" => "Paid"
            ],
            "company" => [
                "name" => $companyInfo['app_name'] ?? "Book Pannu",
                "address" => $companyInfo['address'] ?? "",
                "gst_number" => $companyInfo['company_gst_number'] ?? "",
                "logo" => $companyInfo['logo'] ?? ""
            ],
            "customer" => [
                "name" => "Customer",
                "email" => "customer@example.com",
                "phone" => "9876543210",
                "address_1" => "Address line 1",
                "address_2" => "",
                "city" => "City",
                "state" => "State",
                "pin_code" => "123456",
                "country" => "India",
                "gst_number" => ""
            ],
            "plan" => [
                "name" => $planName,
                "duration" => 30,
                "plan_id" => $planId
            ],
            "payment" => [
                "method" => "razorpay",
                "payment_id" => "pay_" . $invoiceNumber,
                "currency" => $currency,
                "currency_symbol" => $currency_symbol,
                "amount" => 0,
                "gst_amount" => 0,
                "gst_type" => "exclusive",
                "gst_percentage" => 18,
                "discount" => 0,
                "total" => 0
            ],
            "items" => [
                [
                    "description" => $planName . " Subscription",
                    "quantity" => 1,
                    "unit_price" => 0,
                    "total" => 0
                ]
            ]
        ]
    ]);
    exit;
}

// Get company info from settings
$settingsSql = "SELECT 
                    app_name, 
                    address, 
                    logo, 
                    gst_number as company_gst_number,
                    currency
                FROM settings 
                LIMIT 1";
$settingsStmt = $pdo->prepare($settingsSql);
$settingsStmt->execute();
$companyInfo = $settingsStmt->fetch(PDO::FETCH_ASSOC);

// Get currency symbol
$currency = $companyInfo['currency'] ?? 'INR';
$currency_symbol = getCurrencySymbol($currency);

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
            "currency" => $paymentDetails['currency'] ?? $currency,
            "currency_symbol" => $paymentDetails['currency_symbol'] ?? $currency_symbol,
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