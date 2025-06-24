<?php
// manage_stop.php
include 'db.php';

if (isset($_POST['add'])) {
    $name = $_POST['stop_name'];
    $conn->query("INSERT INTO stop (stop_name) VALUES ('$name')");
    header("Location: manage_stop.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM stop WHERE stop_id=$id");
    header("Location: manage_stop.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Manage Stop</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f9fafb;
    color: #333;
    padding: 20px;
  }

  h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 25px;
  }

  form {
    max-width: 600px;
    margin: 0 auto 30px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
  }

  form input[type="text"],
  form input[type="number"],
  form input[type="time"],
  form input[type="date"] {
    flex: 1 1 200px;
    padding: 10px 12px;
    font-size: 16px;
    border: 1.5px solid #ddd;
    border-radius: 6px;
    transition: border-color 0.3s ease;
  }

  form input[type="text"]:focus,
  form input[type="number"]:focus,
  form input[type="time"]:focus,
  form input[type="date"]:focus {
    outline: none;
    border-color: #3498db;
  }

  form button {
    padding: 10px 25px;
    font-size: 16px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    flex: 1 1 150px;
    max-width: 150px;
  }

  form button:hover {
    background: #217dbb;
  }

  table {
    width: 90%;
    max-width: 900px;
    margin: 0 auto 40px;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  }

  table th, table td {
    padding: 14px 20px;
    text-align: center;
    border-bottom: 1px solid #eee;
  }

  table th {
    background-color: #3498db;
    color: white;
    font-weight: 600;
  }

  table tr:hover {
    background-color: #f1faff;
  }

  a {
    display: block;
    max-width: 120px;
    margin: 0 auto;
    text-align: center;
    text-decoration: none;
    background-color: #3498db;
    color: white;
    padding: 10px 15px;
    border-radius: 6px;
    transition: background-color 0.3s ease;
  }

  a:hover {
    background-color: #217dbb;
  }

  /* Responsive */
  @media (max-width: 600px) {
    form {
      flex-direction: column;
      gap: 12px;
    }
    form button {
      max-width: 100%;
      flex: unset;
    }
    table, thead, tbody, th, td, tr {
      display: block;
    }
    table th {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }
    table tr {
      margin-bottom: 15px;
      border-bottom: 2px solid #ddd;
    }
    table td {
      border: none;
      position: relative;
      padding-left: 50%;
      text-align: left;
    }
    table td:before {
      position: absolute;
      top: 14px;
      left: 15px;
      width: 45%;
      white-space: nowrap;
      font-weight: 600;
      color: #3498db;
    }
    /* Adjust these labels to your columns */
    table td:nth-of-type(1):before { content: "ID"; }
    table td:nth-of-type(2):before { content: "Name"; }
    table td:nth-of-type(3):before { content: "Action"; }
    /* Additional for route_stop or bus_schedule tables */
    table td:nth-of-type(4):before { content: "Order"; }
    table td:nth-of-type(5):before { content: "Arrival"; }
    table td:nth-of-type(6):before { content: "Departure"; }
  }
</style>
</head>
<body>
<h2>Manage Stop</h2>
<form method="post">
    <input type="text" name="stop_name" placeholder="Stop Name" required>
    <button type="submit" name="add">Add Stop</button>
</form>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Action</th></tr>
    <?php
    $res = $conn->query("SELECT * FROM stop");
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$row['stop_id']}</td>
            <td>{$row['stop_name']}</td>
            <td><a href='manage_stop.php?delete={$row['stop_id']}'>Delete</a></td>
        </tr>";
    }
    ?>
</table>
<a href="dashboard.php">Back</a>
</body>
</html>

<?php
// manage_route.php
include 'db.php';

if (isset($_POST['add'])) {
    $name = $_POST['route_name'];
    $conn->query("INSERT INTO route (route_name) VALUES ('$name')");
    header("Location: manage_route.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM route WHERE route_id=$id");
    header("Location: manage_route.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Manage Route</title></head>
<body>
<h2>Manage Route</h2>
<form method="post">
    <input type="text" name="route_name" placeholder="Route Name" required>
    <button type="submit" name="add">Add Route</button>
</form>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Action</th></tr>
    <?php
    $res = $conn->query("SELECT * FROM route");
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$row['route_id']}</td>
            <td>{$row['route_name']}</td>
            <td><a href='manage_route.php?delete={$row['route_id']}'>Delete</a></td>
        </tr>";
    }
    ?>
</table>
<a href="dashboard.php">Back</a>
</body>
</html>

<?php
// manage_route_stop.php
include 'db.php';

if (isset($_POST['add'])) {
    $route = $_POST['route_id'];
    $stop = $_POST['stop_id'];
    $order = $_POST['stop_order'];
    $arrival = $_POST['estimated_arrival'];
    $departure = $_POST['estimated_departure'];

    $conn->query("INSERT INTO route_stop (route_id, stop_id, stop_order, estimated_arrival, estimated_departure) 
                  VALUES ('$route', '$stop', '$order', '$arrival', '$departure')");
    header("Location: manage_route_stop.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM route_stop WHERE id=$id");
    header("Location: manage_route_stop.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Manage Route Stops</title></head>
<body>
<h2>Manage Route Stops</h2>
<form method="post">
    <input type="number" name="route_id" placeholder="Route ID" required>
    <input type="number" name="stop_id" placeholder="Stop ID" required>
    <input type="number" name="stop_order" placeholder="Stop Order" required>
    <input type="time" name="estimated_arrival" required>
    <input type="time" name="estimated_departure" required>
    <button type="submit" name="add">Add Route Stop</button>
</form>
<table border="1">
    <tr><th>ID</th><th>Route ID</th><th>Stop ID</th><th>Order</th><th>Arrival</th><th>Departure</th><th>Action</th></tr>
    <?php
    $res = $conn->query("SELECT * FROM route_stop");
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['route_id']}</td>
            <td>{$row['stop_id']}</td>
            <td>{$row['stop_order']}</td>
            <td>{$row['estimated_arrival']}</td>
            <td>{$row['estimated_departure']}</td>
            <td><a href='manage_route_stop.php?delete={$row['id']}'>Delete</a></td>
        </tr>";
    }
    ?>
</table>
<a href="dashboard.php">Back</a>
</body>
</html>

<?php
// manage_bus_schedule.php
include 'db.php';

if (isset($_POST['add'])) {
    $bus = $_POST['bus_id'];
    $route = $_POST['route_id'];
    $date = $_POST['schedule_date'];
    $time = $_POST['start_time'];

    $conn->query("INSERT INTO bus_schedule (bus_id, route_id, schedule_date, start_time) 
                  VALUES ('$bus', '$route', '$date', '$time')");
    header("Location: manage_bus_schedule.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM bus_schedule WHERE schedule_id=$id");
    header("Location: manage_bus_schedule.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Manage Bus Schedule</title></head>
<body>
<h2>Manage Bus Schedule</h2>
<form method="post">
    <input type="number" name="bus_id" placeholder="Bus ID" required>
    <input type="number" name="route_id" placeholder="Route ID" required>
    <input type="date" name="schedule_date" required>
    <input type="time" name="start_time" required>
    <button type="submit" name="add">Add Schedule</button>
</form>
<table border="1">
    <tr><th>ID</th><th>Bus ID</th><th>Route ID</th><th>Date</th><th>Start Time</th><th>Action</th></tr>
    <?php
    $res = $conn->query("SELECT * FROM bus_schedule");
    while ($row = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$row['schedule_id']}</td>
            <td>{$row['bus_id']}</td>
            <td>{$row['route_id']}</td>
            <td>{$row['schedule_date']}</td>
            <td>{$row['start_time']}</td>
            <td><a href='manage_bus_schedule.php?delete={$row['schedule_id']}'>Delete</a></td>
        </tr>";
    }
    ?>
</table>
<a href="dashboard.php">Back</a>
</body>
</html>
