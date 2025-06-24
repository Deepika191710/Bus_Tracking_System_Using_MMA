<?php
// Fetch stop list from the database
$conn = new mysqli("localhost", "root", "", "bus_tracking");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$stops = [];
$result = $conn->query("SELECT stop_name FROM stop ORDER BY stop_name ASC");
while ($row = $result->fetch_assoc()) {
    $stops[] = $row['stop_name'];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bus Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Bus Search</h1>
        <form id="searchForm" class="space-y-6" action="results5.php" method="GET">
            <div>
                <label for="source" class="block mb-1 font-medium">Select Source</label>
                <select id="source" name="source" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Source Stop --</option>
                    <?php foreach ($stops as $stop): ?>
                        <option value="<?= htmlspecialchars($stop) ?>"><?= htmlspecialchars($stop) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="destination" class="block mb-1 font-medium">Select Destination</label>
                <select id="destination" name="destination" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Select Destination Stop --</option>
                    <?php foreach ($stops as $stop): ?>
                        <option value="<?= htmlspecialchars($stop) ?>"><?= htmlspecialchars($stop) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                <i class="fas fa-search mr-2"></i>Search Bus
            </button>
        </form>
        <a href="bus1.php" class="inline-block mt-6 text-blue-600 hover:underline">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </div>
</body>
</html>
