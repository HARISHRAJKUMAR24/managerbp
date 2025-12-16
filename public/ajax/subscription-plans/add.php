<?php
require_once '../../../src/database.php';
require_once '../../../src/functions.php';

$name = $_POST['name'] ?? '';
$amount = $_POST['amount'] ?? '';
$previous_amount = $_POST['previous_amount'] ?? '';
$duration_value = $_POST['duration_value'] ?? '';
$duration_type = $_POST['duration_type'] ?? '';
$description = $_POST['description'] ?? '';
$appointments_limit = $_POST['appointments_limit'] ?? '';
$events_limit = $_POST['events_limit'] ?? ''; // New field
$customers_limit = $_POST['customers_limit'] ?? '';
$categories_limit = $_POST['categories_limit'] ?? '';
$services_limit = $_POST['services_limit'] ?? '';
$coupons_limit = $_POST['coupons_limit'] ?? '';
$manual_payment_methods_limit = $_POST['manual_payment_methods_limit'] ?? '';
$gst_type = $_POST['gst_type'] ?? '';
$feature_lists = $_POST['feature_lists'] ?? '';

$razorpay = isset($_POST['razorpay']) ? 1 : 0;
$phonepe = isset($_POST['phonepe']) ? 1 : 0;
$payu = isset($_POST['payu']) ? 1 : 0;

// Convert duration to days for database
$duration = convertToDays($duration_value, $duration_type);

// Validation
if (empty($name)) exit(json_encode(["type" => "error", "msg" => "Name is required"]));
if (empty($amount)) exit(json_encode(["type" => "error", "msg" => "Amount is required"]));
if (empty($duration_value)) exit(json_encode(["type" => "error", "msg" => "Duration is required"]));
if (empty($duration_type)) exit(json_encode(["type" => "error", "msg" => "Duration type is required"]));
if (empty($description)) exit(json_encode(["type" => "error", "msg" => "Description is required"]));
if (empty($appointments_limit)) exit(json_encode(["type" => "error", "msg" => "Appointments Limit is required"]));
if (empty($events_limit)) exit(json_encode(["type" => "error", "msg" => "Events Limit is required"]));
if (empty($customers_limit)) exit(json_encode(["type" => "error", "msg" => "Customers Limit is required"]));
if (empty($categories_limit)) exit(json_encode(["type" => "error", "msg" => "Categories Limit is required"]));
if (empty($services_limit)) exit(json_encode(["type" => "error", "msg" => "Services Limit is required"]));
if (empty($coupons_limit)) exit(json_encode(["type" => "error", "msg" => "Coupons Limit is required"]));
if (empty($manual_payment_methods_limit)) exit(json_encode(["type" => "error", "msg" => "Manual Payment Method Limit is required"]));
if (empty($gst_type)) exit(json_encode(["type" => "error", "msg" => "GST Type is required"]));
if (empty($feature_lists)) exit(json_encode(["type" => "error", "msg" => "Feature Lists is required"]));

try {
    addPlan(
        $name,
        $amount,
        $previous_amount,
        $duration,
        $description,
        $feature_lists,
        $appointments_limit,
        $events_limit,
        $customers_limit,
        $categories_limit,
        $services_limit,
        $coupons_limit,
        $manual_payment_methods_limit,
        $razorpay,
        $phonepe,
        $payu,
        $gst_type
    );

    exit(json_encode(["type" => "success", "msg" => "Plan added successfully!"]));
} catch (Exception $e) {
    exit(json_encode(["type" => "error", "msg" => "Error adding plan: " . $e->getMessage()]));
}
