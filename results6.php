<body class="min-h-screen p-6 overflow-x-hidden">

<div class="max-w-7xl mx-auto glass p-10 rounded-3xl shadow-2xl animate-slide-fade">
    <h1 class="text-4xl font-bold text-blue-800 mb-4 tracking-tight">
        <i class="fas fa-route mr-3 text-indigo-500"></i>
        Buses from <span class="text-indigo-600"><?= htmlspecialchars($source) ?></span> to <span class="text-indigo-600"><?= htmlspecialchars($destination) ?></span>
    </h1>

    <a href="index.html" class="inline-block mb-6 text-base text-blue-500 hover:underline hover:text-blue-700 transition">
        ← Modify Search
    </a>

    <?php if ($result && $result->num_rows > 0): ?>
    <div class="flex gap-6 overflow-x-auto snap-x pb-4">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="min-w-[350px] snap-start border border-blue-100 rounded-2xl p-6 bg-white/90 shadow-md hover:shadow-xl glow-hover transition-all duration-500 transform hover:scale-105 animate-fade-in">
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
            ?>
            <div class="mt-5">
                <h3 class="text-md font-bold text-gray-800 mb-2">
                    <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i>Stops on Route:
                </h3>
                <div class="relative pl-6">
                    <div class="absolute left-4 top-2 bottom-2 w-1 bg-blue-300 rounded-full animate-pulse"></div>
                    <ul class="space-y-4">
                        <?php
                        $delay = 0;
                        while ($stopRow = $stopsResult->fetch_assoc()):
                        ?>
                        <li class="relative pl-4 flex items-center gap-3 animate-moving-stop" style="animation-delay: <?= $delay ?>s;">
                            <div class="w-3 h-3 bg-blue-600 rounded-full z-10"></div>
                            <span class="text-gray-700 font-medium"><?= htmlspecialchars($stopRow['stop_name']) ?></span>
                        </li>
                        <?php $delay += 0.2; endwhile; ?>
                    </ul>
                </div>
            </div>
            <?php else: ?>
            <p class="text-sm text-gray-600 mt-2">No stops found.</p>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
    <p class="text-red-600 text-lg font-medium mt-6">No buses found for this route. Try another selection.</p>
    <?php endif; ?>
</div>

<style>
    .animate-moving-stop {
        opacity: 0;
        transform: translateX(-30px);
        animation: moveStop 0.6s ease forwards;
    }

    @keyframes moveStop {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .snap-x::-webkit-scrollbar {
        height: 8px;
    }

    .snap-x::-webkit-scrollbar-thumb {
        background-color: #93c5fd;
        border-radius: 8px;
    }

    .snap-x::-webkit-scrollbar-track {
        background: #e0e7ff;
    }
</style>
</body>
