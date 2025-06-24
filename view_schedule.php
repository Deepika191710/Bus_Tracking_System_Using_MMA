<?php
include 'db.php'; // Your database connection

// Fetch schedules with bus and route info
$sql = "
SELECT bs.schedule_id, b.bus_name, r.route_name, bs.start_time
FROM bus_schedule bs
JOIN bus b ON bs.bus_id = b.bus_id
JOIN route r ON bs.route_id = r.route_id
ORDER BY bs.start_time ASC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Bus Schedules</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to bottom right, #e0f2fe, #f0f9ff);
    }
  </style>
</head>
<body class="p-6">
  <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-8">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">🚌 Bus Schedules</h1>

    <?php if ($result && $result->num_rows > 0): ?>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
          <thead class="bg-blue-100 text-blue-800">
            <tr>
              <th class="py-3 px-4 text-left">Bus Name</th>
              <th class="py-3 px-4 text-left">Route</th>
              <th class="py-3 px-4 text-left">Start Time</th>
              <th class="py-3 px-4 text-left">Action</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="border-t hover:bg-blue-50 transition">
                <td class="py-3 px-4"><?= htmlspecialchars($row['bus_name']) ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($row['route_name']) ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($row['start_time']) ?></td>
                <td class="py-3 px-4">
                  <form action="delete_schedule.php" method="POST" onsubmit="return confirm('Are you sure?');">
                    <input type="hidden" name="schedule_id" value="<?= $row['schedule_id'] ?>">
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="text-red-600 font-medium">No schedules found.</p>
    <?php endif; ?>

    <div class="mt-6">
      <a href="index.html" class="text-blue-600 hover:underline">← Back to Home</a>
    </div>
  </div>
</body>
</html>
