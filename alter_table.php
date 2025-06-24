<?php
include 'db.php';
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'] ?? '';
    $newColumn = $_POST['new_column'] ?? '';
    $dataType = $_POST['data_type'] ?? 'VARCHAR(255)';

    if ($table && $newColumn) {
        $sql = "ALTER TABLE `$table` ADD `$newColumn` $dataType";
        if ($conn->query($sql)) {
            $success = "Column '$newColumn' added to table '$table'.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Alter Table</title>
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #eef2f5;
    padding: 30px 15px;
    color: #2c3e50;
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #34495e;
}

form {
    max-width: 550px;
    margin: 0 auto;
    background: #ffffff;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    box-sizing: border-box;
}

label {
    display: block;
    margin-top: 20px;
    font-weight: 600;
    color: #2f4f4f;
}

input[type="text"] {
    width: 100%;
    padding: 12px 14px;
    margin-top: 6px;
    border: 1.8px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

input[type="text"]:focus {
    outline: none;
    border-color: #2980b9;
    background-color: #f0f8ff;
}

button {
    margin-top: 25px;
    width: 100%;
    background-color: #3498db;
    border: none;
    padding: 14px 0;
    font-size: 17px;
    font-weight: 700;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #217dbb;
}

.success, .error {
    max-width: 550px;
    margin: 0 auto 15px;

    </style>
</head>
<body>
<h2>Alter Table: Add New Column</h2>
<?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<form method="post">
    <label>Table Name: <input type="text" name="table" required></label>
    <label>New Column Name: <input type="text" name="new_column" required></label>
    <label>Data Type: <input type="text" name="data_type" value="VARCHAR(255)" required></label>
    <button type="submit">Add Column</button>
</form>
</body>
</html>
