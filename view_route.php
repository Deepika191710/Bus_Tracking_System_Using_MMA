<?php
include 'db.php';

// Fetch routes from database
$result = $conn->query("SELECT route_id, route_name FROM route ORDER BY route_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>View Routes</title>
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
      td:nth-of-type(1):before { content: "Route ID"; }
      td:nth-of-type(2):before { content: "Route Name"; }

    }
  </style>
</head>
<body>

  <h1>Routes</h1>

  <table>
    <thead>
      <tr>
        <th>Route ID</th>
        <th>Route Name</th>
      
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['route_id']) ?></td>
            <td><?= htmlspecialchars($row['route_name']) ?></td>
         
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="3">No routes found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
