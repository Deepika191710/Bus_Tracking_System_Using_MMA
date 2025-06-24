<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_tracking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$source = isset($_GET['source']) ? $conn->real_escape_string($_GET['source']) : '';
$destination = isset($_GET['destination']) ? $conn->real_escape_string($_GET['destination']) : '';

if (!$source || !$destination) {
    echo "Source and Destination are required.";
    exit;
}

$sql = "
SELECT r.route_id, r.route_name, b.bus_name, b.bus_mode, b.seating_arrangement, bs.start_time
FROM route r
JOIN route_stop rs_source ON r.route_id = rs_source.route_id
JOIN route_stop rs_dest ON r.route_id = rs_dest.route_id
JOIN stop s_source ON rs_source.stop_id = s_source.stop_id
JOIN stop s_dest ON rs_dest.stop_id = s_dest.stop_id
JOIN bus_schedule bs ON bs.route_id = r.route_id
JOIN bus b ON bs.bus_id = b.bus_id
WHERE s_source.stop_name = '$source' 
  AND s_dest.stop_name = '$destination'
  AND rs_source.stop_order < rs_dest.stop_order
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #edf2fb, #dbeafe);
        }

        @keyframes slideFade {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-fade {
            animation: slideFade 1s ease-out forwards;
        }

        .glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glow-hover:hover {
            box-shadow: 0 4px 30px rgba(0, 0, 255, 0.1), 0 0 0 2px #3b82f6;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
        }

        .animate-fade-in > li {
            opacity: 0;
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen p-6">

<div class="max-w-5xl mx-auto glass p-10 rounded-3xl shadow-2xl animate-slide-fade">
    <h1 class="text-4xl font-bold text-blue-800 mb-4 tracking-tight">
        <i class="fas fa-route mr-3 text-indigo-500"></i>
        Buses from <span class="text-indigo-600"><?= htmlspecialchars($source) ?></span> to <span class="text-indigo-600"><?= htmlspecialchars($destination) ?></span>
    </h1>

    <a href="index_search.php" class="inline-block mb-6 text-base text-blue-500 hover:underline hover:text-blue-700 transition">
        ← Modify Search
    </a>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="mb-10 border border-blue-100 rounded-2xl p-6 bg-white/90 shadow-md hover:shadow-xl glow-hover transition-all duration-300">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        <i class="fas fa-bus text-green-600 mr-2"></i>
                        <?= htmlspecialchars($row['bus_name']) ?>
                    </h2>
                    <span class="badge bg-blue-100 text-blue-700 font-medium"><?= htmlspecialchars($row['bus_mode']) ?></span>
                </div>

                <p class="text-sm text-gray-700 mb-1"><strong>Seating:</strong> <?= htmlspecialchars($row['seating_arrangement']) ?></p>
                <p class="text-sm text-gray-700 mb-1"><strong>Departure:</strong> <i class="far fa-clock text-blue-400"></i> <?= htmlspecialchars($row['start_time']) ?></p>
                <p class="text-sm text-gray-700"><strong>Route:</strong>
                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full font-medium">
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
                    echo "<div class='mt-5'>";
                    echo "<h3 class='text-md font-bold text-gray-800 mb-2'><i class='fas fa-map-marker-alt text-purple-500 mr-2'></i>Stops on Route:</h3>";
                    echo "<ul class='space-y-2 animate-fade-in'>";
                    while ($stopRow = $stopsResult->fetch_assoc()):
                        echo "<li class='bg-gradient-to-r from-white to-blue-50 rounded px-4 py-2 shadow-sm border-l-4 border-indigo-400 transition hover:scale-105'>";
                        echo "<i class='fas fa-location-dot text-blue-600 mr-2'></i>" . htmlspecialchars($stopRow['stop_name']);
                        echo "</li>";
                    endwhile;
                    echo "</ul></div>";
                else:
                    echo "<p class='text-sm text-gray-600 mt-2'>No stops found.</p>";
                endif;
                ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-red-600 text-lg font-medium mt-6">No buses found for this route. Try another selection.</p>
    <?php endif; ?>
</div>

</body>
</html>
<?php $conn->close(); ?>
