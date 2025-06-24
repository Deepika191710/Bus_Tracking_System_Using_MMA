<?php
$bus_id = $_GET['bus_id'];
$conn = new mysqli("localhost", "root", "", "bus_tracking");

$sql = "
SELECT s.stop_name, s.latitude, s.longitude, rs.estimated_departure
FROM bus_schedule bs
JOIN route_stop rs ON bs.route_id = rs.route_id
JOIN stop s ON rs.stop_id = s.stop_id
WHERE bs.bus_id = ?
ORDER BY rs.stop_order
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bus_id);
$stmt->execute();
$result = $stmt->get_result();

$stops = [];
while ($row = $result->fetch_assoc()) {
    $stops[] = $row;
}
echo json_encode($stops);
?>
