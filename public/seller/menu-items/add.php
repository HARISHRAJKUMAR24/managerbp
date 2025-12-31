<?php

/* ===============================
   CORS
================================ */
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
    exit;
}

/* ===============================
   BOOTSTRAP
================================ */
require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* ===============================
   READ INPUT
================================ */
$raw = file_get_contents("php://input");
$input = json_decode($raw, true);

/* ===============================
   DEBUG (TEMP)
================================ */
file_put_contents(
    __DIR__ . "/debug.log",
    date("Y-m-d H:i:s") . " | RAW=" . $raw . PHP_EOL,
    FILE_APPEND
);

/* ===============================
   VALIDATION
================================ */
$required = ["menu_id", "name", "food_type", "stock_type", "variations"];

foreach ($required as $field) {
    if (empty($input[$field])) {
        echo json_encode([
            "success" => false,
            "message" => "$field is required"
        ]);
        exit;
    }
}

if (!is_array($input["variations"]) || count($input["variations"]) === 0) {
    echo json_encode([
        "success" => false,
        "message" => "At least one variation is required"
    ]);
    exit;
}

/* ===============================
   SAFE VALUES
================================ */
$userId = 1; // TODO: from session
$halal  = !empty($input["halal"]) ? 1 : 0;

$stockQty  = $input["stock_qty"] ?? null;
$stockUnit = $input["stock_unit"] ?? null;

/* ===============================
   TRANSACTION
================================ */
$pdo->beginTransaction();

try {

    /* INSERT MENU ITEM */
    $stmt = $pdo->prepare("
        INSERT INTO menu_items (
            user_id,
            menu_id,
            category_id,
            name,
            description,
            food_type,
            halal,
            stock_type,
            stock_qty,
            stock_unit,
            customer_limit,
            customer_limit_period,
            image,
            created_at
        ) VALUES (
            :user_id,
            :menu_id,
            :category_id,
            :name,
            :description,
            :food_type,
            :halal,
            :stock_type,
            :stock_qty,
            :stock_unit,
            :customer_limit,
            :customer_limit_period,
            :image,
            NOW()
        )
    ");

    $stmt->execute([
        ":user_id" => $userId,
        ":menu_id" => (int)$input["menu_id"],
        ":category_id" => $input["category_id"] ?? null,
        ":name" => trim($input["name"]),
        ":description" => $input["description"] ?? "",
        ":food_type" => $input["food_type"],
        ":halal" => $halal,
        ":stock_type" => $input["stock_type"],
        ":stock_qty" => $stockQty,
        ":stock_unit" => $stockUnit,
        ":customer_limit" => $input["customer_limit"] ?? null,
        ":customer_limit_period" => $input["customer_limit_period"] ?? null,
        ":image" => $input["image"] ?? null,
    ]);

    $itemId = $pdo->lastInsertId();

    /* INSERT VARIATIONS */
    $varStmt = $pdo->prepare("
        INSERT INTO menu_item_variations (
            item_id,
            name,
            mrp_price,
            selling_price,
            discount_percent,
            dine_in_price,
            takeaway_price,
            delivery_price,
            is_active
        ) VALUES (
            :item_id,
            :name,
            :mrp_price,
            :selling_price,
            :discount_percent,
            :dine_in_price,
            :takeaway_price,
            :delivery_price,
            1
        )
    ");

    $minSelling = PHP_FLOAT_MAX;

    foreach ($input["variations"] as $v) {

        $mrp = (float)$v["mrp_price"];
        $selling = (float)$v["selling_price"];

        $varStmt->execute([
            ":item_id" => $itemId,
            ":name" => $v["name"],
            ":mrp_price" => $mrp,
            ":selling_price" => $selling,
            ":discount_percent" => $v["discount_percent"] ?? 0,
            ":dine_in_price" => $v["dine_in_price"] ?? null,
            ":takeaway_price" => $v["takeaway_price"] ?? null,
            ":delivery_price" => $v["delivery_price"] ?? null,
        ]);

        $minSelling = min($minSelling, $selling);
    }

    /* UPDATE BASE PRICE */
    $pdo->prepare("
        UPDATE menu_items
        SET price = ?
        WHERE id = ?
    ")->execute([$minSelling, $itemId]);

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Menu item created successfully",
        "id" => $itemId
    ]);

} catch (Exception $e) {
    $pdo->rollBack();

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
