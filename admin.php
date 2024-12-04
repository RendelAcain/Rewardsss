<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="plmun.png" alt="PLMun Logo">
            <h1>PLMUN Admin</h1>
        </div>
        <ul>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="dashboard-container">
        <h1>Welcome, Admin!</h1>
        <p>Manage users, activities, and rewards.</p>
        <a href="manage_users.php">Manage Users</a>
        <a href="view_reports.php">View Reports</a>
    </div>
</body>
</html>
