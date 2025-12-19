<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$department_id = $_GET['department_id'] ?? '';

if (!$department_id) {
    echo json_encode(["success" => false, "message" => "Department ID missing"]);
    exit();
}

$baseImageUrl = "http://localhost/managerbp/public/uploads/";

/* -----------------------------------------
   FETCH DEPARTMENT 
----------------------------------------- */
$sql = "SELECT 
            id,
            department_id,
            user_id,
            name,
            type,
            slug,
            CASE 
                WHEN image IS NULL OR image = '' 
                    THEN NULL
                ELSE CONCAT(:base_url, image)
            END AS image,
            meta_title,
            meta_description,
            created_at,
            updated_at
        FROM departments
        WHERE department_id = :did
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':did'      => $department_id,
    ':base_url' => $baseImageUrl
]);

$department = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$department) {
    echo json_encode(["success" => false, "message" => "Department not found"]);
    exit();
}

echo json_encode([
    "success" => true,
    "data" => $department
]);
exit();
?>