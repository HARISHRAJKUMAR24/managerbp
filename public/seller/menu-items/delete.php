<?php
// api/menu-items/delete.php
require "../../config/db.php";
require "../../config/auth.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

try {
    if (!isset($data['id'])) {
        throw new Exception("Menu item ID is required");
    }
    
    $menu_item_id = $data['id'];
    
    // Check if user owns this menu item
    $checkStmt = $pdo->prepare("SELECT id FROM menu_items WHERE id = ? AND user_id = ?");
    $checkStmt->execute([$menu_item_id, $user_id]);
    
    if (!$checkStmt->fetch()) {
        throw new Exception("Menu item not found or access denied");
    }
    
    // Start transaction
    $pdo->beginTransaction();
    
    // Delete variations first (foreign key constraint)
    $deleteVariations = $pdo->prepare("DELETE FROM menu_item_variations WHERE menu_item_id = ?");
    $deleteVariations->execute([$menu_item_id]);
    
    // Delete menu item
    $deleteItem = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
    $deleteItem->execute([$menu_item_id]);
    
    $pdo->commit();
    
    echo json_encode([
        "success" => true,
        "message" => "Menu item deleted successfully"
    ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}