<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

require_once "../../../../config/config.php";
require_once "../../../../src/database.php";

$pdo = getDbConnection();

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data["user_id"] ?? null;
$meta_title = $data["meta_title"] ?? null;
$meta_description = $data["meta_description"] ?? null;
$sharing_image_preview = $data["sharing_image_preview"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID missing"]);
    exit();
}

try {
    // Check if site_settings row exists
    $checkStmt = $pdo->prepare("SELECT id FROM site_settings WHERE user_id = :user_id");
    $checkStmt->execute([":user_id" => $user_id]);
    $exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        // UPDATE existing SEO settings
        $sql = "UPDATE site_settings SET
                    meta_title = :mt,
                    meta_description = :md,
                    sharing_image_preview = :sip
                WHERE user_id = :uid";
    } else {
        // INSERT new SEO settings
        $sql = "INSERT INTO site_settings
                (user_id, meta_title, meta_description, sharing_image_preview)
                VALUES
                (:uid, :mt, :md, :sip)";
    }

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":uid" => $user_id,
        ":mt"  => $meta_title,
        ":md"  => $meta_description,
        ":sip" => $sharing_image_preview,
    ]);

    echo json_encode([
        "success" => true,
        "message" => "SEO settings updated successfully",
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>
