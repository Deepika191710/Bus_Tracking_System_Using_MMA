<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_tracking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$source = isset($_GET['source']) ? $conn->real_escape_string($_GET['source']) : '';
$destination = isset($_GET['destination']) ? $conn->real_escape_string($_GET['destination']) : '';

$sourceResult = $conn->query("SELECT stop_id FROM stop WHERE stop_name = '$source'");
$destinationResult = $conn->query("SELECT stop_id FROM stop WHERE stop_name = '$destination'");

if ($sourceResult->num_rows === 0 || $destinationResult->num_rows === 0) {
    echo "Invalid source or destination stop.";
    exit;
}

$source_id = $sourceResult->fetch_assoc()['stop_id'];
$destination_id = $destinationResult->fetch_assoc()['stop_id'];

$sql = "
SELECT r.route_id, r.route_name, b.bus_name, b.bus_mode, b.seating_arrangement, bs.start_time
FROM route r
JOIN route_stop rs1 ON r.route_id = rs1.route_id AND rs1.stop_id = $source_id
JOIN route_stop rs2 ON r.route_id = rs2.route_id AND rs2.stop_id = $destination_id
JOIN bus_schedule bs ON bs.route_id = r.route_id
JOIN bus b ON bs.bus_id = b.bus_id
WHERE rs1.stop_order < rs2.stop_order
ORDER BY bs.start_time
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bus Search Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f0f4ff, #e0ecff);
        }

        @keyframes slideFade {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-fade {
            animation: slideFade 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in > li {
            opacity: 0;
            animation: fadeIn 0.6s ease forwards;
        }

        .animate-fade-in > li:nth-child(1) { animation-delay: 0.1s; }
        .animate-fade-in > li:nth-child(2) { animation-delay: 0.2s; }
        .animate-fade-in > li:nth-child(3) { animation-delay: 0.3s; }
        .animate-fade-in > li:nth-child(4) { animation-delay: 0.4s; }
        .animate-fade-in > li:nth-child(5) { animation-delay: 0.5s; }
        .animate-fade-in > li:nth-child(6) { animation-delay: 0.6s; }
        .animate-fade-in > li:nth-child(7) { animation-delay: 0.7s; }
    </style>
</head>
<body class="min-h-screen p-6">

<div class="max-w-5xl mx-auto bg-white p-8 rounded-2xl shadow-2xl animate-slide-fade transition-all">
    <h1 class="text-3xl font-bold text-blue-700 mb-4">
        <i class="fas fa-bus mr-2 text-blue-500"></i>
        Bus Results: <?= htmlspecialchars($source) ?> → <?= htmlspecialchars($destination) ?>
    </h1>

    <a href="index.html" class="inline-block mb-6 text-sm text-blue-600 hover:underline">
        ← Back to Search
    </a>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="mb-10 border border-blue-200 bg-white rounded-xl p-6 shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                    <i class="fas fa-bus-alt text-green-600 mr-2"></i>
                    <?= htmlspecialchars($row['bus_name']) ?> <span class="text-sm text-gray-600">[<?= htmlspecialchars($row['bus_mode']) ?>]</span>
                </h2>

                <p class="text-sm text-gray-700 mb-1"><strong>Seating:</strong> <?= htmlspecialchars($row['seating_arrangement']) ?></p>
                <p class="text-sm text-gray-700 mb-1"><strong>Departure:</strong> <i class="far fa-clock text-blue-500"></i> <?= htmlspecialchars($row['start_time']) ?></p>
                <p class="text-sm text-gray-700"><strong>Route:</strong>
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                        <?= htmlspecialchars($row['route_name']) ?>
                    </span>
                </p>

                <?php
                $route_id = $row['route_id'];
                $stopsQuery = "
                    SELECT s.stop_name
                    FROM route_stop rs
                    JOIN stop s ON rs.stop_id = s.stop_id
                    WHERE rs.route_id = $route_id
                    ORDER BY rs.stop_order
                ";
                $stopsResult = $conn->query($stopsQuery);
                if ($stopsResult && $stopsResult->num_rows > 0):
                    echo "<div class='mt-4'>";
                    echo "<h3 class='text-md font-bold text-gray-800 mb-2'><i class='fas fa-map-marked-alt text-purple-500 mr-2'></i>Stops on Route:</h3>";
                    echo "<ul class='space-y-2 animate-fade-in'>";
                    while ($stopRow = $stopsResult->fetch_assoc()):
                        echo "<li class='bg-gradient-to-r from-white to-blue-50 rounded px-4 py-2 shadow-sm border-l-4 border-blue-400 transition duration-300 hover:shadow-md'>";
                        echo "<i class='fas fa-map-marker-alt text-blue-600 mr-2'></i>" . htmlspecialchars($stopRow['stop_name']);
                        echo "</li>";
                    endwhile;
                    echo "</ul></div>";
                else:
                    echo "<p>No stops found.</p>";
                endif;
                ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-red-600">No buses found for this route.</p>
    <?php endif; ?>
</div>

</body>
</html>
<?php $conn->close(); ?>
