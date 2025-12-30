<?php
// api/menu-items/update.php
require "../../config/db.php";
require "../../config/auth.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

try {
    if (!isset($data['id'])) {
        throw new Exception("Menu item ID is required");
    }
    
    $menu_item_id = $data['id'];
    unset($data['id']);
    
    // Check if user owns this menu item
    $checkStmt = $pdo->prepare("SELECT id FROM menu_items WHERE id = ? AND user_id = ?");
    $checkStmt->execute([$menu_item_id, $user_id]);
    
    if (!$checkStmt->fetch()) {
        throw new Exception("Menu item not found or access denied");
    }
    
    // Build update query
    $fields = [];
    $values = [];
    
    foreach ($data as $key => $value) {
        // Handle boolean values
        if (in_array($key, ['halal', 'is_available', 'show_on_site', 'is_best_seller'])) {
            $value = $value ? 1 : 0;
        }
        
        $fields[] = "$key = ?";
        $values[] = $value;
    }
    
    if (empty($fields)) {
        throw new Exception("No fields to update");
    }
    
    $values[] = $menu_item_id;
    
    $sql = "UPDATE menu_items SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
    
    echo json_encode([
        "success" => true,
        "message" => "Menu item updated successfully"
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}