<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: chatlogin.php");
    exit();
}
include 'db.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        /* Reset and base */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        a:hover {
            color: #0ea5e9;
        }

        /* Main container */
        .main-container {
            display: flex;
            min-height: 100vh;
            max-width: 1200px;
            margin: 1.5rem auto;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            background-color: #fff;
            box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #fff;
            border-right: 1px solid #cbd5e1;
            padding: 1.5rem 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            user-select: none;
        }
        .sidebar h2 {
            font-weight: 900;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            color: #0ea5e9;
            cursor: default;
            user-select: text;
        }
        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .sidebar nav a {
            padding: 0.3rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 500;
            color: #64748b;
            transition: color 0.2s ease;
        }
        .sidebar nav a:hover {
            color: #0ea5e9;
        }

        /* Content section */
        .content {
            flex: 1;
            padding: 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.25rem;
            font-weight: 600;
            color: #334155;
        }
        header h1 {
            margin: 0;
        }
        .logout {
            background-color: #0ea5e9;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: background-color 0.2s ease;
        }
        .logout:hover {
            background-color: #0284c7;
        }

        /* Dashboard sections */
        .dashboard-section h2 {
            font-weight: 600;
            font-size: 1.125rem;
            color: #334155;
            margin-bottom: 1rem;
            user-select: text;
        }

        /* Card grid */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(140px,1fr));
            gap: 1rem;
        }

        /* Cards */
        .card {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: #334155;
            box-shadow: 0 1px 2px rgb(0 0 0 / 0.05);
            text-align: center;
            user-select: none;
            transition: box-shadow 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
            border-color: #0ea5e9;
            color: #0ea5e9;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                max-width: 100%;
                margin: 0.75rem;
                border-radius: 0;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #cbd5e1;
                padding: 1rem 1rem 1rem;
                font-size: 14px;
            }
            .content {
                padding: 1rem 1rem 2rem;
            }
            .card-grid {
                grid-template-columns: repeat(auto-fit,minmax(120px,1fr));
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <a href="view_bus.php">View Bus</a>
                <a href="view_stop.php">View Stop</a>
                <a href="view_route.php">View Route</a>
                <a href="view_route_stop.php">View Route Stop</a>
                <a href="view_schedule.php">View Bus Schedule</a>
                <a href="view_table.php">Download table Here<a>

            </nav>
        </aside>

        <section class="content">
            <header>
                <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
                <a href="chatlogin.php" class="logout">Logout</a>
            </header>

            <div class="dashboard-section">
                <h2>Manage Database Tables</h2>
                <div class="card-grid">
                    
                    <a href="view_bus.php" class="card">View Bus</a>
                    <a href="view_stop.php" class="card">View Stop</a>
                    <a href="view_route.php" class="card">View Route</a>
                    <a href="view_route_stop.php" class="card">View Route Stop</a>
                    <a href="view_schedule.php" class="card">View Bus Schedule</a>
                </div>
            </div>

            <div class="dashboard-section">
                <h2>Advanced Operations</h2>
                <div class="card-grid">
                    <a href="insert_data.php" class="card">Insert New Data</a>
                    <a href="alter_table.php" class="card">Alter Table</a>
                    <a href="create_table.php" class="card">Create New Table</a>
                    <a href="allcurd.php" class="card">Curd Operation</a>
                </div>
            </div>
        </section>
    </div>
</body>
</html>