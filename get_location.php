<?php
$conn = new mysqli("localhost", "root", "", "bus_tracking");
$result = $conn->query("SELECT lat, lng FROM gps_data ORDER BY timestamp DESC LIMIT 1");
echo json_encode($result->fetch_assoc());
?>
