<?php

require_once '../../../src/database.php';

$name = $_POST['name'];
$amount = $_POST['amount'];
$previous_amount = $_POST['previous_amount'];
$duration = $_POST['duration'];
$description = $_POST['description'];
$appointments_limit = $_POST['appointments_limit'];
$customers_limit = $_POST['customers_limit'];
$categories_limit = $_POST['categories_limit'];
$services_limit = $_POST['services_limit'];
$coupons_limit = $_POST['coupons_limit'];
$manual_payment_methods_limit = $_POST['manual_payment_methods_limit'];
$gst_type = $_POST['gst_type'];
$feature_lists = $_POST['feature_lists'];

$razorpay = isset($_POST['razorpay']) ? 1 : 0;
$phonepe = isset($_POST['phonepe']) ? 1 : 0;
$payu = isset($_POST['payu']) ? 1 : 0;

if (!$name === "") exit(json_encode(["type" => "error", "msg" => "Name is required"]));
if (!$amount === "") exit(json_encode(["type" => "error", "msg" => "Amount is required"]));
if (!$duration === "") exit(json_encode(["type" => "error", "msg" => "Duration is required"]));
if (!$description === "") exit(json_encode(["type" => "error", "msg" => "Description is required"]));
if (!$appointments_limit === "") exit(json_encode(["type" => "error", "msg" => "Appointments Limit is required"]));
if (!$customers_limit === "") exit(json_encode(["type" => "error", "msg" => "Customers Limit is required"]));
if (!$categories_limit === "") exit(json_encode(["type" => "error", "msg" => "Categories Limit is required"]));
if (!$services_limit === "") exit(json_encode(["type" => "error", "msg" => "Services Limit is required"]));
if (!$coupons_limit === "") exit(json_encode(["type" => "error", "msg" => "Coupons Limit is required"]));
if (!$manual_payment_methods_limit === "") exit(json_encode(["type" => "error", "msg" => "Manual Payment Method Limit is required"]));
if (!$gst_type === "") exit(json_encode(["type" => "error", "msg" => "GST Type is required"]));
if (!$feature_lists === "") exit(json_encode(["type" => "error", "msg" => "Feature Lists is required"]));

addPlan(
    $name,
    $amount,
    $previous_amount,
    $duration,
    $description,
    $feature_lists,
    $appointments_limit,
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

exit(json_encode(["type" => "success", "msg" => "Action applied successfully!"]));
