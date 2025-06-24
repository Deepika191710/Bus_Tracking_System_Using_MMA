<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "bus_tracking";

// Connect to database
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed: " . $conn->connect_error;
    exit;
}

// Get lat, lng, bus_id from POST or GET
$bus_id = $_POST['bus_id'] ?? $_GET['bus_id'] ?? null;
$lat = $_POST['lat'] ?? $_GET['lat'] ?? null;
$lng = $_POST['lng'] ?? $_GET['lng'] ?? null;

// Validate inputs
if ($bus_id && $lat && $lng) {
    // Prepare and execute SQL
    $stmt = $conn->prepare("INSERT INTO gets_data (bus_id, lat, lng, timestamp) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("idd", $bus_id, $lat, $lng);
    
    if ($stmt->execute()) {
        echo "Location saved successfully";
    } else {
        echo "Error saving location: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing required parameters.";
}

$conn->close();
?>
