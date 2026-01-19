<?php
$allowed_origins = [
    "http://localhost:3000",
    "http://localhost:3001",
    "http://127.0.0.1:3000",
    "http://127.0.0.1:3001"
];

$origin = $_SERVER["HTTP_ORIGIN"] ?? "";

if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: http://localhost:3001");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$user_id = $_GET["user_id"] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User ID is required"
    ]);
    exit();
}

try {
    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        "SELECT id, name, icon, instructions, image 
         FROM manual_payment_methods 
         WHERE user_id = ?
         ORDER BY id DESC"
    );

    $stmt->execute([$user_id]);
    $methods = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($methods as &$m) {
        foreach ($m as $k => $v) {
            if ($v === null) $m[$k] = "";
        }
    }

    echo json_encode([
        "success" => true,
        "data" => $methods
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
}
