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

$category_id = $_GET['category_id'] ?? '';

if (!$category_id) {
    echo json_encode(["success" => false, "message" => "Category ID missing"]);
    exit();
}

$baseImageUrl = "http://localhost/managerbp/public/uploads/";

/* -----------------------------------------
   FETCH CATEGORY 
----------------------------------------- */
$sql = "SELECT 
            id,
            category_id,
            user_id,
            name,
            slug,
            meta_title,
            meta_description,
            created_at
        FROM categories
        WHERE category_id = :cid
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':cid' => $category_id
]);





$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    echo json_encode(["success" => false, "message" => "Category not found"]);
    exit();
}

/* -----------------------------------------
   FETCH DOCTOR DATA
----------------------------------------- */
$sql2 = "SELECT
            doctor_name,
            specialization,
            qualification,
            experience,
            reg_number,
            doctor_image
         FROM doctors
         WHERE category_id = :cid
         LIMIT 1";

$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([':cid' => $category_id]);

$doctor = $stmt2->fetch(PDO::FETCH_ASSOC);

/* merge doctor */
$category["doctor_details"] = $doctor ?: null;

/* success response */
echo json_encode([
    "success" => true,
    "data" => $category
]);

exit();
