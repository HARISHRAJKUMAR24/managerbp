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

$category_id = $_GET['category_id'] ?? '';

if (!$category_id) {
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

/* -----------------------------
    UPDATE CATEGORY TABLE
------------------------------*/
$fields = [];
$params = [];

foreach ($data as $key => $value) {
    $fields[] = "$key = ?";
    $params[] = $value ?? null;
}

$params[] = $category_id;

$sql = "UPDATE categories SET " . implode(", ", $fields) . " WHERE category_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

/* -----------------------------
   UPDATE DOCTOR TABLE
------------------------------*/
if ($doctorDetails) {

    // check doctor exists
    $check = $pdo->prepare("SELECT id FROM doctors WHERE category_id = ? LIMIT 1");
    $check->execute([$category_id]);
    $doctorExists = $check->fetchColumn();

    if ($doctorExists) {
        $sql2 = "UPDATE doctors 
                 SET doctor_name=?, specialization=?, qualification=?, experience=?, reg_number=?, doctor_image=?
                 WHERE category_id=?";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([
            $doctorDetails["doctor_name"] ?? null,
            $doctorDetails["specialization"] ?? null,
            $doctorDetails["qualification"] ?? null,
            $doctorDetails["experience"] ?? null,
            $doctorDetails["reg_number"] ?? null,
            $doctorDetails["doctor_image"] ?? null,
            $category_id                           // FIXED foreign key
        ]);

    } else {
        $sql3 = "INSERT INTO doctors 
                (category_id, doctor_name, specialization, qualification, experience, reg_number, doctor_image)
                VALUES (?,?,?,?,?,?,?)";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute([
            $category_id,
            $doctorDetails["doctor_name"] ?? null,
            $doctorDetails["specialization"] ?? null,
            $doctorDetails["qualification"] ?? null,
            $doctorDetails["experience"] ?? null,
            $doctorDetails["reg_number"] ?? null,
            $doctorDetails["doctor_image"] ?? null
        ]);
    }
}

echo json_encode([
    "success" => true,
    "message" => "Category & Doctor updated successfully"
]);
exit();
