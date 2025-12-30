<?php
// api/menu-items/add.php (updated)
require "../../config/db.php";
require "../../config/auth.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

try {
    // Validate required fields
    $required = ['name', 'menu_id', 'food_type', 'stock_type', 'variations'];
    foreach ($required as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }
    
    // Start transaction
    $pdo->beginTransaction();
    
    /* INSERT MENU ITEM */
    $stmt = $pdo->prepare("
        INSERT INTO menu_items
        (user_id, menu_id, category_id, name, description,
         food_type, halal, stock_type, stock_qty, stock_unit,
         customer_limit, customer_limit_period, image,
         preparation_time, selling_price, mrp_price, is_best_seller,
         is_available, show_on_site)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");
    
    // Calculate base prices from first variation
    $firstVariation = $data['variations'][0];
    $sellingPrice = $firstVariation['sellingPrice'];
    $mrpPrice = $firstVariation['mrpPrice'];
    
    $stmt->execute([
        $user_id,
        $data['menu_id'],
        $data['category_id'] ?? null,
        $data['name'],
        $data['description'] ?? null,
        $data['food_type'],
        $data['halal'] ? 1 : 0,
        $data['stock_type'],
        $data['stock_qty'] ?? null,
        $data['stock_unit'] ?? null,
        $data['customer_limit'] ?? null,
        $data['customer_limit_period'] ?? null,
        $data['image'] ?? null,
        $data['preparation_time'] ?? 15, // default 15 minutes
        0, // will be updated with min price
        0, // will be updated with min price
        $data['is_best_seller'] ?? 0,
        $data['is_available'] ?? 1,
        $data['show_on_site'] ?? 1
    ]);
    
    $menu_item_id = $pdo->lastInsertId();
    
    /* INSERT VARIATIONS */
    $varStmt = $pdo->prepare("
        INSERT INTO menu_item_variations
        (menu_item_id, name, mrp_price, selling_price, discount_percent,
         dine_in_price, takeaway_price, delivery_price, is_default)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");
    
    $minSellingPrice = PHP_INT_MAX;
    $minMrpPrice = PHP_INT_MAX;
    
    foreach ($data['variations'] as $index => $v) {
        $varStmt->execute([
            $menu_item_id,
            $v['name'],
            $v['mrpPrice'],
            $v['sellingPrice'],
            $v['discountPercent'] ?? null,
            $v['dineInPrice'] ?? null,
            $v['takeawayPrice'] ?? null,
            $v['deliveryPrice'] ?? null,
            $index === 0 ? 1 : 0 // first variation is default
        ]);
        
        // Track min prices
        $minSellingPrice = min($minSellingPrice, $v['sellingPrice']);
        $minMrpPrice = min($minMrpPrice, $v['mrpPrice']);
    }
    
    /* UPDATE MENU ITEM WITH MIN PRICES */
    $updatePriceStmt = $pdo->prepare("
        UPDATE menu_items 
        SET selling_price = ?, mrp_price = ?
        WHERE id = ?
    ");
    
    $updatePriceStmt->execute([$minSellingPrice, $minMrpPrice, $menu_item_id]);
    
    $pdo->commit();
    
    echo json_encode([
        "success" => true,
        "id" => $menu_item_id,
        "message" => "Menu item added successfully"
    ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}