<?php
// api/menu-items/get.php
require "../../config/db.php";
require "../../config/auth.php";

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        SELECT 
            mi.*,
            c.name as category_name,
            m.name as menu_name,
            COUNT(DISTINCT oi.id) as order_count,
            AVG(r.rating) as avg_rating,
            CASE 
                WHEN mi.stock_type = 'unlimited' THEN 'Unlimited Stock'
                WHEN mi.stock_type = 'limited' AND mi.stock_qty > 0 THEN CONCAT(mi.stock_qty, ' ', mi.stock_unit, ' left')
                ELSE 'Out of Stock'
            END as stock_display,
            CASE 
                WHEN mi.food_type = 'veg' THEN 1
                ELSE 0
            END as is_veg,
            DATE_FORMAT(mi.updated_at, '%d %b, %H:%i') as last_updated_display
        FROM menu_items mi
        LEFT JOIN categories c ON mi.category_id = c.id
        LEFT JOIN menus m ON mi.menu_id = m.id
        LEFT JOIN order_items oi ON mi.id = oi.menu_item_id
        LEFT JOIN reviews r ON mi.id = r.menu_item_id
        WHERE mi.user_id = ?
        GROUP BY mi.id
        ORDER BY mi.created_at DESC
    ");
    
    $stmt->execute([$user_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Transform data for frontend
    $transformed = array_map(function($item) {
        return [
            'id' => (int)$item['id'],
            'name' => $item['name'],
            'description' => $item['description'],
            'category' => $item['category_name'],
            'menu' => $item['menu_name'],
            'food_type' => $item['food_type'],
            'halal' => (bool)$item['halal'],
            'stock' => $item['stock_display'],
            'stock_type' => $item['stock_type'],
            'stock_qty' => $item['stock_qty'],
            'stock_unit' => $item['stock_unit'],
            'preparationTime' => (int)$item['preparation_time'],
            'price' => (float)$item['selling_price'],
            'originalPrice' => (float)$item['mrp_price'],
            'orderCount' => (int)$item['order_count'],
            'rating' => (float)number_format($item['avg_rating'] ?: 0, 1),
            'bestSeller' => (bool)$item['is_best_seller'],
            'available' => (bool)$item['is_available'],
            'showOnSite' => (bool)$item['show_on_site'],
            'lastUpdated' => $item['last_updated_display'],
            'veg' => (bool)$item['is_veg']
        ];
    }, $items);
    
    echo json_encode($transformed);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}