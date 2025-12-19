<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") exit();

require "../../../config/config.php";
require "../../../src/database.php";

$pdo = getDbConnection();

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) $data = [];

/* verify token */
$token = $data["token"] ?? "";
$stmt = $pdo->prepare("SELECT * FROM users WHERE api_token=? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetchObject();

if (!$user) {
    echo json_encode(["success"=>false,"message"=>"Invalid token"]);
    exit();
}

$user_id = $user->user_id;

/* required doctor fields */
$doctor_name = trim($data["doctor_name"] ?? "");
$category_id = trim($data["category_id"] ?? "");
$image = trim($data["image"] ?? "");

if ($doctor_name=="" || $category_id=="" || $image=="") {
    echo json_encode(["success"=>false,"message"=>"doctor_name, category_id & image required"]);
    exit();
}

/* optional fields */
$specialization = $data["specialization"] ?? null;
$qualification  = $data["qualification"] ?? null;
$experience     = $data["experience"] ?? null;
$reg_number     = $data["reg_number"] ?? null;

/* insert doctor row */
$sql = "INSERT INTO doctors 
(user_id, category_id, doctor_name, specialization, qualification, experience, reg_number, doctor_image, created_at)
VALUES (:uid, :cid, :name, :spec, :qual, :exp, :reg, :img, NOW(3))";


$stmt2 = $pdo->prepare($sql);

$ok = $stmt2->execute([
  ":uid"=>$user_id,
  ":cid"=>$category_id,
  ":name"=>$doctor_name,
  ":spec"=>$specialization,
  ":qual"=>$qualification,
  ":exp"=>$experience,
  ":reg"=>$reg_number,
  ":img"=>$image
]);

echo json_encode([
    "success"=>$ok,
    "message"=>$ok?"Doctor added":"Failed"
]);
exit();
