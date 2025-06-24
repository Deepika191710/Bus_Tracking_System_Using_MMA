<?php
$bus_id = $_GET['bus_id'];

$conn = new mysqli("localhost", "root", "", "bus_tracking");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT lat, lng FROM gets_data WHERE bus_id = ? ORDER BY timestamp DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bus_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['lat' => $row['lat'], 'lng' => $row['lng']]);
} else {
    echo json_encode(['error' => 'No GPS data']);
}
$stmt->close();
$conn->close();
?>
