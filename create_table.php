<?php
include 'db.php';
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableName = $_POST['table_name'] ?? '';
    $columns = $_POST['columns'] ?? '';

    if ($tableName && $columns) {
        $sql = "CREATE TABLE `$tableName` ($columns)";
        if ($conn->query($sql)) {
            $success = "Table '$tableName' created successfully.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Table</title>
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f7fa;
    padding: 30px 15px;
    color: #333;
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #2c3e50;
}

form {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    box-sizing: border-box;
}

label {
    font-weight: 600;
    margin-top: 15px;
    display: block;
    color: #34495e;
}

input[type="text"], textarea {
    width: 100%;
    padding: 12px 15px;
    margin-top: 8px;
    border: 1.8px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
    resize: vertical;
}

input[type="text"]:focus,
textarea:focus {
    outline: none;
    border-color: #3498db;
    background-color: #f0f8ff;
}

small {
    color: #7f8c8d;
    font-size: 13px;
}

button {
    margin-top: 25px;
    width: 100%;
    background-color: #3498db;
    border: none;
    padding: 14px 0;
    font-size: 18px;
    font-weight: 700;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #217dbb;
}

.success {
    max-width: 600px;
    margin: 0 auto 15px;
    padding: 12px 15px;
    border-radius: 6px;
    background-color: #d4edda;
    color: #155724;
    font-weight: 600;
    box-sizing: border-box;
    border: 1.5px solid #c3e6cb;
}

.error {
    max-width: 600px;
    margin: 0 auto 15px;
    padding: 12px 15px;
    border-radius: 6px;
    background-color: #f8d7da;
    color: #721c24;
    font-weight: 600;
    box-sizing: border-box;
    border: 1.5px solid #f5c6cb;
}

/* Responsive */
@media (max-width: 480px) {
    form {
        padding: 20px 15px;
    }
    button {
        font-size: 16px;
    }
}

    </style>
</head>
<body>
<h2>Create New Table</h2>
<?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<form method="post">
    <label>Table Name: <input type="text" name="table_name" required></label>
    <label>Columns (SQL syntax):</label>
    <textarea name="columns" rows="5" required></textarea>
    <small>Example: id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), created_at DATETIME</small><br><br>
    <button type="submit">Create Table</button>
</form>
</body>
</html>
