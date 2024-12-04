<?php
// Connect to Database
$host = "localhost";
$username = "root";
$password = "";
$database = "plmun_system";

$conn = new mysqli($host, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch User Activities
$activities_sql = "SELECT activities.id, users.name, activities.activity, activities.timestamp 
                   FROM activities 
                   JOIN users ON activities.user_id = users.id 
                   ORDER BY activities.timestamp DESC";
$activities_result = $conn->query($activities_sql);

// Fetch Redemption Records
$redemptions_sql = "SELECT redemptions.id, users.name, redemptions.item, redemptions.points_used, redemptions.timestamp 
                    FROM redemptions 
                    JOIN users ON redemptions.user_id = users.id 
                    ORDER BY redemptions.timestamp DESC";
$redemptions_result = $conn->query($redemptions_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PLMun Student Engagement System</title>
    <style>
        /* Add the same styles here */
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="plmun.png" alt="PLMun Logo">
            <h1>PLMUN Admin</h1>
        </div>
        <ul>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Dashboard -->
    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>

        <!-- User Activity Table -->
        <h2>User Activities</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Activity</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($activities_result->num_rows > 0): ?>
                    <?php while ($row = $activities_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['activity']; ?></td>
                            <td><?php echo $row['timestamp']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No activities found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Redemption Table -->
        <h2>Redemption Records</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Item Redeemed</th>
                    <th>Points Used</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($redemptions_result->num_rows > 0): ?>
                    <?php while ($row = $redemptions_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['item']; ?></td>
                            <td><?php echo $row['points_used']; ?></td>
                            <td><?php echo $row['timestamp']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No redemptions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Pamantasan ng Lungsod ng Muntinlupa. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
// Close Connection
$conn->close();
?>
