<?php
// insert_data.php
include 'db.php';

$table = $_POST['table'] ?? '';
$columns = [];
$success = $error = '';

if ($table) {
    // Fetch columns from selected table
    $columnsRes = $conn->query("DESCRIBE `$table`");
    while ($row = $columnsRes->fetch_assoc()) {
        if ($row['Field'] !== 'id' && stripos($row['Extra'], 'auto_increment') === false) {
            $columns[] = $row['Field'];
        }
    }

    // Insert data on submit
    if (isset($_POST['submit'])) {
        $placeholders = implode(',', array_fill(0, count($columns), '?'));
        $colNames = implode(',', $columns);
        $stmt = $conn->prepare("INSERT INTO `$table` ($colNames) VALUES ($placeholders)");

        $types = str_repeat('s', count($columns));
        $values = array_map(fn($col) => $_POST[$col] ?? '', $columns);

        $stmt->bind_param($types, ...$values);
        if ($stmt->execute()) {
            $success = "✅ Inserted successfully into <b>$table</b>.";
        } else {
            $error = "❌ Error: " . $stmt->error;
        }
    }
}

// Get table list
$tablesRes = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $tablesRes->fetch_array()) {
    $tables[] = $row[0];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Data</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 30px 20px;
            color: #333;
        }

        h2, h3 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: 600;
            margin-top: 15px;
            display: block;
            color: #34495e;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            margin-bottom: 12px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus, select:focus {
            outline: none;
            border-color: #2980b9;
            background: #f0f8ff;
        }

        button {
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #2471a3;
        }

        .message {
            max-width: 600px;
            margin: 20px auto;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 500px) {
            form {
                padding: 20px 15px;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<h2>Insert New Record</h2>

<?php if ($success): ?>
    <div class="message success"><?= $success ?></div>
<?php elseif ($error): ?>
    <div class="message error"><?= $error ?></div>
<?php endif; ?>

<!-- Table Selection Form -->
<form method="post">
    <label>Select Table:</label>
    <select name="table" onchange="this.form.submit()" required>
        <option value="">-- Select a table --</option>
        <?php foreach ($tables as $t): ?>
            <option value="<?= $t ?>" <?= ($t === $table) ? 'selected' : '' ?>><?= $t ?></option>
        <?php endforeach; ?>
    </select>
</form>

<!-- Data Insertion Form -->
<?php if ($table && count($columns)): ?>
    <form method="post">
        <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
        <h3>Insert Data into <b><?= htmlspecialchars($table) ?></b></h3>
        <?php foreach ($columns as $col): ?>
            <label><?= htmlspecialchars($col) ?>:</label>
            <input type="text" name="<?= htmlspecialchars($col) ?>" required>
        <?php endforeach; ?>
        <button type="submit" name="submit">Insert</button>
    </form>
<?php elseif ($table): ?>
    <p style="text-align: center;">No insertable columns found in this table.</p>
<?php endif; ?>

</body>
</html>
