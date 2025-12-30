<?php
// api/menu-items/toggle-availability.php
require "../../config/db.php";
require "../../config/auth.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

try {
    if (!isset($data['id']) || !isset($data['available'])) {
        throw new Exception("ID and available status are required");
    }
    
    $stmt = $pdo->prepare("
        UPDATE menu_items 
        SET is_available = ?, updated_at = NOW() 
        WHERE id = ? AND user_id = ?
    ");
    
    $stmt->execute([
        $data['available'] ? 1 : 0,
        $data['id'],
        $user_id
    ]);
    
    if ($stmt->rowCount() === 0) {
        throw new Exception("Menu item not found or access denied");
    }
    
    echo json_encode([
        "success" => true,
        "message" => "Availability updated successfully"
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}