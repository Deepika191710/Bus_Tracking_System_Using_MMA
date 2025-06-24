<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "bus_tracking";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

$sql = "SELECT stop_id, stop_name FROM stop ORDER BY stop_name ASC";
$result = $conn->query($sql);

$stops = [];
while ($row = $result->fetch_assoc()) {
    $stops[] = $row;
}
header('Content-Type: application/json');
echo json_encode($stops);
?>
