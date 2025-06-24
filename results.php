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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bus Search Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Bus Search Results</h1>
        <a href="index.html" class="inline-block mb-4 text-blue-600 hover:underline"><i class="fas fa-arrow-left"></i> Back to Search</a>
        <?php if ($result->num_rows > 0): ?>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="border border-gray-300 px-4 py-2 text-left">Bus Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Timing</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Route</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Location (Lat, Long)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="border border-gray-300 hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($row['bus_name']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($row['timing']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo nl2br(htmlspecialchars($row['route'])); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($row['latitude']) . ', ' . htmlspecialchars($row['longitude']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-red-600">No buses found for the given source and destination.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>
