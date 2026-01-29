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

// ---------------------- get data from database ---------------------- //
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

// ---------------------- Get timezone from settings ---------------------- //
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

// ---------------------- Get current time in app timezone ---------------------- //
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

// ---------------------- Convert any datetime to app timezone ---------------------- //
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

//  ---------------------- Calculate expiry date using app timezone - FIXED VERSION ---------------------- //
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

//  ---------------------- Check if message is expired considering timezone - FIXED ---------------------- //
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

//  ---------------------- Check if seller is newly created (for just_created_seller feature) ---------------------- 
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


 //---------------------- Get user's plan limit for a specific resource WITH EXPIRY CHECK  ---------------------- //

function getUserPlanLimit($user_id, $resource_type)
{
    $pdo = getDbConnection();

    // First check if user's plan is expired
    $expirySql = "SELECT plan_id, expires_on FROM users WHERE user_id = ?";
    $expiryStmt = $pdo->prepare($expirySql);
    $expiryStmt->execute([$user_id]);
    $userData = $expiryStmt->fetch(PDO::FETCH_ASSOC);

    $plan_expired = false;
    $plan_expired_message = '';

    if ($userData && $userData['expires_on'] && $userData['expires_on'] !== '0000-00-00 00:00:00') {
        $expiry_date = new DateTime($userData['expires_on']);
        $today = new DateTime('now');
        $plan_expired = ($expiry_date < $today);

        if ($plan_expired) {
            $plan_expired_message = "Your plan has expired. Please renew to continue using all features.";
        }
    }

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
            'remaining' => 0,
            'plan_expired' => $plan_expired,
            'expiry_message' => $plan_expired_message
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

    // If plan expired, restrict to 0 for all resources
    if ($plan_expired) {
        // Get current count for this resource
        $current_count = 0;

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
        } elseif ($resource_type === 'menu_items') {
            // Count menu items for menu limit
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

            $current_count = 0;
            if (isset($table_map[$resource_type])) {
                $table = $table_map[$resource_type];
                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM $table WHERE user_id = ?");
                $stmt->execute([$user_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $current_count = $result['count'] ?? 0;
            }
        }

        return [
            'can_add' => false,
            'message' => $plan_expired_message,
            'current' => $current_count,
            'limit' => 0,
            'remaining' => 0,
            'plan_expired' => true,
            'expiry_message' => $plan_expired_message
        ];
    }

    // ✅ User without a plan (new user) - allow 1 resource
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
                    'remaining' => 0,
                    'plan_expired' => false,
                    'expiry_message' => ''
                ];
            }

            return [
                'can_add' => true,
                'message' => "You can only create 1 without a plan.<br>Please subscribe to a plan to add more.",
                'current' => $current_count,
                'limit' => $limit,
                'remaining' => $limit - $current_count,
                'plan_expired' => false,
                'expiry_message' => ''
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
                    'remaining' => 0,
                    'plan_expired' => false,
                    'expiry_message' => ''
                ];
            }

            return [
                'can_add' => true,
                'message' => "You can create 1 menu item without a plan. Subscribe to add more.",
                'current' => $current_count,
                'limit' => $limit,
                'remaining' => $limit - $current_count,
                'plan_expired' => false,
                'expiry_message' => ''
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
                $current_count = $result['count'] ?? 0;
            }

            if ($current_count >= $limit) {
                return [
                    'can_add' => false,
                    'message' => "You can only create 1 {$resource_type} without a plan.<br>Please subscribe to a plan to add more.",
                    'current' => $current_count,
                    'limit' => $limit,
                    'remaining' => 0,
                    'plan_expired' => false,
                    'expiry_message' => ''
                ];
            }

            return [
                'can_add' => true,
                'message' => "You can create 1 {$resource_type} without a plan. Subscribe to add more.",
                'current' => $current_count,
                'limit' => $limit,
                'remaining' => $limit - $current_count,
                'plan_expired' => false,
                'expiry_message' => ''
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
            'remaining' => 'unlimited',
            'plan_expired' => false,
            'expiry_message' => ''
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
            $current_count = $result['count'] ?? 0;
        }
    }

    // For free_credits, handle differently (not a count but a value)
    if ($resource_type === 'free_credits') {
        return [
            'can_add' => true,
            'message' => "Your plan includes {$limit_value} free credits",
            'current' => 0,
            'limit' => $limit_value,
            'remaining' => $limit_value,
            'plan_expired' => false,
            'expiry_message' => ''
        ];
    }

    if ($current_count >= $limit) {
        return [
            'can_add' => false,
            'message' => "You have reached your limit ({$limit}).<br>Please upgrade your plan to add more.",
            'current' => $current_count,
            'limit' => $limit,
            'remaining' => 0,
            'plan_expired' => false,
            'expiry_message' => ''
        ];
    }

    return [
        'can_add' => true,
        'message' => "You can add " . ($limit - $current_count) . " more.",
        'current' => $current_count,
        'limit' => $limit,
        'remaining' => $limit - $current_count,
        'plan_expired' => false,
        'expiry_message' => ''
    ];
}

// ----------------------  Check if user can add a specific resource ---------------------- //

function canUserAddResource($user_id, $resource_type)
{
    $result = getUserPlanLimit($user_id, $resource_type);
    return $result['can_add'];
}

// ----------------------  Get user's resource usage summary WITH EXPIRY CHECK ---------------------- 

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

// ----------------------  Validate resource limit before adding (use in your API files) WITH EXPIRY CHECK ---------------------- 

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
            'remaining' => $result['remaining'],
            'plan_expired' => $result['plan_expired'] ?? false,
            'expiry_message' => $result['expiry_message'] ?? ''
        ]);
        exit();
    }

    return $result;
}


// ------------- Get actual resource count for user based on service type  ---------------------- 
function getUserActualResourcesCount($user_id)
{
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

//  ----------------------  Enhanced version of getUserPlanLimit with actual counts display  ---------------------- //
function getUserPlanLimitWithActual($user_id, $resource_type)
{
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



// ------------- Get actual customer count for a specific user This counts how many customers belong to a specific user_id  ---------------------- //
function getActualCustomerCount($user_id)
{
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

// ----------------------  Get customer limit info with actual count  ---------------------- //
function getCustomerLimitWithCount($user_id)
{
    // Get plan limit
    $planLimit = getUserPlanLimit($user_id, 'customers');

    // Get actual count
    $actualCount = getActualCustomerCount($user_id);

    // Combine the data
    $planLimit['actual_count'] = $actualCount;
    $planLimit['label'] = 'Customers';

    return $planLimit;
}



// ---------------------- Generate Appointment ID - Universal version ---------------------- //
/**
 * Generate Appointment ID - Universal version
 * Works with or without services table
 */// managerbp/src/functions.php

/**
 * Generate Appointment ID in format: {user_id}{SERVICE_CODE}{random_string}
 * Simple and working version
 */
function generateAppointmentId($user_id, $db) {
    
    // Section 1: User ID
    $section1 = (string)$user_id;
    
    // Section 2: Get service type code
    $stmt = $db->prepare("
        SELECT st.code, st.id as service_type_id 
        FROM users u 
        LEFT JOIN service_types st ON u.service_type_id = st.id 
        WHERE u.user_id = ? 
        LIMIT 1
    ");
    
    if ($stmt->execute([$user_id])) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && !empty($result['code'])) {
            // Get first 3 letters of service type code
            $code = strtoupper(substr($result['code'], 0, 3));
            $service_type_id = $result['service_type_id'] ?? 1;
            $section2 = $code . $service_type_id;
        } else {
            // Fallback if no service type found
            $section2 = 'DEF1';
        }
    } else {
        // Error in query, use fallback
        $section2 = 'DEF1';
    }
    
    // Section 3: Random string (4-5 chars, lowercase only)
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $length = rand(4, 5);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    $section3 = $randomString;
    
    // Combine all sections
    $appointmentId = $section1 . $section2 . $section3;
    
    return $appointmentId;
}

//  ----------------------  Create Store CATEGORY_ID  ---------------------- //

// Store CATEGORY_ID in service_reference_id

/**
 * Update payment with category reference
 * Stores category_id (CAT_xxx) in service_reference_id
 */
// function updatePaymentWithCategoryReference($user_id, $customer_id, $payment_id, $category_id = null) {
    
//     $pdo = getDbConnection();
    
//     // If category_id is provided, use it
//     if ($category_id) {
//         // Get category details
//         $stmt = $pdo->prepare("
//             SELECT category_id, name, doctor_name 
//             FROM categories 
//             WHERE category_id = ? 
//             AND user_id = ?
//             LIMIT 1
//         ");
//         $stmt->execute([$category_id, $user_id]);
//         $category = $stmt->fetch(PDO::FETCH_ASSOC);
        
//         if ($category) {
//             $serviceInfo = [
//                 'success' => true,
//                 'reference_id' => $category['category_id'], // CAT_xxx
//                 'reference_type' => 'category_id',
//                 'service_name' => $category['doctor_name'] ?? $category['name'],
//                 'doctor_name' => $category['doctor_name'] ?? $category['name']
//             ];
//         } else {
//             // Category not found, check doctor_schedule
//             $stmt = $pdo->prepare("
//                 SELECT ds.id, ds.category_id, ds.name, 
//                        c.category_id as cat_ref_id, c.doctor_name, c.name as cat_name
//                 FROM doctor_schedule ds
//                 LEFT JOIN categories c ON ds.category_id = c.category_id
//                 WHERE ds.category_id = ? 
//                 AND ds.user_id = ?
//                 LIMIT 1
//             ");
//             $stmt->execute([$category_id, $user_id]);
//             $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
            
//             if ($doctor && $doctor['cat_ref_id']) {
//                 $serviceInfo = [
//                     'success' => true,
//                     'reference_id' => $doctor['cat_ref_id'], // CAT_xxx from categories
//                     'reference_type' => 'category_id',
//                     'service_name' => $doctor['doctor_name'] ?? $doctor['cat_name'] ?? $doctor['name'],
//                     'doctor_name' => $doctor['doctor_name'] ?? $doctor['name']
//                 ];
//             }
//         }
//     }
    
//     // // If no category found, fallback to old method
//     // if (!isset($serviceInfo) || !$serviceInfo['success']) {
//     //     $serviceInfo = getServiceReference($user_id);
//     // }
    
//     if (!$serviceInfo['success']) {
//         return $serviceInfo;
//     }
    
//     // Update the payment record
//     try {
//         // Update the record
//         $update = $pdo->prepare("
//             UPDATE customer_payment 
//             SET 
//                 service_reference_id = ?,
//                 service_reference_type = ?,
//                 service_name = ?
//             WHERE user_id = ? 
//             AND customer_id = ? 
//             AND payment_id = ?
//             LIMIT 1
//         ");
        
//         $update->execute([
//             $serviceInfo['reference_id'],
//             $serviceInfo['reference_type'],
//             $serviceInfo['service_name'],
//             $user_id,
//             $customer_id,
//             $payment_id
//         ]);
        
//         if ($update->rowCount() > 0) {
//             return [
//                 'success' => true,
//                 'message' => 'Payment updated with category reference',
//                 'data' => $serviceInfo
//             ];
//         } else {
//             return [
//                 'success' => false,
//                 'message' => 'Payment record not found'
//             ];
//         }
        
//     } catch (Exception $e) {
//         return [
//             'success' => false,
//             'message' => 'Database error: ' . $e->getMessage()
//         ];
//     }
// }


// /**
//  * Update PayU payment with category reference
//  * This function is used in payu-success.php
//  */
// function updatePayUWithCategoryReference($user_id, $customer_id, $payment_id, $category_id = null) {
    
//     $pdo = getDbConnection();
    
//     // Get category details
//     $serviceInfo = getCategoryReference($user_id, $category_id);
    
//     if (!$serviceInfo['success']) {
//         return $serviceInfo;
//     }
    
//     // Update the payment record
//     try {
//         $update = $pdo->prepare("
//             UPDATE customer_payment 
//             SET 
//                 service_reference_id = ?,
//                 service_reference_type = ?,
//                 service_name = ?
//             WHERE user_id = ? 
//             AND customer_id = ? 
//             AND payment_id = ?
//             LIMIT 1
//         ");
        
//         $update->execute([
//             $serviceInfo['reference_id'],
//             $serviceInfo['reference_type'],
//             $serviceInfo['service_name'],
//             $user_id,
//             $customer_id,
//             $payment_id
//         ]);
        
//         if ($update->rowCount() > 0) {
//             return [
//                 'success' => true,
//                 'message' => 'PayU payment updated with category reference',
//                 'data' => $serviceInfo
//             ];
//         } else {
//             return [
//                 'success' => false,
//                 'message' => 'PayU payment record not found'
//             ];
//         }
        
//     } catch (Exception $e) {
//         return [
//             'success' => false,
//             'message' => 'Database error: ' . $e->getMessage()
//         ];
//     }
// }

/**
 * Simple function to get category reference
 */
// function getCategoryReference($user_id, $category_id = null) {
//     $pdo = getDbConnection();
    
//     // If category_id provided, get specific category
//     if ($category_id) {
//         $stmt = $pdo->prepare("
//             SELECT category_id, name, doctor_name 
//             FROM categories 
//             WHERE category_id = ? 
//             AND user_id = ?
//             LIMIT 1
//         ");
//         $stmt->execute([$category_id, $user_id]);
//         $category = $stmt->fetch(PDO::FETCH_ASSOC);
        
//         if ($category) {
//             return [
//                 'success' => true,
//                 'reference_id' => $category['category_id'], // CAT_xxx
//                 'reference_type' => 'category_id',
//                 'service_name' => $category['doctor_name'] ?? $category['name']
//             ];
//         }
//     }
    
//     // Get first category for this user
//     $stmt = $pdo->prepare("
//         SELECT category_id, name, doctor_name 
//         FROM categories 
//         WHERE user_id = ? 
//         LIMIT 1
//     ");
//     $stmt->execute([$user_id]);
//     $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
//     if ($category) {
//         return [
//             'success' => true,
//             'reference_id' => $category['category_id'], // CAT_xxx
//             'reference_type' => 'category_id',
//             'service_name' => $category['doctor_name'] ?? $category['name']
//         ];
//     }
    
//     return [
//         'success' => false,
//         'message' => 'Category not found'
//     ];
// }


// ---------------------- Check token availability for a specific doctor's batch ---------------------- //

function checkTokenAvailability($userId, $batchId, $appointmentDate, $pdo = null) {
    try {
        // If no PDO connection provided, create one
        if ($pdo === null) {
            require_once __DIR__ . "/config.php";
            require_once __DIR__ . "/database.php";
            $pdo = getDbConnection();
        }
        
        // Step 1: Get doctor's schedule to find token limit for this batch
        $scheduleStmt = $pdo->prepare("
            SELECT token_limit, weekly_schedule 
            FROM doctor_schedule 
            WHERE user_id = ?
        ");
        $scheduleStmt->execute([$userId]);
        $doctor = $scheduleStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$doctor) {
            return [
                'available' => false,
                'message' => 'Doctor schedule not found',
                'booked' => 0,
                'total' => 0,
                'remaining' => 0
            ];
        }
        
        $tokenLimit = (int)$doctor['token_limit'];
        
        // Step 2: Parse weekly schedule to get token for this specific batch
        $weeklySchedule = !empty($doctor['weekly_schedule']) 
            ? json_decode($doctor['weekly_schedule'], true) 
            : [];
        
        $batchToken = 0;
        
        // Find the token count for this batch from weekly schedule
        foreach ($weeklySchedule as $day => $daySchedule) {
            if (!empty($daySchedule['slots'])) {
                foreach ($daySchedule['slots'] as $slot) {
                    if (isset($slot['batch_id']) && $slot['batch_id'] == $batchId) {
                        $batchToken = isset($slot['token']) ? (int)$slot['token'] : $tokenLimit;
                        break 2;
                    }
                }
            }
        }
        
        // If batch not found in schedule
        if ($batchToken === 0) {
            return [
                'available' => false,
                'message' => 'Batch not found in schedule',
                'booked' => 0,
                'total' => 0,
                'remaining' => 0
            ];
        }
        
        // Step 3: Count how many appointments are already booked for this batch and date
        $bookingStmt = $pdo->prepare("
            SELECT SUM(token_count) as total_booked 
            FROM customer_payment 
            WHERE user_id = ? 
            AND batch_id = ? 
            AND appointment_date = ? 
            AND status IN ('paid', 'pending', 'confirmed')
        ");
        
        $bookingStmt->execute([$userId, $batchId, $appointmentDate]);
        $result = $bookingStmt->fetch(PDO::FETCH_ASSOC);
        
        $bookedCount = (int)($result['total_booked'] ?? 0);
        
        // Step 4: Calculate remaining tokens
        $remainingTokens = max(0, $batchToken - $bookedCount);
        
        // Step 5: Determine availability
        $isAvailable = $remainingTokens > 0;
        
        return [
            'available' => $isAvailable,
            'message' => $isAvailable 
                ? "Available ($remainingTokens tokens left)" 
                : "Appointment full ($bookedCount/$batchToken)",
            'booked' => $bookedCount,
            'total' => $batchToken,
            'remaining' => $remainingTokens,
            'token_limit' => $tokenLimit,
            'batch_token' => $batchToken
        ];
        
    } catch (Exception $e) {
        return [
            'available' => false,
            'message' => 'Error checking availability: ' . $e->getMessage(),
            'booked' => 0,
            'total' => 0,
            'remaining' => 0
        ];
    }
}

// ---------------------- Get available slots for a specific date with token availability  ---------------------- //
function getAvailableSlotsForDate($userId, $date, $pdo = null) {
    try {
        if ($pdo === null) {
            require_once __DIR__ . "/config.php";
            require_once __DIR__ . "/database.php";
            $pdo = getDbConnection();
        }
        
        // Step 1: Get doctor's schedule
        $scheduleStmt = $pdo->prepare("
            SELECT weekly_schedule, leave_dates, token_limit
            FROM doctor_schedule 
            WHERE user_id = ?
        ");
        $scheduleStmt->execute([$userId]);
        $doctor = $scheduleStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$doctor) {
            return ['available' => false, 'slots' => [], 'message' => 'Doctor not found'];
        }
        
        // Check if date is a leave day
        $leaveDates = !empty($doctor['leave_dates']) 
            ? json_decode($doctor['leave_dates'], true) 
            : [];
        
        if (in_array($date, $leaveDates)) {
            return ['available' => false, 'slots' => [], 'message' => 'Doctor is on leave'];
        }
        
        // Get day of week for this date
        $dateTime = new DateTime($date);
        $dayOfWeek = $dateTime->format('D'); // Returns "Sun", "Mon", etc.
        
        $weeklySchedule = !empty($doctor['weekly_schedule']) 
            ? json_decode($doctor['weekly_schedule'], true) 
            : [];
        
        // Check if doctor has schedule for this day
        if (!isset($weeklySchedule[$dayOfWeek]) || !$weeklySchedule[$dayOfWeek]['enabled']) {
            return ['available' => false, 'slots' => [], 'message' => 'No schedule for this day'];
        }
        
        $daySchedule = $weeklySchedule[$dayOfWeek];
        $availableSlots = [];
        
        // Step 2: Check each slot's availability
        if (!empty($daySchedule['slots'])) {
            foreach ($daySchedule['slots'] as $slot) {
                $batchId = $slot['batch_id'] ?? '';
                
                if (!$batchId) {
                    continue;
                }
                
                // Check token availability for this batch
                $availability = checkTokenAvailability($userId, $batchId, $date, $pdo);
                
                if ($availability['available']) {
                    $slot['availability'] = $availability;
                    $slot['available_tokens'] = $availability['remaining'];
                    $slot['booked_tokens'] = $availability['booked'];
                    $slot['total_tokens'] = $availability['total'];
                    $availableSlots[] = $slot;
                }
            }
        }
        
        return [
            'available' => count($availableSlots) > 0,
            'slots' => $availableSlots,
            'message' => count($availableSlots) > 0 
                ? count($availableSlots) . ' slot(s) available' 
                : 'No available slots',
            'date' => $date,
            'day' => $dayOfWeek
        ];
        
    } catch (Exception $e) {
        return [
            'available' => false,
            'slots' => [],
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}

/**
 * API endpoint to check slot availability
 */
function apiCheckSlotAvailability() {
    header("Content-Type: application/json; charset=utf-8");
    header("Access-Control-Allow-Origin: *");
    
    try {
        require_once __DIR__ . "/../../../config/config.php";
        require_once __DIR__ . "/../../../src/database.php";
        $pdo = getDbConnection();
        
        $userId = (int)($_GET['user_id'] ?? 0);
        $batchId = $_GET['batch_id'] ?? '';
        $date = $_GET['date'] ?? '';
        
        if (!$userId || !$batchId || !$date) {
            echo json_encode([
                'success' => false,
                'message' => 'Missing parameters: user_id, batch_id, and date are required'
            ]);
            exit;
        }
        
        // Validate date format
        if (!DateTime::createFromFormat('Y-m-d', $date)) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid date format. Use YYYY-MM-DD'
            ]);
            exit;
        }
        
        $availability = checkTokenAvailability($userId, $batchId, $date, $pdo);
        
        echo json_encode([
            'success' => true,
            'data' => $availability
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ]);
    }
}

// Uncomment to test the API endpoint directly
// if (basename($_SERVER['PHP_SELF']) === 'check_availability.php') {
//     apiCheckSlotAvailability();
// }


// ---------------------- Token Histroy send to db token_history ---------------------- //
function compareAndLogTokenUpdates($oldSchedule, $newSchedule, $scheduleId, $pdo, $categoryId) {
    $oldSlots = [];
    $newSlots = [];
    
    // Parse old slots
    $oldScheduleArray = json_decode($oldSchedule, true);
    foreach ($oldScheduleArray as $day => $dayData) {
        if ($dayData['enabled'] && !empty($dayData['slots'])) {
            foreach ($dayData['slots'] as $slot) {
                if (isset($slot['batch_id'])) {
                    $oldSlots[$slot['batch_id']] = [
                        'token' => (int)($slot['token'] ?? 0),
                        'batch_id' => $slot['batch_id']
                    ];
                }
            }
        }
    }
    
    // Parse new slots
    $newScheduleArray = json_decode($newSchedule, true);
    foreach ($newScheduleArray as $day => $dayData) {
        if ($dayData['enabled'] && !empty($dayData['slots'])) {
            foreach ($dayData['slots'] as $slot) {
                if (isset($slot['batch_id'])) {
                    $newSlots[$slot['batch_id']] = [
                        'token' => (int)($slot['token'] ?? 0),
                        'batch_id' => $slot['batch_id']
                    ];
                }
            }
        }
    }
    
    // Find differences
    $updates = [];
    foreach ($newSlots as $batchId => $newData) {
        $oldData = $oldSlots[$batchId] ?? null;
        $oldToken = $oldData['token'] ?? 0;
        $newToken = $newData['token'];
        
        if ($oldToken !== $newToken) {
            // Parse slot_index from batch_id
            $slotIndex = null;
            $parts = explode(':', $batchId);
            if (isset($parts[1])) {
                $slotIndex = (int)$parts[1];
            }
            
            $updates[] = [
                'batch_id' => $batchId,
                'slot_index' => $slotIndex,
                'old_token' => $oldToken,
                'new_token' => $newToken,
                'total_token' => $newToken
            ];
        }
    }
    
    // Log to history table
    if (!empty($updates)) {
        $historyStmt = $pdo->prepare("
            INSERT INTO doctor_token_history 
            (category_id, slot_batch_id, slot_index, old_token, new_token, total_token, doctor_schedule_id_temp, updated_by, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        foreach ($updates as $update) {
            $historyStmt->execute([
                $categoryId,
                $update['batch_id'],
                $update['slot_index'],
                $update['old_token'],
                $update['new_token'],
                $update['total_token'],
                $scheduleId,
                $_SESSION['user_id'] ?? null
            ]);
        }
    }
}




/**
 * Get service information based on user's service type - FIXED VERSION
 */

/**
 * Get service information based on user's service type - CORRECTED VERSION
 */
function getServiceInformation($db, $user_id, $service_type, $category_id = null, $service_name = '') {
    try {
        // First get user's service_type_id
        $stmt = $db->prepare("
            SELECT u.service_type_id, st.code, st.name as service_type_name
            FROM users u 
            LEFT JOIN service_types st ON u.service_type_id = st.id 
            WHERE u.user_id = ? 
            LIMIT 1
        ");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return [
                "success" => false,
                "message" => "User not found"
            ];
        }
        
        $service_type_id = $user['service_type_id'];
        $service_type_name = $user['service_type_name'] ?? 'Others';
        
        $reference_id = null;
        $reference_type = null;
        $service_name_json = '';
        
        // For HOSPITAL type (service_type_id = 1)
        if ($service_type_id == 1) {
            if ($service_type === 'department') {
                // Department booking
                if ($category_id) {
                    $stmt = $db->prepare("
                        SELECT department_id, name 
                        FROM departments 
                        WHERE department_id = ? 
                        AND user_id = ?
                        LIMIT 1
                    ");
                    $stmt->execute([$category_id, $user_id]);
                    $department = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($department) {
                        $reference_id = $department['department_id'];
                        $reference_type = 'department_id';
                        $service_name_json = json_encode([
                            "type" => "department",
                            "department_name" => $department['name'] ?? $service_name,
                            "service_type" => "Hospital Department"
                        ]);
                    }
                }
            } else {
                // Category/Doctor booking
                if ($category_id) {
                    // FIXED: Added specialization to SELECT query
                    $stmt = $db->prepare("
                        SELECT category_id, name, doctor_name, specialization 
                        FROM categories 
                        WHERE category_id = ? 
                        AND user_id = ?
                        LIMIT 1
                    ");
                    $stmt->execute([$category_id, $user_id]);
                    $category = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($category) {
                        $reference_id = $category['category_id'];
                        $reference_type = 'category_id';
                        // FIXED: Include specialization in JSON
                        $service_name_json = json_encode([
                            "type" => "doctor",
                            "doctor_name" => $category['doctor_name'] ?? $category['name'],
                            "specialization" => $category['specialization'] ?? '',
                            "service_type" => "Hospital Consultation"
                        ]);
                    } else {
                        // Check doctor_schedule
                        $stmt = $db->prepare("
                            SELECT ds.category_id, ds.name, 
                                   c.category_id as cat_ref_id, c.doctor_name, c.specialization, c.name as cat_name
                            FROM doctor_schedule ds
                            LEFT JOIN categories c ON ds.category_id = c.category_id
                            WHERE ds.category_id = ? 
                            AND ds.user_id = ?
                            LIMIT 1
                        ");
                        $stmt->execute([$category_id, $user_id]);
                        $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if ($doctor) {
                            $reference_id = $doctor['cat_ref_id'] ?? $doctor['category_id'];
                            $reference_type = 'category_id';
                            $service_name_json = json_encode([
                                "type" => "doctor",
                                "doctor_name" => $doctor['doctor_name'] ?? $doctor['name'],
                                "specialization" => $doctor['specialization'] ?? '',
                                "service_type" => "Hospital Consultation"
                            ]);
                        }
                    }
                }
            }
        } else {
            // For other service types (HOTEL=2, OTHERS=3)
            if ($category_id) {
                $stmt = $db->prepare("
                    SELECT category_id, name 
                    FROM categories 
                    WHERE category_id = ? 
                    AND user_id = ?
                    LIMIT 1
                ");
                $stmt->execute([$category_id, $user_id]);
                $category = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($category) {
                    $reference_id = $category['category_id'];
                    $reference_type = 'category_id';
                    
                    if ($service_type_id == 2) { // HOTEL
                        $service_name_json = json_encode([
                            "type" => "hotel_service",
                            "service_name" => $category['name'] ?? $service_name,
                            "service_type" => "Hotel Service"
                        ]);
                    } else { // OTHERS
                        $service_name_json = json_encode([
                            "type" => "service",
                            "service_name" => $category['name'] ?? $service_name,
                            "service_type" => "General Service"
                        ]);
                    }
                }
            }
        }
        
        // If no specific service found
        if (!$reference_id) {
            if ($service_name) {
                $reference_id = 'CUSTOM_' . uniqid();
                $reference_type = 'custom_service';
                $service_name_json = json_encode([
                    "type" => "custom",
                    "service_name" => $service_name,
                    "service_type" => $service_type_name
                ]);
            } else {
                $reference_id = 'GENERIC_' . $user_id;
                $reference_type = 'generic_service';
                $service_name_json = json_encode([
                    "type" => "generic",
                    "service_name" => "Service Booking",
                    "service_type" => $service_type_name
                ]);
            }
        }
        
        return [
            "success" => true,
            "reference_id" => $reference_id,
            "reference_type" => $reference_type,
            "service_name_json" => $service_name_json,
            "service_name_display" => $service_name ?: "Service Booking",
            "service_type_id" => $service_type_id,
            "service_type_name" => $service_type_name
        ];
        
    } catch (Exception $e) {
        error_log("getServiceInformation error: " . $e->getMessage());
        return [
            "success" => false,
            "message" => "Error getting service information: " . $e->getMessage()
        ];
    }
}


// Add these functions to your existing functions.php file

/**
 * Get service information for payment records
 */
function getServiceInfoForPayment($user_id, $service_type, $reference_id = null) {
    $pdo = getDbConnection();
    
    try {
        // Get user's service type
        $stmt = $pdo->prepare("
            SELECT u.service_type_id, st.code, st.name as service_type_name
            FROM users u 
            LEFT JOIN service_types st ON u.service_type_id = st.id 
            WHERE u.user_id = ? 
            LIMIT 1
        ");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return [
                "success" => false,
                "message" => "User not found"
            ];
        }
        
        $service_type_id = $user['service_type_id'];
        $service_type_code = $user['code'] ?? 'OTH';
        $service_type_name = $user['service_type_name'] ?? 'Others';
        
        $result = [
            "service_type_id" => $service_type_id,
            "service_type_code" => $service_type_code,
            "service_type_name" => $service_type_name,
            "reference_type" => null,
            "reference_id" => null,
            "service_name_json" => null,
            "display_name" => null
        ];
        
        // Handle based on service type
        if ($service_type === 'department') {
            if ($reference_id) {
                $stmt = $pdo->prepare("
                    SELECT department_id, name 
                    FROM departments 
                    WHERE department_id = ? 
                    AND user_id = ?
                    LIMIT 1
                ");
                $stmt->execute([$reference_id, $user_id]);
                $department = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($department) {
                    $result['reference_type'] = 'department_id';
                    $result['reference_id'] = $department['department_id'];
                    
                    if ($service_type_id == 1) { // HOSPITAL
                        $result['service_name_json'] = json_encode([
                            "type" => "hospital_department",
                            "department_name" => $department['name'],
                            "service_type" => "Hospital Department"
                        ]);
                    } else { // OTHERS
                        $result['service_name_json'] = json_encode([
                            "type" => "department",
                            "department_name" => $department['name'],
                            "service_type" => "Department Service"
                        ]);
                    }
                    $result['display_name'] = $department['name'];
                }
            }
        } else {
            // category/service type
            if ($reference_id) {
                $stmt = $pdo->prepare("
                    SELECT category_id, name, doctor_name, specialization 
                    FROM categories 
                    WHERE category_id = ? 
                    AND user_id = ?
                    LIMIT 1
                ");
                $stmt->execute([$reference_id, $user_id]);
                $category = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($category) {
                    $result['reference_type'] = 'category_id';
                    $result['reference_id'] = $category['category_id'];
                    
                    switch ($service_type_id) {
                        case 1: // HOSPITAL
                            $result['service_name_json'] = json_encode([
                                "type" => "doctor",
                                "doctor_name" => $category['doctor_name'] ?? $category['name'],
                                "specialization" => $category['specialization'] ?? '',
                                "service_type" => "Hospital Consultation"
                            ]);
                            $result['display_name'] = $category['doctor_name'] ?? $category['name'];
                            break;
                            
                        case 2: // HOTEL
                            $result['service_name_json'] = json_encode([
                                "type" => "hotel_service",
                                "service_name" => $category['name'],
                                "service_type" => "Hotel Service"
                            ]);
                            $result['display_name'] = $category['name'];
                            break;
                            
                        default: // OTHERS
                            $result['service_name_json'] = json_encode([
                                "type" => "service",
                                "service_name" => $category['name'],
                                "service_type" => $service_type_name
                            ]);
                            $result['display_name'] = $category['name'];
                            break;
                    }
                }
            }
        }
        
        // If no specific service found
        if (!$result['reference_id']) {
            $result['reference_type'] = 'generic_service';
            $result['reference_id'] = 'GENERIC_' . $user_id;
            $result['service_name_json'] = json_encode([
                "type" => "generic",
                "service_name" => "Service Booking",
                "service_type" => $service_type_name
            ]);
            $result['display_name'] = "Service Booking";
        }
        
        $result['success'] = true;
        return $result;
        
    } catch (Exception $e) {
        return [
            "success" => false,
            "message" => "Error: " . $e->getMessage()
        ];
    }
}

/**
 * Parse service_name JSON from database
 */
function parseServiceNameJson($service_name_json) {
    if (empty($service_name_json)) {
        return [
            "display" => "Service",
            "details" => []
        ];
    }
    
    try {
        $data = json_decode($service_name_json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            // If it's not valid JSON, treat it as plain text
            return [
                "display" => $service_name_json,
                "details" => [
                    "type" => "plain_text",
                    "service_name" => $service_name_json
                ]
            ];
        }
        
        // Format display text based on type
        $display = "Service";
        if (isset($data['type'])) {
            switch ($data['type']) {
                case 'doctor':
                    $display = $data['doctor_name'] ?? "Doctor Consultation";
                    if (isset($data['specialization']) && $data['specialization']) {
                        $display .= " - " . $data['specialization'];
                    }
                    break;
                    
                case 'hospital_department':
                case 'department':
                    $display = $data['department_name'] ?? "Department";
                    break;
                    
                case 'hotel_service':
                    $display = $data['service_name'] ?? "Hotel Service";
                    break;
                    
                case 'service':
                    $display = $data['service_name'] ?? "Service";
                    break;
                    
                default:
                    $display = $data['service_name'] ?? "Service";
                    break;
            }
        } elseif (isset($data['service_name'])) {
            $display = $data['service_name'];
        }
        
        return [
            "display" => $display,
            "details" => $data
        ];
        
    } catch (Exception $e) {
        return [
            "display" => "Service",
            "details" => [
                "error" => "Parse error",
                "raw" => substr($service_name_json, 0, 100)
            ]
        ];
    }
}




/**
 * Get department service information for JSON storage
 * Returns service names in format: service_type-1, service_type-2, etc.
 */
function getDepartmentServiceInformation($db, $user_id, $department_id, $department_name, $services = []) {
    try {
        // First get department details
        $stmt = $db->prepare("
            SELECT * FROM departments 
            WHERE department_id = ? 
            AND user_id = ?
            LIMIT 1
        ");
        $stmt->execute([$department_id, $user_id]);
        $department = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$department) {
            return [
                "success" => false,
                "message" => "Department not found"
            ];
        }
        
        $serviceData = [
            'department_name' => $department['name'] ?? $department_name,
            'department_id' => $department['department_id'],
            'services' => []
        ];
        
        // If services array is provided, use it
        if (!empty($services)) {
            // Add main service (type_main)
            if (!empty($services[0])) {
                $mainService = $services[0];
                $serviceData['services']['type_main'] = [
                    'name' => $mainService['name'] ?? ($department['type_main_name'] ?? 'Main Service'),
                    'price' => (float) ($mainService['price'] ?? ($department['type_main_amount'] ?? 0)),
                    'quantity' => (int) ($mainService['quantity'] ?? 1),
                    'hsn' => $mainService['hsn'] ?? ($department['type_main_hsn'] ?? null)
                ];
            }
            
            // Add additional services (type_1, type_2, etc.)
            $additionalIndex = 1;
            foreach ($services as $index => $service) {
                if ($index > 0) { // Skip first (main) service
                    // Get department service name if available
                    $deptServiceName = $department['type_' . $additionalIndex . '_name'] ?? null;
                    $deptServicePrice = $department['type_' . $additionalIndex . '_amount'] ?? 0;
                    
                    $serviceData['services']['type_' . $additionalIndex] = [
                        'name' => $service['name'] ?? $deptServiceName ?? 'Service ' . $additionalIndex,
                        'price' => (float) ($service['price'] ?? $deptServicePrice),
                        'quantity' => (int) ($service['quantity'] ?? 1),
                        'hsn' => $service['hsn'] ?? ($department['type_' . $additionalIndex . '_hsn'] ?? null)
                    ];
                    $additionalIndex++;
                }
            }
        } else {
            // Extract services from department fields
            if ($department['type_main_name'] && $department['type_main_amount']) {
                $serviceData['services']['type_main'] = [
                    'name' => $department['type_main_name'],
                    'price' => (float) $department['type_main_amount'],
                    'quantity' => 1,
                    'hsn' => $department['type_main_hsn'] ?? null
                ];
            }
            
            // Add additional services from department
            for ($i = 1; $i <= 25; $i++) {
                $nameField = 'type_' . $i . '_name';
                $amountField = 'type_' . $i . '_amount';
                $hsnField = 'type_' . $i . '_hsn';
                
                if (!empty($department[$nameField]) && !empty($department[$amountField])) {
                    $serviceData['services']['type_' . $i] = [
                        'name' => $department[$nameField],
                        'price' => (float) $department[$amountField],
                        'quantity' => 1,
                        'hsn' => $department[$hsnField] ?? null
                    ];
                }
            }
        }
        
        // Create JSON
        $service_name_json = json_encode($serviceData, JSON_UNESCAPED_UNICODE);
        
        return [
            "success" => true,
            "reference_id" => $department['department_id'],
            "reference_type" => "department_id",
            "service_name_json" => $service_name_json,
            "service_name_display" => $department['name'],
            "department_data" => $serviceData
        ];
        
    } catch (Exception $e) {
        return [
            "success" => false,
            "message" => "Error getting department service information: " . $e->getMessage()
        ];
    }
}

/**
 * Parse department service JSON for display
 */
function parseDepartmentServiceJson($service_name_json) {
    if (empty($service_name_json)) {
        return [
            "display" => "Department Service",
            "services" => [],
            "department_name" => ""
        ];
    }
    
    try {
        $data = json_decode($service_name_json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                "display" => "Department Service",
                "services" => [],
                "department_name" => "",
                "error" => "Invalid JSON"
            ];
        }
        
        $display = $data['department_name'] ?? "Department Service";
        $services = [];
        $services_list = [];
        
        if (isset($data['services']) && is_array($data['services'])) {
            foreach ($data['services'] as $type => $service) {
                if (isset($service['name']) && isset($service['price'])) {
                    $services[] = [
                        'type' => $type,
                        'name' => $service['name'],
                        'price' => $service['price'],
                        'quantity' => $service['quantity'] ?? 1,
                        'hsn' => $service['hsn'] ?? null
                    ];
                    
                    // Create display list
                    $qty = isset($service['quantity']) && $service['quantity'] > 1 ? " × " . $service['quantity'] : "";
                    $services_list[] = $service['name'] . " (₹" . $service['price'] . $qty . ")";
                }
            }
        }
        
        // Create detailed display
        if (!empty($services_list)) {
            $display .= " - " . implode(", ", $services_list);
        }
        
        return [
            "display" => $display,
            "services" => $services,
            "department_name" => $data['department_name'] ?? "",
            "department_id" => $data['department_id'] ?? null
        ];
        
    } catch (Exception $e) {
        return [
            "display" => "Department Service",
            "services" => [],
            "department_name" => "",
            "error" => $e->getMessage()
        ];
    }
}