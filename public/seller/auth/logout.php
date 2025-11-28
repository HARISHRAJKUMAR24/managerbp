<?php
setcookie(
    "token",
    "",
    time() - 3600,     // expire in the past
    "/",
    "localhost",
    false,
    true
);

echo json_encode([
  "success" => true,
  "message" => "Logged out"
]);
