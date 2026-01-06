<?php
// managerbp/public/seller/plans/no-downgrade.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

// Get user ID from query parameter or session
$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false,
        "message" => "User ID required"
    ]);
    exit;
}

try {
    // Get user's current plan details
    $userSql = "SELECT 
        u.plan_id,
        u.expires_on,
        sp.amount as current_plan_amount,
        sp.name as current_plan_name,
        sp.duration as current_plan_duration
    FROM users u
    LEFT JOIN subscription_plans sp ON u.plan_id = sp.id
    WHERE u.user_id = :user_id";

    $userStmt = $pdo->prepare($userSql);
    $userStmt->execute([':user_id' => $user_id]);
    $userData = $userStmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);
        exit;
    }

    // Get all available plans
    $planSql = "SELECT id, name, amount, duration FROM subscription_plans 
                WHERE is_disabled = 1 
                ORDER BY amount ASC";
    $planStmt = $pdo->prepare($planSql);
    $planStmt->execute();
    $allPlans = $planStmt->fetchAll(PDO::FETCH_ASSOC);

    // Get settings for GST calculation
    $settingsSql = "SELECT gst_percentage, gst_tax_type FROM settings LIMIT 1";
    $settingsStmt = $pdo->prepare($settingsSql);
    $settingsStmt->execute();
    $settings = $settingsStmt->fetch(PDO::FETCH_ASSOC);

    $gstPercentage = $settings['gst_percentage'] ?? 18;
    $gstType = $settings['gst_tax_type'] ?? 'exclusive';

    // FIXED: Correct duration format function
    function formatDurationDisplay($days)
    {
        if (!$days || $days <= 0) {
            return "N/A";
        }
        
        // Check if it's exactly years (365 days)
        if ($days == 365) {
            return "1 Year";
        } elseif ($days == 730) {
            return "2 Years";
        } elseif ($days == 1095) {
            return "3 Years";
        }
        // Check if it's exactly months (30 days)
        elseif ($days == 30) {
            return "1 Month";
        } elseif ($days == 60) {
            return "2 Months";
        } elseif ($days == 90) {
            return "3 Months";
        } elseif ($days == 180) {
            return "6 Months";
        }
        // For other durations, show in days
        elseif ($days < 30) {
            return "$days Days";
        } elseif ($days < 365) {
            $months = floor($days / 30);
            return "$months Months";
        } else {
            $years = floor($days / 365);
            $remaining_days = $days % 365;
            if ($remaining_days > 0) {
                $remaining_months = floor($remaining_days / 30);
                return "$years Years, $remaining_months Months";
            }
            return "$years Years";
        }
    }

    // Calculate current plan's final price (with GST)
    $currentPlanAmount = $userData['current_plan_amount'] ?? 0;
    $currentPlanFinalPrice = 0;

    if ($gstType === 'inclusive') {
        $currentPlanFinalPrice = $currentPlanAmount;
    } else {
        $currentPlanFinalPrice = $currentPlanAmount + ($currentPlanAmount * $gstPercentage / 100);
    }

    // Analyze each plan for upgrade eligibility
    $planStatuses = [];
    foreach ($allPlans as $plan) {
        $planAmount = $plan['amount'];

        // Calculate plan's final price (with GST)
        if ($gstType === 'inclusive') {
            $planFinalPrice = $planAmount;
        } else {
            $planFinalPrice = $planAmount + ($planAmount * $gstPercentage / 100);
        }

        // Determine button status and text
        $buttonStatus = 'available';
        $buttonText = 'Choose Plan';
        $isDisabled = false;

        // Check if user already has a plan
        if ($userData['plan_id'] !== null) {
            if ($plan['id'] == $userData['plan_id']) {
                // Same plan - show renew
                $buttonStatus = 'current';
                $buttonText = 'Renew Current Plan';
                $isDisabled = false;
            } else if ($planFinalPrice < $currentPlanFinalPrice) {
                // Downgrade - show message with current plan
                $buttonStatus = 'downgrade';
                $buttonText = 'You are in ' . ($userData['current_plan_name'] ?? 'Current Plan');
                $isDisabled = true;
            } else if ($planFinalPrice > $currentPlanFinalPrice) {
                // Upgrade - enable button
                $buttonStatus = 'upgrade';
                $buttonText = 'Upgrade Now';
                $isDisabled = false;
            } else {
                // Same price but different plan
                $buttonStatus = 'available';
                $buttonText = 'Switch Plan';
                $isDisabled = false;
            }
        } else {
            // User has no plan (new user)
            $buttonStatus = 'available';
            $buttonText = 'Choose Plan';
            $isDisabled = false;
        }

        $planStatuses[] = [
            'plan_id' => $plan['id'],
            'plan_name' => $plan['name'],
            'plan_amount' => $planAmount,
            'plan_duration' => $plan['duration'],
            'plan_duration_display' => formatDurationDisplay($plan['duration']),
            'plan_final_price' => round($planFinalPrice),
            'button_status' => $buttonStatus,
            'button_text' => $buttonText,
            'is_disabled' => $isDisabled
        ];
    }

    // Format current plan duration
    $currentPlanDurationDisplay = $userData['current_plan_duration'] ?
        formatDurationDisplay($userData['current_plan_duration']) : 'N/A';

    echo json_encode([
        "success" => true,
        "user_data" => [
            "user_id" => $user_id,
            "current_plan_id" => $userData['plan_id'],
            "current_plan_name" => $userData['current_plan_name'] ?? 'No Plan',
            "current_plan_amount" => $currentPlanAmount,
            "current_plan_duration" => $userData['current_plan_duration'] ?? 0,
            "current_plan_duration_display" => $currentPlanDurationDisplay,
            "current_plan_final_price" => round($currentPlanFinalPrice),
            "expires_on" => $userData['expires_on'],
            "expires_on_date" => $userData['expires_on'] ? date('d M Y', strtotime($userData['expires_on'])) : 'N/A'
        ],
        "plan_statuses" => $planStatuses
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>