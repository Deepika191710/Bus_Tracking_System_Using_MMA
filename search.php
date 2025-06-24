<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bustrack";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$source = isset($_GET['source']) ? $conn->real_escape_string($_GET['source']) : '';
$destination = isset($_GET['destination']) ? $conn->real_escape_string($_GET['destination']) : '';

$sql = "SELECT * FROM bus WHERE source = '$source' AND destination = '$destination'";
$result = $conn->query($sql);

$buses = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $buses[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($buses);
?>
