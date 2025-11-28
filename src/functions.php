<?php

session_start();

function renderTemplate($template, $data = [])
{
    extract($data);
    include __DIR__ . "/../templates/$template.php";
}

function isLoggedIn()
{
    // Check if the user is logged in by verifying if the session variable is set
    return isset($_SESSION['SESSION_EMAIL']);
}

function redirect($url)
{
    echo '<script>window.location.href="' . $url . '"</script>';
}

function convertDays($totalDays)
{
    if ($totalDays < 30) {
        return "{$totalDays} days";
    } elseif ($totalDays < 365) {
        $months = floor($totalDays / 30);
        return "{$months} months";
    } else {
        $years = floor($totalDays / 365);
        return "{$years} years";
    }
}

function getCurrencySymbol($currency)
{
    if ($currency == 'USD') {
        return '$';
    } elseif ($currency == 'INR') {
        return '₹';
    } else {
        return $currency;
    }
}
function uuid()
{
    return sprintf(
        '%s-%s-%s-%s-%s',
        bin2hex(random_bytes(4)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(6))
    );
}
function uploadImage($file, $folder = 'uploads') {
    // Get the absolute path to uploads folder
    $uploadPath = __DIR__ . '/../uploads/' . $folder . '/';
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }
    
    // Generate unique filename
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $fileExtension;
    $filePath = $uploadPath . $fileName;
    
    // Check file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($fileExtension), $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type'];
    }
    
    // Check file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        return ['success' => false, 'error' => 'File too large'];
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        return ['success' => true, 'file_name' => $folder . '/' . $fileName];
    }
    
    return ['success' => false, 'error' => 'Upload failed'];
}


