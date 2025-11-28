<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../config/config.php";
require_once "../../src/database.php";

// ACCEPT TOKEN FROM COOKIE OR JSON
$raw = file_get_contents("php://input");
$input = json_decode($raw, true);

$token = $_COOKIE["token"] 
    ?? ($input["token"] ?? "");

if (!$token) {
    echo json_encode(["success" => false, "message" => "Missing token"]);
    exit;
}

$pdo = getDbConnection();
$stmt = $pdo->prepare("SELECT * FROM users WHERE api_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetchObject();

if (!$user) {
    echo json_encode(["success" => false, "message" => "Invalid token"]);
    exit;
}

echo json_encode([
    "success" => true,
    "data" => [
        "id"        => $user->id,
        "name"      => $user->name,
        "email"     => $user->email,
        "phone"     => $user->phone,
        "country"   => $user->country,
        "image"     => $user->image,
        "siteSlug"  => $user->site_slug,
        "siteName"  => $user->site_name,
    ]
]);
