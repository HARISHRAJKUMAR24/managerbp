<?php
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
            DATE_FORMAT(mi.updated_at, '%d %b, %H:%i') as last_updated
        FROM menu_items mi
        LEFT JOIN categories c ON mi.category_id = c.id AND c.user_id = ?
        LEFT JOIN menus m ON mi.menu_id = m.id AND m.user_id = ?
        LEFT JOIN order_items oi ON mi.id = oi.menu_item_id
        LEFT JOIN reviews r ON mi.id = r.menu_item_id
        WHERE mi.user_id = ?
        GROUP BY mi.id
        ORDER BY mi.created_at DESC
    ");
    
    $stmt->execute([$user_id, $user_id, $user_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($items);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}