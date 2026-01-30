<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

/* ===============================
   HEADERS / CORS
================================ */
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* ===============================
   READ INPUT
================================ */
$raw   = file_get_contents("php://input");
$input = json_decode($raw, true) ?? [];

/* ===============================
   AUTH
================================ */
$token =
    ($input["token"] ?? null)
    ?: ($_COOKIE["token"] ?? "");

if (!$token) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$stmt = $pdo->prepare(
    "SELECT user_id FROM users WHERE api_token = ? LIMIT 1"
);
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit;
}

$user_id = (int)$user->user_id;

/* ===============================
   VALIDATION
================================ */
if (empty($input['id'])) {
    echo json_encode(["success" => false, "message" => "Item ID missing"]);
    exit;
}

$itemId = (int)$input['id'];
unset($input['id']);

/* ===============================
   OWNERSHIP CHECK
================================ */
$check = $pdo->prepare(
    "SELECT id FROM menu_items WHERE id = ? AND user_id = ?"
);
$check->execute([$itemId, $user_id]);

if (!$check->fetch()) {
    echo json_encode(["success" => false, "message" => "Access denied"]);
    exit;
}

/* ===============================
   NORMALIZE VALUES
================================ */
if (isset($input['food_type'])) {
    $input['food_type'] = $input['food_type'] === 'non-veg'
        ? 'nonveg'
        : 'veg';
}

if (isset($input['stock_type']) && $input['stock_type'] === 'out_of_stock') {
    $input['stock_type'] = 'out';
}

// Handle prebooking values
if (isset($input['prebooking_enabled'])) {
    $input['prebooking_enabled'] = $input['prebooking_enabled'] ? 1 : 0;
}

/* ===============================
   UPDATE MENU ITEM
================================ */
$allowed = [
    'name',
    'description',
    'hsn_code',
    'menu_id',
    'category_id',
    'food_type',
    'stock_type',
    'halal',
    'stock_qty',
    'stock_unit',
    'customer_limit',
    'customer_limit_period',
    'prebooking_enabled',      // NEW
    'prebooking_min_amount',   // NEW
    'prebooking_max_amount',   // NEW
    'prebooking_advance_days', // NEW
    'image'
];

$fields = [];
$values = [];

foreach ($input as $key => $value) {
    if (!in_array($key, $allowed)) continue;

    if ($key === 'halal') {
        $fields[] = "halal = ?";
        $values[] = $value ? 1 : 0;
        continue;
    }

    $fields[] = "$key = ?";
    $values[] = $value;
}

$pdo->beginTransaction();

try {

    if ($fields) {
        $values[] = $itemId;
        $sql = "
            UPDATE menu_items
            SET " . implode(', ', $fields) . ", updated_at = NOW()
            WHERE id = ?
        ";
        $pdo->prepare($sql)->execute($values);
    }

    /* ===============================
       VARIATIONS
    ================================ */
    if (!empty($input['variations'])) {

        // delete only THIS user's variations (extra safe)
        $pdo->prepare(
            "DELETE FROM menu_item_variations WHERE item_id = ? AND user_id = ?"
        )->execute([$itemId, $user_id]);

        $varStmt = $pdo->prepare("
            INSERT INTO menu_item_variations (
                user_id,
                item_id,
                name,
                mrp_price,
                selling_price,
                discount_percent,
                dine_in_price,
                takeaway_price,
                delivery_price,
                is_active
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
        ");

        $minPrice = PHP_FLOAT_MAX;

        foreach ($input['variations'] as $v) {
            $selling = (float)$v['selling_price'];

            $varStmt->execute([
                $user_id,
                $itemId,
                $v['name'],
                $v['mrp_price'],
                $selling,
                $v['discount_percent'] ?? 0,
                $v['dine_in_price'] ?? null,
                $v['takeaway_price'] ?? null,
                $v['delivery_price'] ?? null,
            ]);

            $minPrice = min($minPrice, $selling);
        }

        // update base price
        $pdo->prepare(
            "UPDATE menu_items SET price = ? WHERE id = ?"
        )->execute([$minPrice, $itemId]);
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Menu item updated successfully"
    ]);

} catch (Throwable $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}