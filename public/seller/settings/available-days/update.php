<?php
// seller/settings/available-days/update.php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

try {
    $pdo = getDbConnection();
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit();
}

// Get JSON input
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Get user ID
$user_id = $data['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "success" => false, 
        "message" => "User ID required"
    ]);
    exit();
}

// Function to convert 12-hour AM/PM to 24-hour format with validation
function convertTo24Hour($time) {
    if (empty($time) || $time === null || $time === '') {
        return null;
    }
    
    $time = trim($time);
    
    // If empty string, return null
    if ($time === '') {
        return null;
    }
    
    // If already in 24-hour format (HH:MM), return as is
    if (preg_match('/^\d{1,2}:\d{2}$/', $time)) {
        $parts = explode(':', $time);
        $hour = (int)$parts[0];
        $minute = $parts[1];
        
        // Validate
        if ($hour >= 0 && $hour <= 23 && $minute >= 0 && $minute <= 59) {
            return sprintf('%02d:%02d', $hour, $minute);
        }
        return null;
    }
    
    // Remove extra spaces and convert to uppercase
    $time = strtoupper(preg_replace('/\s+/', ' ', $time));
    
    // Check for AM/PM format
    if (preg_match('/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i', $time, $matches)) {
        $hour = (int)$matches[1];
        $minute = $matches[2];
        $period = strtoupper($matches[3]);
        
        // Validate hour (1-12 for AM/PM)
        if ($hour < 1 || $hour > 12) {
            return null;
        }
        
        // Validate minute (0-59)
        if ($minute < 0 || $minute > 59) {
            return null;
        }
        
        // Convert to 24-hour format
        if ($period === 'PM' && $hour < 12) {
            $hour += 12;
        } elseif ($period === 'AM' && $hour === 12) {
            $hour = 0;
        }
        
        return sprintf('%02d:%02d', $hour, $minute);
    }
    
    // Check for format without colon (e.g., 8AM, 8:00AM)
    if (preg_match('/^(\d{1,2})(?::(\d{2}))?\s*(AM|PM)$/i', $time, $matches)) {
        $hour = (int)$matches[1];
        $minute = isset($matches[2]) ? $matches[2] : '00';
        $period = strtoupper($matches[3]);
        
        // Validate hour (1-12 for AM/PM)
        if ($hour < 1 || $hour > 12) {
            return null;
        }
        
        // Validate minute (0-59)
        if ($minute < 0 || $minute > 59) {
            return null;
        }
        
        // Convert to 24-hour format
        if ($period === 'PM' && $hour < 12) {
            $hour += 12;
        } elseif ($period === 'AM' && $hour === 12) {
            $hour = 0;
        }
        
        return sprintf('%02d:%02d', $hour, $minute);
    }
    
    return null; // Invalid format
}

// Prepare data - if day is disabled (0), set times to null
$sunday = isset($data['sunday']) ? (int)$data['sunday'] : 0;
$sunday_starts = $sunday ? (isset($data['sunday_starts']) ? convertTo24Hour($data['sunday_starts']) : null) : null;
$sunday_ends = $sunday ? (isset($data['sunday_ends']) ? convertTo24Hour($data['sunday_ends']) : null) : null;

$monday = isset($data['monday']) ? (int)$data['monday'] : 1;
$monday_starts = $monday ? (isset($data['monday_starts']) ? convertTo24Hour($data['monday_starts']) : null) : null;
$monday_ends = $monday ? (isset($data['monday_ends']) ? convertTo24Hour($data['monday_ends']) : null) : null;

$tuesday = isset($data['tuesday']) ? (int)$data['tuesday'] : 1;
$tuesday_starts = $tuesday ? (isset($data['tuesday_starts']) ? convertTo24Hour($data['tuesday_starts']) : null) : null;
$tuesday_ends = $tuesday ? (isset($data['tuesday_ends']) ? convertTo24Hour($data['tuesday_ends']) : null) : null;

$wednesday = isset($data['wednesday']) ? (int)$data['wednesday'] : 1;
$wednesday_starts = $wednesday ? (isset($data['wednesday_starts']) ? convertTo24Hour($data['wednesday_starts']) : null) : null;
$wednesday_ends = $wednesday ? (isset($data['wednesday_ends']) ? convertTo24Hour($data['wednesday_ends']) : null) : null;

$thursday = isset($data['thursday']) ? (int)$data['thursday'] : 1;
$thursday_starts = $thursday ? (isset($data['thursday_starts']) ? convertTo24Hour($data['thursday_starts']) : null) : null;
$thursday_ends = $thursday ? (isset($data['thursday_ends']) ? convertTo24Hour($data['thursday_ends']) : null) : null;

$friday = isset($data['friday']) ? (int)$data['friday'] : 1;
$friday_starts = $friday ? (isset($data['friday_starts']) ? convertTo24Hour($data['friday_starts']) : null) : null;
$friday_ends = $friday ? (isset($data['friday_ends']) ? convertTo24Hour($data['friday_ends']) : null) : null;

$saturday = isset($data['saturday']) ? (int)$data['saturday'] : 0;
$saturday_starts = $saturday ? (isset($data['saturday_starts']) ? convertTo24Hour($data['saturday_starts']) : null) : null;
$saturday_ends = $saturday ? (isset($data['saturday_ends']) ? convertTo24Hour($data['saturday_ends']) : null) : null;

try {
    // Check if settings already exist for user
    $checkSql = "SELECT COUNT(*) FROM site_settings WHERE user_id = :user_id";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([':user_id' => $user_id]);
    $exists = $checkStmt->fetchColumn() > 0;

    if ($exists) {
        // Update existing record
        $sql = "UPDATE site_settings 
                SET sunday = :sunday,
                    sunday_starts = :sunday_starts,
                    sunday_ends = :sunday_ends,
                    monday = :monday,
                    monday_starts = :monday_starts,
                    monday_ends = :monday_ends,
                    tuesday = :tuesday,
                    tuesday_starts = :tuesday_starts,
                    tuesday_ends = :tuesday_ends,
                    wednesday = :wednesday,
                    wednesday_starts = :wednesday_starts,
                    wednesday_ends = :wednesday_ends,
                    thursday = :thursday,
                    thursday_starts = :thursday_starts,
                    thursday_ends = :thursday_ends,
                    friday = :friday,
                    friday_starts = :friday_starts,
                    friday_ends = :friday_ends,
                    saturday = :saturday,
                    saturday_starts = :saturday_starts,
                    saturday_ends = :saturday_ends
                WHERE user_id = :user_id";
    } else {
        // Insert new record with default values for other fields
        $sql = "INSERT INTO site_settings 
                (user_id, 
                 sunday, sunday_starts, sunday_ends,
                 monday, monday_starts, monday_ends,
                 tuesday, tuesday_starts, tuesday_ends,
                 wednesday, wednesday_starts, wednesday_ends,
                 thursday, thursday_starts, thursday_ends,
                 friday, friday_starts, friday_ends,
                 saturday, saturday_starts, saturday_ends,
                 currency)
                VALUES 
                (:user_id,
                 :sunday, :sunday_starts, :sunday_ends,
                 :monday, :monday_starts, :monday_ends,
                 :tuesday, :tuesday_starts, :tuesday_ends,
                 :wednesday, :wednesday_starts, :wednesday_ends,
                 :thursday, :thursday_starts, :thursday_ends,
                 :friday, :friday_starts, :friday_ends,
                 :saturday, :saturday_starts, :saturday_ends,
                 'INR')";
    }

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':user_id' => $user_id,
        
        ':sunday' => $sunday,
        ':sunday_starts' => $sunday_starts,
        ':sunday_ends' => $sunday_ends,
        
        ':monday' => $monday,
        ':monday_starts' => $monday_starts,
        ':monday_ends' => $monday_ends,
        
        ':tuesday' => $tuesday,
        ':tuesday_starts' => $tuesday_starts,
        ':tuesday_ends' => $tuesday_ends,
        
        ':wednesday' => $wednesday,
        ':wednesday_starts' => $wednesday_starts,
        ':wednesday_ends' => $wednesday_ends,
        
        ':thursday' => $thursday,
        ':thursday_starts' => $thursday_starts,
        ':thursday_ends' => $thursday_ends,
        
        ':friday' => $friday,
        ':friday_starts' => $friday_starts,
        ':friday_ends' => $friday_ends,
        
        ':saturday' => $saturday,
        ':saturday_starts' => $saturday_starts,
        ':saturday_ends' => $saturday_ends,
    ]);

    if ($result) {
        echo json_encode([
            "success" => true,
            "message" => "Business hours updated successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update business hours"
        ]);
    }
} catch (PDOException $e) {
    error_log("Database error in update.php: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Database error occurred: " . $e->getMessage()
    ]);
}