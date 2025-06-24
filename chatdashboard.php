<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: chatlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p>This is your dashboard.</p>
    <a href="chatlogout.php">Logout</a>
</div>
</body>
</html>
