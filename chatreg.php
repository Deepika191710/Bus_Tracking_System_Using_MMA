<?php
$conn = new mysqli("localhost", "root", "", "bustrack");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];

    $stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash, email, full_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $full_name);

    if ($stmt->execute()) {
        header("Location: chatlogin.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <link rel="stylesheet" href="chatstyle.css">
</head>
<body>
<div class="container">
    <form method="POST">
        <h2>Register as Admin</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="full_name" placeholder="Full Name" required>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="chatlogin.php">Login here</a></p>
    </form>
</div>
</body>
</html>
