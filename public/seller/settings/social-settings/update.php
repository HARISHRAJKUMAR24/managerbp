<?php
// seller/settings/social-settings/update.php
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

// Prepare data with sanitization
$facebook = isset($data['facebook']) ? trim($data['facebook']) : null;
$twitter = isset($data['twitter']) ? trim($data['twitter']) : null;
$instagram = isset($data['instagram']) ? trim($data['instagram']) : null;
$linkedin = isset($data['linkedin']) ? trim($data['linkedin']) : null;
$youtube = isset($data['youtube']) ? trim($data['youtube']) : null;
$pinterest = isset($data['pinterest']) ? trim($data['pinterest']) : null;

// Add https:// prefix if missing but URL exists
function formatUrl($url)
{
    if ($url === null || trim($url) === '') {
        return null;
    }

    $url = trim($url);

    if (!empty($url) && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
        return "https://" . $url;
    }

    return $url;
}

// Format URLs
$facebook = formatUrl($facebook);
$twitter = formatUrl($twitter);
$instagram = formatUrl($instagram);
$linkedin = formatUrl($linkedin);
$youtube = formatUrl($youtube);
$pinterest = formatUrl($pinterest);

// Check if settings already exist for user
$checkSql = "SELECT COUNT(*) FROM site_settings WHERE user_id = :user_id";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([':user_id' => $user_id]);
$exists = $checkStmt->fetchColumn() > 0;

try {
    if ($exists) {
        // Update existing record - only social fields
        $sql = "UPDATE site_settings 
                SET facebook = :facebook,
                    twitter = :twitter,
                    instagram = :instagram,
                    linkedin = :linkedin,
                    youtube = :youtube,
                    pinterest = :pinterest
                WHERE user_id = :user_id";
    } else {
        // SIMPLIFIED INSERT: Only specify the columns we're providing
        // Other columns will use their DEFAULT values or NULL
        $sql = "INSERT INTO site_settings 
                (user_id, facebook, twitter, instagram, linkedin, youtube, pinterest) 
                VALUES (:user_id, :facebook, :twitter, :instagram, :linkedin, :youtube, :pinterest)";
    }

    $stmt = $pdo->prepare($sql);

    // Execute with parameters (same parameters for both INSERT and UPDATE)
    $result = $stmt->execute([
        ':user_id' => $user_id,
        ':facebook' => $facebook,
        ':twitter' => $twitter,
        ':instagram' => $instagram,
        ':linkedin' => $linkedin,
        ':youtube' => $youtube,
        ':pinterest' => $pinterest
    ]);

    if ($result) {
        echo json_encode([
            "success" => true,
            "message" => "Social settings updated successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update social settings"
        ]);
    }
} catch (PDOException $e) {
    error_log("Database error in update.php: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Database error occurred: " . $e->getMessage()
    ]);
}
