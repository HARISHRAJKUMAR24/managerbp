<?php  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../config.php';

$id = $_GET['id'];
$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare("
  UPDATE events SET
    title=?, description=?, date=?, organizer=?, category=?, info=?, comfort=?, 
    things_to_know=?, videos=?, logo=?, banner=?, country=?, state=?, city=?, 
    pincode=?, address=?, map_link=?, terms=?, seat_layout=?
  WHERE id=?
");

$stmt->bind_param(
  "ssssssssssssssssssss",
  $data['title'],
  $data['description'],
  $data['date'],
  $data['organizer'],
  $data['category'],
  $data['info'],
  $data['comfort'],
  json_encode($data['things_to_know']),
  json_encode($data['videos']),
  $data['logo'],
  $data['banner'],
  $data['country'],
  $data['state'],
  $data['city'],
  $data['pincode'],
  $data['address'],
  $data['map_link'],
  $data['terms'],
  $data['seat_layout'],
  $id
);

if ($stmt->execute()) {
  echo json_encode(["success" => true, "message" => "Event updated!"]);
} else {
  echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
