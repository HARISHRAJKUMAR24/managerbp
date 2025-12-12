<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Content-Type: application/json");

require __DIR__ . "/../../../config/config.php";

$conn = getDbConnection();

// If ID is provided → return single event
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            echo json_encode([
                "success" => false,
                "message" => "Event not found"
            ]);
            exit;
        }

        // Decode JSON fields
        $event["things_to_know"] = json_decode($event["things_to_know"] ?? "[]", true);
        $event["videos"] = json_decode($event["videos"] ?? "[]", true);

        echo json_encode([
            "success" => true,
            "data" => $event
        ]);
        exit;

    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
        exit;
    }
}

// Otherwise → return all events
try {
    $stmt = $conn->prepare("SELECT * FROM events ORDER BY id DESC");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $events
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
