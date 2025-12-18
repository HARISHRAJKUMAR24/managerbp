<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

$category_uid = $_GET['category_id'] ?? '';

if (!$category_uid) {
    echo json_encode(["success" => false, "message" => "Category ID required"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    echo json_encode(["success" => false, "message" => "Invalid JSON"]);
    exit();
}

/* doctor values */
$doctorDetails = $data["doctor_details"] ?? null;

/* remove restricted fields */
unset($data["token"]);
unset($data["doctor_details"]);
unset($data["created_at"]);

/* find category primary key id */
$stmt = $pdo->prepare("SELECT id FROM categories WHERE category_id = ? LIMIT 1");
$stmt->execute([$category_uid]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    echo json_encode(["success" => false, "message" => "Category not found"]);
    exit();
}

$category_primary_id = $category["id"];

/* -----------------------------
    UPDATE CATEGORY TABLE
------------------------------*/
$fields = [];
$params = [];

foreach ($data as $key => $value) {
    $fields[] = "$key = ?";
    $params[] = $value ?? null;
}

$params[] = $category_uid;

$sql = "UPDATE categories SET " . implode(", ", $fields) . " WHERE category_id = ?";
$stmt = $pdo->prepare($sql);
$ok = $stmt->execute($params);

/* -----------------------------
   UPDATE DOCTOR TABLE
------------------------------*/
if ($doctorDetails) {

    // check doctor exists
    $check = $pdo->prepare("SELECT id FROM doctors WHERE category_id = ? LIMIT 1");
    $check->execute([$category_primary_id]);
    $doctorExists = $check->fetchColumn();

    if ($doctorExists) {
        // update doctor
        $sql2 = "UPDATE doctors SET doctor_name=?, specialization=?, qualification=?, experience=?, reg_number=? WHERE category_id=?";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([
            $doctorDetails["doctor_name"] ?? null,
            $doctorDetails["specialization"] ?? null,
            $doctorDetails["qualification"] ?? null,
            $doctorDetails["experience"] ?? null,
            $doctorDetails["reg_number"] ?? null,
            $category_primary_id
        ]);
    } else {
        // insert doctor if not exists
        $sql3 = "INSERT INTO doctors (category_id,doctor_name,specialization,qualification,experience,reg_number) VALUES (?,?,?,?,?,?)";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute([
            $category_primary_id,
            $doctorDetails["doctor_name"] ?? null,
            $doctorDetails["specialization"] ?? null,
            $doctorDetails["qualification"] ?? null,
            $doctorDetails["experience"] ?? null,
            $doctorDetails["reg_number"] ?? null
        ]);
    }
}

echo json_encode([
    "success" => true,
    "message" => "Category + Doctor updated successfully"
]);
exit();
?>
