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

/* -----------------------------------------
   1️⃣ READ JSON BODY
------------------------------------------ */
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

/* SAFETY: ensure array */
if (!is_array($data)) $data = [];

/* -----------------------------------------
   2️⃣ GET TOKEN
------------------------------------------ */
$token = $data["token"] ?? ($_COOKIE["token"] ?? "");

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing token"]);
    exit();
}

/* -----------------------------------------
   3️⃣ VALIDATE USER USING TOKEN
------------------------------------------ */
$stmt = $pdo->prepare("SELECT * FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetchObject();

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit();
}

// ⭐ USE seller user_id — NOT primary key (id)
$user_id = $user->user_id;

/* -----------------------------------------
   4️⃣ VALIDATE REQUIRED FIELDS
------------------------------------------ */
$name = trim($data["name"] ?? "");
$slug = trim($data["slug"] ?? "");
$image = trim($data["image"] ?? "");

if ($name === "" || $slug === "") {
    echo json_encode(["success" => false, "message" => "Name & slug required"]);
    exit();
}

/* -----------------------------------------
   5️⃣ OPTIONAL FIELDS
------------------------------------------ */
$meta_title = $data["meta_title"] ?? null;
$meta_desc  = $data["meta_description"] ?? null;

/* -----------------------------------------
   6️⃣ GENERATE CATEGORY ID
------------------------------------------ */
$category_id = "CAT_" . uniqid();

/* -----------------------------------------
   7️⃣ INSERT INTO DB
------------------------------------------ */
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

echo json_encode([
    "success" => $ok,
    "message" => $ok ? "Category created successfully" : "Insert failed",
    "category_id" => $category_id
]);
exit();
?>
