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

// Add these functions to function.php

/**
 * Get duration value from total days
 */
function getDurationValue($totalDays)
{
    if ($totalDays % 365 === 0) {
        return $totalDays / 365; // Years
    } elseif ($totalDays % 30 === 0) {
        return $totalDays / 30; // Months
    }
    return 1; // Default
}

/**
 * Get duration type from total days
 */
function getDurationType($totalDays)
{
    if ($totalDays % 365 === 0) {
        return 'year';
    } elseif ($totalDays % 30 === 0) {
        return 'month';
    }
    return 'year'; // Default
}

/**
 * Convert duration value and type to total days
 */
function convertToDays($value, $type)
{
    if ($type === 'month') {
        return $value * 30; // Approximate month as 30 days
    } elseif ($type === 'year') {
        return $value * 365; // Approximate year as 365 days
    }
    return $value; // Default to days if somehow other type
}

/**
 * Convert total days to display format (e.g., "1 Year", "6 Months")
 */
function convertDurationForDisplay($totalDays)
{
    if ($totalDays % 365 === 0) {
        $years = $totalDays / 365;
        return $years . ($years > 1 ? ' Years' : ' Year');
    } elseif ($totalDays % 30 === 0) {
        $months = $totalDays / 30;
        return $months . ($months > 1 ? ' Months' : ' Month');
    }
    return $totalDays . ' Days'; // Fallback
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
function uploadImage($file, $folder = 'uploads')
{
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


// get data from database
function getData($column, $table, $condition = "")
{
    $pdo = getDbConnection();

    if (empty($condition)) {
        $sql = "SELECT $column FROM $table LIMIT 1";
    } else {
        $sql = "SELECT $column FROM $table WHERE $condition LIMIT 1";
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row->$column;
        }

        return null;
    } catch (PDOException $e) {
        error_log("Database error in getData(): " . $e->getMessage());
        return null;
    }
}
// Get timezone from settings
function getAppTimezone()
{
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT timezone FROM settings LIMIT 1");
        $settings = $stmt->fetch(PDO::FETCH_OBJ);
        return $settings->timezone ?? 'Asia/Kolkata';
    } catch (Exception $e) {
        return 'Asia/Kolkata';
    }
}

// Get current time in app timezone
function getCurrentAppTime($format = 'Y-m-d H:i:s')
{
    $timezone = getAppTimezone();
    try {
        $date = new DateTime('now', new DateTimeZone($timezone));
        return $date->format($format);
    } catch (Exception $e) {
        $date = new DateTime('now');
        return $date->format($format);
    }
}

// Convert any datetime to app timezone
function convertToAppTimezone($datetime, $format = 'Y-m-d H:i:s')
{
    $timezone = getAppTimezone();
    try {
        $date = new DateTime($datetime, new DateTimeZone('UTC')); // Assuming datetime is stored as UTC
        $date->setTimezone(new DateTimeZone($timezone));
        return $date->format($format);
    } catch (Exception $e) {
        // If conversion fails, try without assuming UTC
        try {
            $date = new DateTime($datetime);
            $date->setTimezone(new DateTimeZone($timezone));
            return $date->format($format);
        } catch (Exception $e2) {
            return $datetime;
        }
    }
}

// Calculate expiry date using app timezone - FIXED VERSION
function calculateExpiryDate($value, $type)
{
    $timezone = getAppTimezone();

    try {
        // Create current time in app timezone
        $currentTime = new DateTime('now', new DateTimeZone($timezone));

        // Add the interval based on type
        switch ($type) {
            case 'hours':
                $interval = new DateInterval("PT{$value}H");
                break;
            case 'days':
                $interval = new DateInterval("P{$value}D");
                break;
            case 'weeks':
                $interval = new DateInterval("P{$value}W");
                break;
            case 'months':
                $interval = new DateInterval("P{$value}M");
                break;
            default:
                $interval = new DateInterval("PT1H"); // Default 1 hour
        }

        $currentTime->add($interval);

        // Convert to UTC before storing in database
        $currentTime->setTimezone(new DateTimeZone('UTC'));
        return $currentTime->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        // Fallback - use UTC directly
        $utcNow = new DateTime('now', new DateTimeZone('UTC'));
        $utcNow->add(new DateInterval("PT{$value}H")); // Default to hours
        return $utcNow->format('Y-m-d H:i:s');
    }
}

// Check if message is expired considering timezone - FIXED
function isMessageExpired($expiryDate)
{
    try {
        $timezone = getAppTimezone();

        // Expiry date is stored as UTC in database
        $expiryTime = new DateTime($expiryDate, new DateTimeZone('UTC'));
        $expiryTime->setTimezone(new DateTimeZone($timezone));

        // Current time in app timezone
        $currentTime = new DateTime('now', new DateTimeZone($timezone));

        return $currentTime > $expiryTime;
    } catch (Exception $e) {
        // Fallback string comparison
        $currentAppTime = getCurrentAppTime('Y-m-d H:i:s');
        return strtotime($currentAppTime) > strtotime($expiryDate);
    }
}

// Check if seller is newly created (for just_created_seller feature)
function isNewlyCreatedSeller($sellerCreatedAt, $messageCreatedAt)
{
    try {
        $timezone = getAppTimezone();

        $sellerTime = new DateTime($sellerCreatedAt, new DateTimeZone('UTC'));
        $sellerTime->setTimezone(new DateTimeZone($timezone));

        $messageTime = new DateTime($messageCreatedAt, new DateTimeZone('UTC'));
        $messageTime->setTimezone(new DateTimeZone($timezone));

        return $sellerTime > $messageTime;
    } catch (Exception $e) {
        return strtotime($sellerCreatedAt) > strtotime($messageCreatedAt);
    }
}


