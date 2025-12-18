<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();

/* ----------------------------------------------------
   READ JSON BODY
-----------------------------------------------------*/
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!is_array($data)) $data = [];

/* ----------------------------------------------------
   GET TOKEN
-----------------------------------------------------*/
$token = $data["token"] ?? ($_COOKIE["token"] ?? "");

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing token"]);
    exit();
}

/* ----------------------------------------------------
   VALIDATE USER USING TOKEN
-----------------------------------------------------*/
$stmt = $pdo->prepare("SELECT * FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetchObject();

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit();
}

$user_id = $user->user_id;

/* ----------------------------------------------------
   VALIDATE REQUIRED FIELDS
-----------------------------------------------------*/
$name = trim($data["name"] ?? "");
$slug = trim($data["slug"] ?? "");
$image = trim($data["image"] ?? "");

if ($name === "" || $slug === "") {
    echo json_encode(["success" => false, "message" => "Name & slug required"]);
    exit();
}

/* ----------------------------------------------------
   OPTIONAL FIELDS
-----------------------------------------------------*/
$meta_title = $data["meta_title"] ?? null;
$meta_desc  = $data["meta_description"] ?? null;

/* ----------------------------------------------------
   DOCTOR FIELDS (optional)
-----------------------------------------------------*/
$doctorDetails = $data["doctor_details"] ?? null;

/* ----------------------------------------------------
   GENERATE CATEGORY ID
-----------------------------------------------------*/
$category_id = "CAT_" . uniqid();

/* ----------------------------------------------------
   INSERT INTO CATEGORIES TABLE
-----------------------------------------------------*/
$sql = "INSERT INTO categories 
        (category_id, user_id, name, slug, image, meta_title, meta_description, created_at)
        VALUES (:cid, :uid, :name, :slug, :image, :mtitle, :mdesc, NOW(3))";

$stmt = $pdo->prepare($sql);
$ok = $stmt->execute([
    ":cid"   => $category_id,
    ":uid"   => $user_id,
    ":name"  => $name,
    ":slug"  => $slug,
    ":image" => $image,
    ":mtitle" => $meta_title,
    ":mdesc"  => $meta_desc
]);

if (!$ok) {
    echo json_encode([
        "success" => false,
        "message" => "Category insert failed"
    ]);
    exit();
}

/* ----------------------------------------------------
   GET LAST INSERTED CATEGORY ID (FK for doctors)
-----------------------------------------------------*/
$category_insert_id = $pdo->lastInsertId();

/* ----------------------------------------------------
   INSERT INTO DOCTORS TABLE (if doctor data exists)
-----------------------------------------------------*/
if ($doctorDetails) {
    
    $sql2 = "INSERT INTO doctors 
            (category_id, doctor_name, specialization, qualification, experience, reg_number, created_at) 
            VALUES (:cid, :dname, :spec, :qual, :exp, :reg, NOW(3))";

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([
        ":cid"  => $category_insert_id,
        ":dname" => $doctorDetails["doctor_name"] ?? null,
        ":spec" => $doctorDetails["specialization"] ?? null,
        ":qual" => $doctorDetails["qualification"] ?? null,
        ":exp"  => $doctorDetails["experience"] ?? null,
        ":reg"  => $doctorDetails["reg_number"] ?? null,
    ]);
}

/* ----------------------------------------------------
   RESPONSE
-----------------------------------------------------*/
echo json_encode([
    "success" => true,
    "message" => "Category + Doctor inserted successfully",
    "category_id" => $category_id
]);
exit();
?>
