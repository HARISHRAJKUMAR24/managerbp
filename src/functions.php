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
 * Get user's plan limit for a specific resource WITH EXPIRY CHECK
 */
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

/**
 * Check if user can add a specific resource
 */
function canUserAddResource($user_id, $resource_type)
{
    $result = getUserPlanLimit($user_id, $resource_type);
    return $result['can_add'];
}

/**
 * Get user's resource usage summary WITH EXPIRY CHECK
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
 * Validate resource limit before adding (use in your API files) WITH EXPIRY CHECK
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
            'remaining' => $result['remaining'],
            'plan_expired' => $result['plan_expired'] ?? false,
            'expiry_message' => $result['expiry_message'] ?? ''
        ]);
        exit();
    }

    return $result;
}


/* ------------- Get actual resource count for user based on service type ------------- */
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

/* ------------- Enhanced version of getUserPlanLimit with actual counts display ------------- */
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



/* ------------- Get actual customer count for a specific user
 * This counts how many customers belong to a specific user_id ------------- */
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

/**
 * Get customer limit info with actual count
 */
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


// Add this function to your functions.php file

/**
 * Determine and store the service reference ID based on user's service type
 * This function will:
 * 1. Check user's service_type from users table
 * 2. Based on service_type, get the appropriate reference ID
 *    - HOSPITAL (HOS): category_id from categories table
 *    - OTHER (OTH): department_id from departments table
 *    - HOTEL (HOT): category_id from categories table (hotel)
 * 3. Store the reference ID in customer_payment table
 * 
 * @param int $user_id The user/seller ID
 * @param int $customer_id The customer ID
 * @param string $payment_id The payment ID (Razorpay Payment ID)
 * @param string $service_type Optional: Override auto-detected service type
 * @return array Result with success status and reference details
 */
function storeServiceReference($user_id, $customer_id, $payment_id, $service_type = null) {
    $pdo = getDbConnection();
    
    try {
        // 1. Get user's service type if not provided
        if (!$service_type) {
            $stmt = $pdo->prepare("
                SELECT u.service_type_id, st.code 
                FROM users u 
                LEFT JOIN service_types st ON u.service_type_id = st.id 
                WHERE u.user_id = ?
            ");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found'
                ];
            }
            
            $service_type = $user['code'] ?? 'OTHER';
        }
        
        // 2. Determine which table to query based on service type
        $reference_id = null;
        $reference_type = null;
        $reference_name = null;
        
        switch (strtoupper($service_type)) {
            case 'HOSPITAL':
            case 'HOS':
            case 'HOTEL':
            case 'HOT':
                // For Hospital and Hotel: Get from categories table
                $stmt = $pdo->prepare("
                    SELECT category_id as ref_id, name, doctor_name 
                    FROM categories 
                    WHERE user_id = ? 
                    LIMIT 1
                ");
                $stmt->execute([$user_id]);
                $service = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($service) {
                    $reference_id = $service['ref_id'];
                    $reference_type = 'category_id';
                    $reference_name = $service['doctor_name'] ?? $service['name'];
                }
                break;
                
            case 'OTHER':
            case 'OTH':
                // For Others: Get from departments table
                $stmt = $pdo->prepare("
                    SELECT department_id as ref_id, name 
                    FROM departments 
                    WHERE user_id = ? 
                    LIMIT 1
                ");
                $stmt->execute([$user_id]);
                $service = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($service) {
                    $reference_id = $service['ref_id'];
                    $reference_type = 'department_id';
                    $reference_name = $service['name'];
                }
                break;
                
            default:
                return [
                    'success' => false,
                    'message' => 'Unknown service type: ' . $service_type
                ];
        }
        
        if (!$reference_id) {
            return [
                'success' => false,
                'message' => 'No service found for this user'
            ];
        }
        
        // 3. Add columns to customer_payment if they don't exist
        // (This can be removed after adding columns via SQL)
        try {
            $checkColumns = $pdo->prepare("
                SELECT COLUMN_NAME 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_NAME = 'customer_payment' 
                AND TABLE_SCHEMA = DATABASE()
                AND COLUMN_NAME IN ('service_reference_id', 'service_reference_type', 'service_name')
            ");
            $checkColumns->execute();
            $existingColumns = array_column($checkColumns->fetchAll(), 'COLUMN_NAME');
            
            // Add missing columns
            if (!in_array('service_reference_id', $existingColumns)) {
                $pdo->exec("ALTER TABLE customer_payment ADD COLUMN service_reference_id VARCHAR(255) DEFAULT NULL");
            }
            if (!in_array('service_reference_type', $existingColumns)) {
                $pdo->exec("ALTER TABLE customer_payment ADD COLUMN service_reference_type VARCHAR(50) DEFAULT NULL");
            }
            if (!in_array('service_name', $existingColumns)) {
                $pdo->exec("ALTER TABLE customer_payment ADD COLUMN service_name VARCHAR(255) DEFAULT NULL");
            }
        } catch (Exception $e) {
            // Columns might already exist, ignore error
        }
        
        // 4. Update the customer_payment record
        $update = $pdo->prepare("
            UPDATE customer_payment 
            SET 
                service_reference_id = ?,
                service_reference_type = ?,
                service_name = ?
            WHERE user_id = ? 
            AND customer_id = ? 
            AND payment_id = ?
            LIMIT 1
        ");
        
        $update->execute([
            $reference_id,
            $reference_type,
            $reference_name,
            $user_id,
            $customer_id,
            $payment_id
        ]);
        
        $affected = $update->rowCount();
        
        if ($affected > 0) {
            return [
                'success' => true,
                'message' => 'Service reference stored successfully',
                'data' => [
                    'service_type' => $service_type,
                    'reference_id' => $reference_id,
                    'reference_type' => $reference_type,
                    'service_name' => $reference_name
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No payment record found to update'
            ];
        }
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ];
    }
}

/**
 * Alternative: Simple function to get service reference ID for a user
 * This can be called from payment verification
 * 
 * @param int $user_id
 * @return array Reference ID and type
 */
function getServiceReference($user_id) {
    $pdo = getDbConnection();
    
    // Get user's service type
    $stmt = $pdo->prepare("
        SELECT u.service_type_id, st.code 
        FROM users u 
        LEFT JOIN service_types st ON u.service_type_id = st.id 
        WHERE u.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        return [
            'success' => false,
            'message' => 'User not found'
        ];
    }
    
    $service_type = $user['code'] ?? 'OTHER';
    $reference_id = null;
    $reference_type = null;
    $reference_name = null;
    
    switch (strtoupper($service_type)) {
        case 'HOSPITAL':
        case 'HOS':
        case 'HOTEL':
        case 'HOT':
            // Get category
            $stmt = $pdo->prepare("
                SELECT category_id as ref_id, name, doctor_name 
                FROM categories 
                WHERE user_id = ? 
                LIMIT 1
            ");
            $stmt->execute([$user_id]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($service) {
                $reference_id = $service['ref_id'];
                $reference_type = 'category_id';
                $reference_name = $service['doctor_name'] ?? $service['name'];
            }
            break;
            
        case 'OTHER':
        case 'OTH':
            // Get department
            $stmt = $pdo->prepare("
                SELECT department_id as ref_id, name 
                FROM departments 
                WHERE user_id = ? 
                LIMIT 1
            ");
            $stmt->execute([$user_id]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($service) {
                $reference_id = $service['ref_id'];
                $reference_type = 'department_id';
                $reference_name = $service['name'];
            }
            break;
    }
    
    if (!$reference_id) {
        return [
            'success' => false,
            'message' => 'No service found for user'
        ];
    }
    
    return [
        'success' => true,
        'service_type' => $service_type,
        'reference_id' => $reference_id,
        'reference_type' => $reference_type,
        'service_name' => $reference_name
    ];
}

/**
 * Update customer_payment with SPECIFIC service reference
 */
function updatePaymentWithServiceReference($user_id, $customer_id, $payment_id, $specific_service_id = null) {
    $pdo = getDbConnection();
    
    // If no specific ID provided, we can't determine which service
    if (!$specific_service_id) {
        return [
            'success' => false,
            'message' => 'No service ID provided'
        ];
    }
    
    // Determine if it's a category or department ID
    $is_category = (strpos($specific_service_id, 'CAT_') === 0);
    $is_department = (strpos($specific_service_id, 'DEPT_') === 0);
    
    $reference_id = null;
    $reference_type = null;
    $reference_name = null;
    
    if ($is_category) {
        // It's a category/doctor ID
        $stmt = $pdo->prepare("
            SELECT category_id as ref_id, name, doctor_name 
            FROM categories 
            WHERE category_id = ? 
            AND user_id = ?
        ");
        $stmt->execute([$specific_service_id, $user_id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($service) {
            $reference_id = $service['ref_id'];
            $reference_type = 'category_id';
            $reference_name = $service['doctor_name'] ?? $service['name'];
        }
    } elseif ($is_department) {
        // It's a department ID
        $stmt = $pdo->prepare("
            SELECT department_id as ref_id, name 
            FROM departments 
            WHERE department_id = ? 
            AND user_id = ?
        ");
        $stmt->execute([$specific_service_id, $user_id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($service) {
            $reference_id = $service['ref_id'];
            $reference_type = 'department_id';
            $reference_name = $service['name'];
        }
    } else {
        return [
            'success' => false,
            'message' => 'Invalid service ID format'
        ];
    }
    
    if (!$reference_id) {
        return [
            'success' => false,
            'message' => 'Service not found for this user'
        ];
    }
    
    // Update the payment record
    $update = $pdo->prepare("
        UPDATE customer_payment 
        SET 
            service_reference_id = ?,
            service_reference_type = ?,
            service_name = ?
        WHERE user_id = ? 
        AND customer_id = ? 
        AND payment_id = ?
        LIMIT 1
    ");
    
    $update->execute([
        $reference_id,
        $reference_type,
        $reference_name,
        $user_id,
        $customer_id,
        $payment_id
    ]);
    
    if ($update->rowCount() > 0) {
        return [
            'success' => true,
            'message' => 'Payment updated with specific service reference',
            'data' => [
                'reference_id' => $reference_id,
                'reference_type' => $reference_type,
                'service_name' => $reference_name
            ]
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Payment record not found'
        ];
    }
}


// managerbp/src/function.php

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