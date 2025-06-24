<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bus_tracking';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tablesResult = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $tablesResult->fetch_array()) {
    $tables[] = $row[0];
}

$selectedTable = isset($_GET['table']) ? $_GET['table'] : $tables[0];
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$columnsResult = $conn->query("DESCRIBE $selectedTable");
$columns = [];
while ($col = $columnsResult->fetch_assoc()) {
    $columns[] = $col['Field'];
}

$whereClause = '';
if (!empty($search)) {
    $searchTerms = [];
    foreach ($columns as $col) {
        $searchTerms[] = "$col LIKE '%" . $conn->real_escape_string($search) . "%'";
    }
    $whereClause = "WHERE " . implode(" OR ", $searchTerms);
}

$totalResult = $conn->query("SELECT COUNT(*) as count FROM $selectedTable $whereClause");
$totalRows = $totalResult->fetch_assoc()['count'];
$totalPages = ceil($totalRows / $limit);

$dataResult = $conn->query("SELECT * FROM $selectedTable $whereClause LIMIT $limit OFFSET $offset");

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $selectedTable . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, $columns);
    $exportResult = $conn->query("SELECT * FROM $selectedTable $whereClause");
    while ($row = $exportResult->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Table - Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background-color: #f2f6fc; }
        h2 { text-align: center; margin-bottom: 20px; color: #2c3e50; }
        form, .search-bar, .pagination { text-align: center; margin: 20px auto; }
        select, input[type="text"] { padding: 8px 12px; font-size: 16px; border-radius: 6px; border: 1px solid #ccc; }
        table { width: 90%; margin: 0 auto; border-collapse: collapse; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: center; border-bottom: 1px solid #eee; }
        th { background-color: #3498db; color: white; }
        tr:hover { background-color: #f9f9f9; }
        .pagination a { margin: 0 5px; padding: 8px 12px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; }
        .pagination a.active { background: #2c3e50; }
        .export-btn { display: inline-block; margin: 10px; padding: 10px 15px; background: #2ecc71; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>View Table: <?= htmlspecialchars($selectedTable) ?></h2>

    <form method="get" action="">
        <label for="table">Select Table:</label>
        <select name="table" id="table" onchange="this.form.submit()">
            <?php foreach ($tables as $table): ?>
                <option value="<?= $table ?>" <?= ($table == $selectedTable) ? 'selected' : '' ?>>
                    <?= $table ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Filter</button>
        <a class="export-btn" href="?table=<?= $selectedTable ?>&search=<?= urlencode($search) ?>&export=csv">Export CSV</a>
    </form>

    <table>
        <thead>
            <tr>
                <?php foreach ($columns as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $dataResult->fetch_assoc()): ?>
                <tr>
                    <?php foreach ($columns as $col): ?>
                        <td><?= htmlspecialchars($row[$col]) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?table=<?= $selectedTable ?>&search=<?= urlencode($search) ?>&page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>">Page <?= $i ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>