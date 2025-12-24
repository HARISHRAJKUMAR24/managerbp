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
   FETCH MAIN DEPARTMENT DATA
----------------------------------------- */
$columns = "
    id,
    department_id,
    user_id,
    name,
    slug,
    type_main_name,
    type_main_amount,
    type_1_name,
    type_1_amount,
    type_2_name,
    type_2_amount,
    type_3_name,
    type_3_amount,
    type_4_name,
    type_4_amount,
    type_5_name,
    type_5_amount,
    type_6_name,
    type_6_amount,
    type_7_name,
    type_7_amount,
    type_8_name,
    type_8_amount,
    type_9_name,
    type_9_amount,
    type_10_name,
    type_10_amount,
    type_11_name,
    type_11_amount,
    type_12_name,
    type_12_amount,
    type_13_name,
    type_13_amount,
    type_14_name,
    type_14_amount,
    type_15_name,
    type_15_amount,
    type_16_name,
    type_16_amount,
    type_17_name,
    type_17_amount,
    type_18_name,
    type_18_amount,
    type_19_name,
    type_19_amount,
    type_20_name,
    type_20_amount,
    type_21_name,
    type_21_amount,
    type_22_name,
    type_22_amount,
    type_23_name,
    type_23_amount,
    type_24_name,
    type_24_amount,
    type_25_name,
    type_25_amount,
    CASE 
        WHEN image IS NULL OR image = '' 
            THEN NULL
        ELSE CONCAT(:base_url, image)
    END AS image,
    meta_title,
    meta_description,
    created_at,
     appointment_settings,
    updated_at
";

$sql = "SELECT $columns
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

/* -----------------------------------------
   FETCH ADDITIONAL IMAGES
----------------------------------------- */
$imgQuery = $pdo->prepare("
    SELECT image 
    FROM department_additional_images 
    WHERE department_id = ?
");
$imgQuery->execute([$department_id]);

$additionalImages = $imgQuery->fetchAll(PDO::FETCH_COLUMN);

// Convert to full URL
$additionalImages = array_map(function($img) use ($baseImageUrl) {
    return $baseImageUrl . $img;
}, $additionalImages);

/* -----------------------------------------
   CONVERT snake_case → camelCase
----------------------------------------- */
function toCamel($str) {
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
}

$final = [];

foreach ($department as $key => $value) {
    $camel = toCamel($key);
    $final[$camel] = $value;
}

$final["additionalImages"] = $additionalImages;

/* -----------------------------------------
   SEND RESPONSE
----------------------------------------- */
echo json_encode([
    "success" => true,
    "data" => $final
], JSON_UNESCAPED_SLASHES);

exit();
?>
