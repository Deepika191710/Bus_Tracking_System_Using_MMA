<?php
include 'db.php';

// Fetch stops from database
$result = $conn->query("SELECT stop_id, stop_name, latitude, longitude FROM stop ORDER BY stop_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>View Bus Stops</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
      padding: 20px;
      color: #333;
    }
    h1 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }
    table {
      width: 90%;
      max-width: 900px;
      margin: 0 auto;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    th, td {
      padding: 14px 20px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #3498db;
      color: white;
      font-weight: 600;
    }
    tr:hover {
      background-color: #f1f9ff;
    }
    @media (max-width: 600px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      th {
        position: absolute;
        top: -9999px;
        left: -9999px;
      }
      tr {
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
      }
      td {
        border: none;
        position: relative;
        padding-left: 50%;
        text-align: left;
      }
      td:before {
        position: absolute;
        top: 14px;
        left: 15px;
        width: 45%;
        white-space: nowrap;
        font-weight: 600;
        color: #3498db;
      }
      td:nth-of-type(1):before { content: "Stop ID"; }
      td:nth-of-type(2):before { content: "Stop Name"; }
      td:nth-of-type(3):before { content: "Latitude"; }
      td:nth-of-type(4):before { content: "Longitude"; }
    }
  </style>
</head>
<body>

  <h1>Bus Stops</h1>

  <table>
    <thead>
      <tr>
        <th>Stop ID</th>
        <th>Stop Name</th>
        <th>Latitude</th>
        <th>Longitude</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['stop_id']) ?></td>
            <td><?= htmlspecialchars($row['stop_name']) ?></td>
            <td><?= htmlspecialchars($row['latitude']) ?></td>
            <td><?= htmlspecialchars($row['longitude']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4">No stops found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
