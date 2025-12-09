<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$code = $data['code'] ?? '';
$planId = $data['planId'] ?? null;

if (empty($code)) {
    echo json_encode([
        "success" => false,
        "message" => "Discount code is required"
    ]);
    exit;
}

// Check if discount code exists
$sql = "SELECT * FROM discounts WHERE code = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$code]);
$discount = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$discount) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid discount code"
    ]);
    exit;
}

// Check if discount is for everyone or specific plan
if ($discount['eligibility'] !== null && $discount['eligibility'] != $planId) {
    echo json_encode([
        "success" => false,
        "message" => "This discount is not applicable for your selected plan"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "discount" => [
        "id" => $discount['id'],
        "code" => $discount['code'],
        "type" => $discount['type'],
        "amount" => $discount['discount'],
        "eligibility" => $discount['eligibility']
    ]
]);
exit;