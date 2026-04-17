<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UniMatch Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #1e293b;
            color: white;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #334155;
        }

        /* Main content */
        .main {
            margin-left: 240px;
            padding: 20px;
            width: 100%;
        }

        /* Top bar */
        .topbar {
            background: #f1f5f9;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>UniMatch</h2>

        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/students">Students</a>
        <a href="/admin/professors">Professors</a>
        <a href="/admin/projects">Projects</a>
        <a href="/admin/specialities">Specialities</a>
        <a href="/admin/allocation">Run Allocation</a>
        <a href="/admin/results">Results</a>
    </div>

    <!-- Main Content -->
    <div class="main">

        <div class="topbar">
            <h3>Admin Dashboard</h3>
        </div>

        <!-- Page Content -->
        @yield('content')

    </div>

</body>
</html>