<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

$debugFile = __DIR__ . "/debug_add_event.txt";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

/* -----------------------------------------------
   Load DB Config (PDO)
------------------------------------------------*/
$configPath = __DIR__ . "/../../../config/config.php";
file_put_contents($debugFile, "LOADING CONFIG...\n", FILE_APPEND);

require $configPath;

$conn = getDbConnection();
file_put_contents($debugFile, "PDO CONNECTED\n", FILE_APPEND);

/* -----------------------------------------------
   Read JSON Input
------------------------------------------------*/
$raw = file_get_contents("php://input");
file_put_contents($debugFile, "RAW:\n$raw\n\n", FILE_APPEND);

$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid or empty JSON"]);
    exit;
}

file_put_contents($debugFile, "DECODED:\n" . print_r($data, true) . "\n", FILE_APPEND);

/* -----------------------------------------------
   Extract Fields
------------------------------------------------*/
$user_id     = intval($data['user_id'] ?? 0);
$title       = $data['title'] ?? "";
$description = $data['description'] ?? "";
$date        = $data['date'] ?? "";
$start_time  = $data['start_time'] ?? "";
$end_time    = $data['end_time'] ?? "";

$location = !empty($data['address'])
    ? $data['address']
    : (($data['city'] ?? "") . ", " . ($data['state'] ?? ""));

$organizer   = $data['organizer'] ?? "";
$category    = $data['category'] ?? "";
$banner      = $data['banner'] ?? "";
$logo        = $data['logo'] ?? "";
$country     = $data['country'] ?? "";
$state       = $data['state'] ?? "";
$city        = $data['city'] ?? "";
$pincode     = $data['pincode'] ?? "";
$address     = $data['address'] ?? "";
$map_link    = $data['map_link'] ?? "";
$comfort     = $data['comfort'] ?? "";
$terms       = $data['terms'] ?? "";
$seat_layout = $data['seat_layout'] ?? "";

$things_json = json_encode($data['things_to_know'] ?? []);
$videos_json = json_encode($data['videos'] ?? []);

/* -----------------------------------------------
   SQL INSERT WITHOUT STATUS (auto defaults on DB)
   EXACTLY 22 placeholders
------------------------------------------------*/
$sql = "INSERT INTO events (
    user_id,
    title,
    description,
    date,
    start_time,
    end_time,
    location,
    organizer,
    category,
    banner,
    logo,
    country,
    state,
    city,
    pincode,
    address,
    map_link,
    comfort,
    things_to_know,
    terms,
    videos,
    seat_layout
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)";

file_put_contents($debugFile, "SQL TEMPLATE OK (22 placeholders)\n", FILE_APPEND);

/* -----------------------------------------------
   EXECUTE PDO QUERY
------------------------------------------------*/
try {
    $stmt = $conn->prepare($sql);

    $params = [
        $user_id,     // 1
        $title,       // 2
        $description, // 3
        $date,        // 4
        $start_time,  // 5
        $end_time,    // 6
        $location,    // 7
        $organizer,   // 8
        $category,    // 9
        $banner,      // 10
        $logo,        // 11
        $country,     // 12
        $state,       // 13
        $city,        // 14
        $pincode,     // 15
        $address,     // 16
        $map_link,    // 17
        $comfort,     // 18
        $things_json, // 19
        $terms,       // 20
        $videos_json, // 21
        $seat_layout  // 22
    ];

    file_put_contents($debugFile, "PARAM COUNT=" . count($params) . "\n", FILE_APPEND);

    $ok = $stmt->execute($params);

    if ($ok) {
        $id = $conn->lastInsertId();
        file_put_contents($debugFile, "INSERT SUCCESS — ID=$id\n", FILE_APPEND);

        echo json_encode([
            "success" => true,
            "message" => "Event created!",
            "id" => $id
        ]);
        exit;
    } else {
        $err = $stmt->errorInfo();
        file_put_contents($debugFile, "EXEC ERROR:\n" . print_r($err, true), FILE_APPEND);

        echo json_encode(["success" => false, "message" => "Insert failed", "error" => $err]);
        exit;
    }

} catch (Exception $e) {
    file_put_contents($debugFile, "EXCEPTION:\n" . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
}

?>
