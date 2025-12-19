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

if ($name === "") {
    echo json_encode(["success" => false, "message" => "Department name is required"]);
    exit();
}

/* ----------------------------------------------------
   OPTIONAL FIELDS
-----------------------------------------------------*/
$type = trim($data["type"] ?? "");
$slug = trim($data["slug"] ?? "");
$image = trim($data["image"] ?? "");
$meta_title = $data["meta_title"] ?? null;
$meta_description = $data["meta_description"] ?? null;

/* ----------------------------------------------------
   GENERATE DEPARTMENT ID
-----------------------------------------------------*/
$department_id = "DEPT_" . uniqid();

/* ----------------------------------------------------
   INSERT INTO DEPARTMENTS TABLE
-----------------------------------------------------*/
$sql = "INSERT INTO departments 
        (department_id, user_id, name, type, slug, image, meta_title, meta_description, created_at)
        VALUES (:did, :uid, :name, :type, :slug, :image, :mtitle, :mdesc, NOW(3))";

$stmt = $pdo->prepare($sql);
$ok = $stmt->execute([
    ":did"    => $department_id,
    ":uid"    => $user_id,
    ":name"   => $name,
    ":type"   => $type ?: null,
    ":slug"   => $slug ?: null,
    ":image"  => $image ?: null,
    ":mtitle" => $meta_title,
    ":mdesc"  => $meta_description
]);

if (!$ok) {
    echo json_encode([
        "success" => false,
        "message" => "Department insert failed"
    ]);
    exit();
}

/* ----------------------------------------------------
   RESPONSE
-----------------------------------------------------*/
echo json_encode([
    "success" => true,
    "message" => "Department created successfully",
    "department_id" => $department_id
]);
exit();
?>