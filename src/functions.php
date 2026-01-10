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


/**
 * Get user's plan limit for a specific resource
 */
function getUserPlanLimit($user_id, $resource_type)
{
    $pdo = getDbConnection();

    // Map resource types to column names
    $column_map = [
        'appointments' => 'appointments_limit',
        'customers' => 'customers_limit',
        'services' => 'services_limit',
        'menu' => 'menu_limit', // ✅ Support both 'menu'
        'menu_items' => 'menu_limit', // ✅ and 'menu_items'
        'coupons' => 'coupons_limit',
        'manual_payment_methods' => 'manual_payment_methods_limit',
        'free_credits' => 'free_credits'
    ];

    // Alias mapping for backward compatibility
    if ($resource_type === 'menu') {
        $resource_type = 'menu_items'; // Treat 'menu' as 'menu_items'
    }

    if (!isset($column_map[$resource_type])) {
        return [
            'can_add' => false,
            'message' => 'Invalid resource type: ' . $resource_type,
            'current' => 0,
            'limit' => 0,
            'remaining' => 0
        ];
    }

    $column = $column_map[$resource_type];

    // Get user's current plan
    $stmt = $pdo->prepare("
        SELECT u.plan_id, sp.$column as limit_value
        FROM users u 
        LEFT JOIN subscription_plans sp ON u.plan_id = sp.id 
        WHERE u.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ✅ KEY CHANGE: Allow 1 resource for users without a plan
    if (!$user || $user['plan_id'] === null) {
        $limit = 1; // Allow only 1 resource for users without plan

        // Get current count for this resource
        if ($resource_type === 'services') {
            // Count only departments + categories for services limit
            $stmt = $pdo->prepare("
                SELECT 
                    (SELECT COUNT(*) FROM departments WHERE user_id = ?) +
                    (SELECT COUNT(*) FROM categories WHERE user_id = ?) as total_count
            ");
            $stmt->execute([$user_id, $user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $current_count = $result['total_count'] ?? 0;

            if ($current_count >= $limit) {
                return [
                    'can_add' => false,
                    'message' => "You can only create 1 without a plan.<br>Please subscribe to a plan to add more.",
                    'current' => $current_count,
                    'limit' => $limit,
                    'remaining' => 0
                ];
            }

            return [
                'can_add' => true,
                'message' => "You can only create 1 without a plan.<br>Please subscribe to a plan to add more.",
                'current' => $current_count,
                'limit' => $limit,
                'remaining' => $limit - $current_count
            ];
        } elseif ($resource_type === 'menu_items') {
            // Count menu items for menu limit
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM menu_items WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $current_count = $result['count'] ?? 0;

            if ($current_count >= $limit) {
                return [
                    'can_add' => false,
                    'message' => "You can only create 1 menu item without a plan.<br>Please subscribe to a plan to add more.",
                    'current' => $current_count,
                    'limit' => $limit,
                    'remaining' => 0
                ];
            }

            return [
                'can_add' => true,
                'message' => "You can create 1 menu item without a plan. Subscribe to add more.",
                'current' => $current_count,
                'limit' => $limit,
                'remaining' => $limit - $current_count
            ];
        } else {
            // Normal counting for other resources
            $table_map = [
                'appointments' => 'appointments',
                'customers' => 'customers',
                'coupons' => 'coupons',
                'manual_payment_methods' => 'manual_payment_methods'
            ];

            $current_count = 0;
            if (isset($table_map[$resource_type])) {
                $table = $table_map[$resource_type];
                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM $table WHERE user_id = ?");
                $stmt->execute([$user_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $current_count = $result['count'];
            }

            if ($current_count >= $limit) {
                return [
                    'can_add' => false,
                    'message' => "You can only create 1 {$resource_type} without a plan.<br>Please subscribe to a plan to add more.",
                    'current' => $current_count,
                    'limit' => $limit,
                    'remaining' => 0
                ];
            }

            return [
                'can_add' => true,
                'message' => "You can create 1 {$resource_type} without a plan. Subscribe to add more.",
                'current' => $current_count,
                'limit' => $limit,
                'remaining' => $limit - $current_count
            ];
        }
    }

    $limit_value = $user['limit_value'];

    // Check if unlimited
    if ($limit_value === 'unlimited') {
        return [
            'can_add' => true,
            'message' => 'Unlimited usage',
            'current' => 0,
            'limit' => 'unlimited',
            'remaining' => 'unlimited'
        ];
    }

    $limit = (int)$limit_value;

    // Get current count for this resource
    $current_count = 0;

    if ($resource_type === 'services') {
        // ✅ SERVICES: Count only departments + categories
        $stmt = $pdo->prepare("
            SELECT 
                (SELECT COUNT(*) FROM departments WHERE user_id = ?) as dept_count,
                (SELECT COUNT(*) FROM categories WHERE user_id = ?) as cat_count
        ");
        $stmt->execute([$user_id, $user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $current_count = ($result['dept_count'] ?? 0) + ($result['cat_count'] ?? 0);
    } elseif ($resource_type === 'menu_items') {
        // ✅ MENU ITEMS: Count menu_items only
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM menu_items WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_count = $result['count'] ?? 0;
    } else {
        // Normal counting for other resources
        $table_map = [
            'appointments' => 'appointments',
            'customers' => 'customers',
            'coupons' => 'coupons',
            'manual_payment_methods' => 'manual_payment_methods'
        ];

        if (isset($table_map[$resource_type])) {
            $table = $table_map[$resource_type];
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM $table WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $current_count = $result['count'];
        }
    }

    // For free_credits, handle differently (not a count but a value)
    if ($resource_type === 'free_credits') {
        return [
            'can_add' => true,
            'message' => "Your plan includes {$limit_value} free credits",
            'current' => 0,
            'limit' => $limit_value,
            'remaining' => $limit_value
        ];
    }

    if ($current_count >= $limit) {
        return [
            'can_add' => false,
            'message' => "You have reached your limit ({$limit}).<br>Please upgrade your plan to add more.",
            'current' => $current_count,
            'limit' => $limit,
            'remaining' => 0
        ];
    }

    return [
        'can_add' => true,
        'message' => "You can add " . ($limit - $current_count) . " more.",
        'current' => $current_count,
        'limit' => $limit,
        'remaining' => $limit - $current_count
    ];
}

/**
 * Check if user can add a specific resource
 */
function canUserAddResource($user_id, $resource_type)
{
    $result = getUserPlanLimit($user_id, $resource_type);
    return $result['can_add'];
}

/**
 * Get user's resource usage summary
 */
function getUserResourceUsage($user_id, $resource_type = null)
{
    if ($resource_type) {
        // Get specific resource usage
        return getUserPlanLimit($user_id, $resource_type);
    } else {
        // Get all resource usage (now includes menu_items)
        $resources = ['appointments', 'customers', 'services', 'coupons', 'manual_payment_methods', 'menu_items'];
        $usage = [];

        foreach ($resources as $resource) {
            $usage[$resource] = getUserPlanLimit($user_id, $resource);
        }

        return $usage;
    }
}

/**
 * Validate resource limit before adding (use in your API files)
 */
function validateResourceLimit($user_id, $resource_type)
{
    $result = getUserPlanLimit($user_id, $resource_type);

    if (!$result['can_add']) {
        http_response_code(403); // Forbidden
        echo json_encode([
            'success' => false,
            'message' => $result['message'],
            'current' => $result['current'],
            'limit' => $result['limit'],
            'remaining' => $result['remaining']
        ]);
        exit();
    }

    return $result;
}


/**
 * Get actual resource count for user based on service type
 */
function getUserActualResourcesCount($user_id) {
    $pdo = getDbConnection();
    
    // First get user's service_type_id
    $stmt = $pdo->prepare("SELECT service_type_id FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        return [
            'services_count' => 0,
            'services_label' => 'Services',
            'menu_items_count' => 0,
            'menu_items_label' => 'Menu Items'
        ];
    }
    
    $service_type_id = $user['service_type_id'];
    $services_count = 0;
    $menu_items_count = 0;
    $services_label = 'Services';
    $menu_items_label = 'Menu Items';
    
    // Determine what to count based on service_type_id
    switch ($service_type_id) {
        case 1: // HOSPITAL - count categories
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM categories WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $services_count = $result['count'] ?? 0;
            $services_label = 'Categories';
            break;
            
        case 2: // HOTEL - count menu_items
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM menu_items WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $menu_items_count = $result['count'] ?? 0;
            $services_label = 'Menu Items';
            break;
            
        case 3: // OTHER - count departments
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM departments WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $services_count = $result['count'] ?? 0;
            $services_label = 'Services';
            break;
            
        default:
            // Count both as fallback
            $stmt = $pdo->prepare("
                SELECT 
                    (SELECT COUNT(*) FROM categories WHERE user_id = ?) as cat_count,
                    (SELECT COUNT(*) FROM departments WHERE user_id = ?) as dept_count,
                    (SELECT COUNT(*) FROM menu_items WHERE user_id = ?) as menu_count
            ");
            $stmt->execute([$user_id, $user_id, $user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $services_count = ($result['cat_count'] ?? 0) + ($result['dept_count'] ?? 0);
            $menu_items_count = $result['menu_count'] ?? 0;
            break;
    }
    
    return [
        'services_count' => $services_count,
        'services_label' => $services_label,
        'menu_items_count' => $menu_items_count,
        'menu_items_label' => $menu_items_label
    ];
}

/**
 * Enhanced version of getUserPlanLimit with actual counts display
 */
function getUserPlanLimitWithActual($user_id, $resource_type) {
    // First get the standard plan limit
    $planLimit = getUserPlanLimit($user_id, $resource_type);
    
    // Get actual resource counts based on service type
    $actualCounts = getUserActualResourcesCount($user_id);
    
    // Update the response based on resource type
    if ($resource_type === 'services') {
        $planLimit['actual_count'] = $actualCounts['services_count'];
        $planLimit['label'] = $actualCounts['services_label'];
    } elseif ($resource_type === 'menu_items') {
        $planLimit['actual_count'] = $actualCounts['menu_items_count'];
        $planLimit['label'] = $actualCounts['menu_items_label'];
    } else {
        // For other resources, get actual count from database
        $pdo = getDbConnection();
        $table_map = [
            'appointments' => 'appointments',
            'customers' => 'customers',
            'coupons' => 'coupons',
            'manual_payment_methods' => 'manual_payment_methods'
        ];
        
        if (isset($table_map[$resource_type])) {
            $table = $table_map[$resource_type];
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM $table WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $planLimit['actual_count'] = $result['count'] ?? 0;
            $planLimit['label'] = ucfirst(str_replace('_', ' ', $resource_type));
        }
    }
    
    return $planLimit;
}



/**
 * Get actual customer count for a specific user
 * This counts how many customers belong to a specific user_id
 */
function getActualCustomerCount($user_id) {
    $pdo = getDbConnection();
    
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) as customer_count FROM customers WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['customer_count'] ?? 0;
    } catch (Exception $e) {
        error_log("Error getting customer count: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get customer limit info with actual count
 */
function getCustomerLimitWithCount($user_id) {
    // Get plan limit
    $planLimit = getUserPlanLimit($user_id, 'customers');
    
    // Get actual count
    $actualCount = getActualCustomerCount($user_id);
    
    // Combine the data
    $planLimit['actual_count'] = $actualCount;
    $planLimit['label'] = 'Customers';
    
    return $planLimit;
}