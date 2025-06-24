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

$source_id = intval($_GET['source_id']);
$sql = "SELECT DISTINCT s.stop_id, s.stop_name
        FROM stop s
        JOIN route_stop rs ON s.stop_id = rs.stop_id
        WHERE s.stop_id != $source_id
        ORDER BY s.stop_name ASC";
$result = $conn->query($sql);

$destinations = [];
while ($row = $result->fetch_assoc()) {
    $destinations[] = $row;
}
header('Content-Type: application/json');
echo json_encode($destinations);
?>
