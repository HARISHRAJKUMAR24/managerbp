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

/* --------------------------------------
   READ JSON BODY
---------------------------------------*/
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!is_array($data)) $data = [];

/* --------------------------------------
   GET TOKEN + USER
---------------------------------------*/
$token = $data["token"] ?? ($_COOKIE["token"] ?? "");

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing token"]);
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetchObject();

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit();
}

$user_id = $user->user_id;

/* --------------------------------------
   GET CATEGORY FIELDS
--------------------------------------*/
$name = trim($data["name"] ?? "");
$slug = trim($data["slug"] ?? "");

if ($name === "" || $slug === "") {
    echo json_encode(["success" => false, "message" => "Name & slug required"]);
    exit();
}

$image = $data["image"] ?? ""; // category image ONLY if exists

$meta_title = $data["meta_title"] ?? null;
$meta_desc  = $data["meta_description"] ?? null;

/* --------------------------------------
   AUTO CATEGORY CODE
--------------------------------------*/
$category_id = "CAT_" . uniqid();

/* --------------------------------------
   INSERT CATEGORY ONLY
--------------------------------------*/
$sql = "INSERT INTO categories 
(category_id, user_id, name, slug, meta_title, meta_description, created_at)
VALUES (:cid, :uid, :name, :slug, :mtitle, :mdesc, NOW(3))";

$stmt = $pdo->prepare($sql);

$ok = $stmt->execute([
    ":cid"   => $category_id,
    ":uid"   => $user_id,
    ":name"  => $name,
    ":slug"  => $slug,
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

/* --------------------------------------
   SUCCESS RESPONSE
--------------------------------------*/
/* --------------------------------------
   GET AUTO DB ID
--------------------------------------*/
$lastId = $pdo->lastInsertId();

/* --------------------------------------
   SUCCESS RESPONSE
--------------------------------------*/
$lastId = $pdo->lastInsertId();

echo json_encode([
    "success" => true,
    "message" => "Category created successfully",
    "category_id" => $category_id, // string code
    "id" => $lastId,               // Auto increment id integer
]);
exit();


?>
