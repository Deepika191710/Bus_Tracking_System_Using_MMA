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
$destination_id = intval($_GET['destination_id']);

$sql = "
SELECT DISTINCT b.bus_id, b.bus_name
FROM bus b
JOIN bus_schedule bs ON b.bus_id = bs.bus_id
JOIN route r ON r.route_id = bs.route_id
JOIN route_stop rs1 ON rs1.route_id = r.route_id AND rs1.stop_id = $source_id
JOIN route_stop rs2 ON rs2.route_id = r.route_id AND rs2.stop_id = $destination_id
WHERE rs1.stop_order < rs2.stop_order
";

$result = $conn->query($sql);

$buses = [];
while ($row = $result->fetch_assoc()) {
    $buses[] = $row;
}
header('Content-Type: application/json');
echo json_encode($buses);
?>
