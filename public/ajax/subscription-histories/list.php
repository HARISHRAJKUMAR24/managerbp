<?php
require_once '../../../src/database.php';
require_once '../../../src/functions.php';

$pdo = getDbConnection();

// Get filter parameters
$plan_filter = $_POST['plan_filter'] ?? 'all';
$gst_filter = $_POST['gst_filter'] ?? 'all';
$payment_method = $_POST['payment_method'] ?? 'all';
$date_from = $_POST['date_from'] ?? '';
$date_to = $_POST['date_to'] ?? '';

// Build query
$query = "SELECT 
            sh.id,
            sh.invoice_number,
            sh.plan_id,
            sp.name as plan_name,
            sh.name,
            sh.gst_number,
            sh.payment_method,
            sh.amount,
            sh.currency,
            sh.created_at
          FROM subscription_histories sh 
          LEFT JOIN subscription_plans sp ON sh.plan_id = sp.id 
          WHERE 1=1";

$params = [];

// Apply plan filter
if ($plan_filter !== 'all') {
    $query .= " AND sh.plan_id = :plan_id";
    $params[':plan_id'] = $plan_filter;
}

// Apply GST filter
if ($gst_filter === 'with_gst_number') {
    $query .= " AND sh.gst_number IS NOT NULL AND sh.gst_number != ''";
} elseif ($gst_filter === 'without_gst_number') {
    $query .= " AND (sh.gst_number IS NULL OR sh.gst_number = '')";
}

// Apply payment method filter
if ($payment_method !== 'all') {
    $query .= " AND sh.payment_method = :payment_method";
    $params[':payment_method'] = $payment_method;
}

// Apply date filter
if ($date_from) {
    $query .= " AND DATE(sh.created_at) >= :date_from";
    $params[':date_from'] = $date_from;
}

if ($date_to) {
    $query .= " AND DATE(sh.created_at) <= :date_to";
    $params[':date_to'] = $date_to;
}

// Order by date
$query .= " ORDER BY sh.created_at DESC";

// Prepare and execute query
$stmt = $pdo->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>