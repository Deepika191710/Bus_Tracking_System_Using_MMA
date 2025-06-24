<?php
session_start();
require 'db.php';

$error = '';
$username = '';
$password = '';

if (isset($_COOKIE['remember_user'])) {
    $username = $_COOKIE['remember_user'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ? AND status = 'active'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];

        if ($remember) {
            setcookie("remember_user", $username, time() + (7 * 24 * 60 * 60)); // 7 days
        } else {
            setcookie("remember_user", "", time() - 3600);
        }

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials or inactive account.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($username) ?>" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <label><input type="checkbox" name="remember" <?= isset($_COOKIE['remember_user']) ? 'checked' : '' ?>> Remember me</label><br>
        <button type="submit">Login</button>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
    </form>
</div>
</body>
</html>
