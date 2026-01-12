<?php

require_once '../../../src/database.php';
require_once '../../../src/functions.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'data' => [],
    'error' => '',
    'debug' => []
];

try {
    $pdo = getDbConnection();
    $response['debug'][] = 'DB connected';

    /* ==========================
       SETTINGS (Currency)
    ========================== */
    $defaultCurrency = 'INR';

    $stmt = $pdo->prepare("SELECT currency FROM settings LIMIT 1");
    if ($stmt->execute()) {
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($settings['currency'])) {
            $defaultCurrency = $settings['currency'];
        }
    }

    /* ==========================
       SUBSCRIPTION PLANS
    ========================== */
    $stmt = $pdo->prepare("
        SELECT id, name, amount, duration
        FROM subscription_plans
        WHERE is_disabled = 1
        ORDER BY amount ASC
    ");
    $stmt->execute();
    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* ==========================
       SELLERS (USERS)
       user_id is the business ID
    ========================== */
    $stmt = $pdo->prepare("
        SELECT 
            user_id AS id,
            name,
            email,
            phone AS mobile,
            site_name,
            country
        FROM users
        WHERE is_suspended = 0
        ORDER BY name ASC
    ");
    $stmt->execute();
    $sellers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* ==========================
       PAYMENT METHODS (STATIC)
       FIXED: Removed extra nested array
    ========================== */
    $paymentMethods = [
        ['value' => 'razorpay', 'label' => 'Razorpay'],
        ['value' => 'phonepe', 'label' => 'PhonePe'],
        ['value' => 'PayU', 'label' => 'PayU'],
        ['value' => 'upi', 'label' => 'UPI'],
        ['value' => 'cash_on_hand', 'label' => 'Cash on Hand'],
        ['value' => 'bank_transfer', 'label' => 'Bank Transfer']
    ];

    /* ==========================
       CURRENCIES (STATIC)
       FIXED: Added name field
    ========================== */
    $currencies = [
        ['code' => 'INR', 'symbol' => '₹', 'name' => 'Indian Rupee'],
        ['code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar'],
        ['code' => 'EUR', 'symbol' => '€', 'name' => 'Euro'],
        ['code' => 'GBP', 'symbol' => '£', 'name' => 'British Pound']
    ];

    /* ==========================
       FINAL RESPONSE
    ========================== */
    $response['success'] = true;
    $response['data'] = [
        'plans' => $plans,
        'sellers' => $sellers,
        'payment_methods' => $paymentMethods,
        'currencies' => $currencies,
        'default_currency' => $defaultCurrency
    ];

    // Remove debug unless explicitly asked
    if (!isset($_GET['debug']) || $_GET['debug'] != 1) {
        unset($response['debug']);
    }
} catch (Throwable $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
