<?php
/* include COMMON HEADER above */

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid ID"
    ]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, name, instructions, icon, image
    FROM manual_payment_methods
    WHERE id = ? AND user_id = ?
    LIMIT 1
");

$stmt->execute([$id, $user_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Not found"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);
