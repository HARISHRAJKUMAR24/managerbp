<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../config/config.php";
require_once "../../src/database.php";

$raw = file_get_contents("php://input");
$input = json_decode($raw, true);

$token = $input["token"] ?? "";

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing token"]);
    exit;
}

$pdo = getDbConnection();

// Fetch user by token
$stmt = $pdo->prepare("SELECT * FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetchObject();

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit;
}

// Fetch site settings (logo, favicon, etc)
$st = $pdo->prepare("SELECT * FROM site_settings WHERE user_id = :id LIMIT 1");
$st->execute([":id" => $user->id]);
$siteSettings = $st->fetch(PDO::FETCH_ASSOC);

$baseUrl = "http://localhost/managerbp/public/uploads/";

if ($siteSettings) {
    $siteSettings["logo_url"] = $siteSettings["logo"]
        ? $baseUrl . $siteSettings["logo"]
        : null;

    $siteSettings["favicon_url"] = $siteSettings["favicon"]
        ? $baseUrl . $siteSettings["favicon"]
        : null;

    $siteSettings["sharing_image_preview_url"] = $siteSettings["sharing_image_preview"]
        ? $baseUrl . $siteSettings["sharing_image_preview"]
        : null;
}

echo json_encode([
    "success" => true,
    "data" => [
        "id"        => (int)$user->id,
        "user_id"   => (int)$user->user_id,

        "name"      => $user->name,
        "email"     => $user->email,
        "phone"     => $user->phone,
        "country"   => $user->country,
        "image"     => $user->image,

        "siteSlug"  => $user->site_slug,
        "siteName"  => $user->site_name,

        // 🔥 THIS LINE FIXES EVERYTHING
        "service_type_id" => (int)$user->service_type_id,

        "siteSettings" => $siteSettings ?? []
    ]
]);
