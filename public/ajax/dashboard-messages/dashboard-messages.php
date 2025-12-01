<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once '../../../src/database.php';
require_once '../../../src/functions.php';

// Check if user is logged in and is admin
if (!isLoggedIn()) {
    exit(json_encode(["type" => "error", "msg" => "Please login first"]));
}
if (!isAdmin()) {
    exit(json_encode(["type" => "error", "msg" => "Access denied"]));
}

// Get database connection
$pdo = getDbConnection();

$request = $_POST['request'] ?? '';

// Create new message
if ($request == 'create') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $expiry_value = $_POST['expiry_value'] ?? '';
    $expiry_type = $_POST['expiry_type'] ?? 'hours';
    $seller_type = $_POST['seller_type'] ?? [];
    $just_created_seller = isset($_POST['just_created_seller']) ? 1 : 0;

    // Validate inputs
    if (empty($title) || empty($description) || empty($expiry_value)) {
        exit(json_encode(["type" => "error", "msg" => "All required fields must be filled"]));
    }

    // Calculate expiry date
    $expiry_date = calculateExpiryDate($expiry_value, $expiry_type);

    // Prepare seller type as JSON
    $seller_type_json = null;
    if (!empty($seller_type) && !in_array('all', $seller_type)) {
        $seller_type_json = json_encode($seller_type);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO dashboard_messages (title, description, expiry_type, expiry_value, expiry_date, seller_type, just_created_seller) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $expiry_type, $expiry_value, $expiry_date, $seller_type_json, $just_created_seller]);

        exit(json_encode(["type" => "success", "msg" => "Message created successfully!"]));
    } catch (PDOException $e) {
        exit(json_encode(["type" => "error", "msg" => "Failed to create message: " . $e->getMessage()]));
    }
}

// Get all messages for display - FIXED RESPONSE FORMAT
if ($request == 'display') {
    try {
        $stmt = $pdo->query("SELECT * FROM dashboard_messages ORDER BY id DESC");
        $messages = $stmt->fetchAll(PDO::FETCH_OBJ);

        $data = [];
        foreach ($messages as $key => $message) {
            // Calculate status
            $is_expired = isMessageExpired($message->expiry_date);
            $status = $is_expired ? 'Expired' : 'Active';

            // Format seller types
            $seller_types = "All Sellers";
            if ($message->seller_type) {
                $seller_ids = json_decode($message->seller_type, true);
                if ($seller_ids && is_array($seller_ids)) {
                    $placeholders = str_repeat('?,', count($seller_ids) - 1) . '?';
                    $stmt2 = $pdo->prepare("SELECT name FROM subscription_plans WHERE id IN ($placeholders)");
                    $stmt2->execute($seller_ids);
                    $plans = $stmt2->fetchAll(PDO::FETCH_COLUMN);
                    $seller_types = implode(', ', $plans);
                }
            }

            // Format expiry date
            $formatted_expiry = convertToAppTimezone($message->expiry_date, 'd/m/Y');
            $formatted_time = convertToAppTimezone($message->expiry_date, 'g:i A');
            $combined_expiry = $formatted_expiry . '<br>' . $formatted_time;

            // Set expiry text
            if (!$is_expired) {
                $expiry_text = '<span class="text-success">Expires: ' . $combined_expiry . '</span>';
            } else {
                $expiry_text = '<span class="text-danger">Expired: ' . $combined_expiry . '</span>';
            }

            // Add just created seller badge
            $target_badge = '';
            if ($message->just_created_seller) {
                $target_badge = '<span class="badge badge-light-primary ms-2">New Sellers Only</span>';
            }

            // CRITICAL: Make sure ALL fields that JavaScript expects are included
            $data[] = [
                "id" => $message->id,
                "title" => htmlspecialchars($message->title),
                "description" => htmlspecialchars($message->description),
                "expiry" => $expiry_text,
                "seller_type" => $seller_types,
                "status" => $status, // This must match exactly "Active" or "Expired"
                "just_created_seller" => $message->just_created_seller,
                "target_badge" => $target_badge
            ];
        }

        // FIXED: Return proper JSON structure
        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
        exit;
        
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "error" => "Database error"
        ]);
        exit;
    }
}

// Delete message
if ($request == 'delete') {
    $id = $_POST['id'] ?? 0;

    if (empty($id)) {
        exit(json_encode(["type" => "error", "msg" => "Invalid message ID"]));
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM dashboard_messages WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            exit(json_encode(["type" => "success", "msg" => "Message deleted successfully!"]));
        } else {
            exit(json_encode(["type" => "error", "msg" => "Message not found"]));
        }
    } catch (PDOException $e) {
        exit(json_encode(["type" => "error", "msg" => "Failed to delete message"]));
    }
}

exit(json_encode(["type" => "error", "msg" => "Invalid request"]));