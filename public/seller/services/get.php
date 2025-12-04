<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../../../config/config.php";
require_once "../../../src/database.php";

$pdo = getDbConnection();
$user_id = $_GET["user_id"];

$baseUrl = "http://localhost/managerbp/public/uploads/";

$sql = "SELECT *, 
        CASE WHEN image IS NULL OR image = '' THEN NULL 
             ELSE CONCAT('$baseUrl', image) END AS image
        FROM services 
        WHERE user_id = :uid 
        ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([":uid" => $user_id]);

echo json_encode([
    "success" => true,
    "records" => $stmt->fetchAll(PDO::FETCH_ASSOC)
]);
