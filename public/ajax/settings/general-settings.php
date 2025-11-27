<?php
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

$name = $_POST['name'] ?? '';
$existing_image = $_POST['existing_image'] ?? '';
$old_name = $_POST['old_name'] ?? '';

// Get current admin data to compare changes
$current_admin = $pdo->query("SELECT * FROM managers WHERE role = 'admin' LIMIT 1")->fetch(PDO::FETCH_OBJ);

// Track changes
$changes = [];

// Handle image upload
$image = $existing_image;
$image_changed = false;
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $uploadResult = uploadImage($_FILES['image'], 'managers');
    if ($uploadResult['success']) {
        $image = $uploadResult['file_name'];
        $image_changed = true;
        // Delete old image if it exists and is not the default
        if (!empty($existing_image) && $existing_image !== 'static/user.png') {
            $oldImagePath = __DIR__ . '/../../../uploads/' . $existing_image;
            @unlink($oldImagePath);
        }
    } else {
        exit(json_encode(["type" => "error", "msg" => $uploadResult['error'] ?? "Image upload failed"]));
    }
}

// Check if name changed
$name_changed = ($name !== $old_name);

// Validate name
if (empty($name)) {
    exit(json_encode(["type" => "error", "msg" => "Name is required"]));
}

// Prepare success message based on changes
if ($image_changed && $name_changed) {
    $success_msg = "Profile image and name updated successfully!";
} elseif ($image_changed) {
    $success_msg = "Profile image updated successfully!";
} elseif ($name_changed) {
    $success_msg = "Name updated successfully!";
} else {
    $success_msg = "No changes were made.";
}

// Update manager data only if there are changes
if ($image_changed || $name_changed) {
    $stmt = $pdo->prepare("UPDATE managers SET name = ?, image = ? WHERE role = 'admin'");
    if ($stmt->execute([$name, $image])) {
        exit(json_encode(["type" => "success", "msg" => $success_msg]));
    } else {
        exit(json_encode(["type" => "error", "msg" => "Failed to update settings"]));
    }
} else {
    exit(json_encode(["type" => "info", "msg" => $success_msg]));
}
?>