<?php
require 'db_connection.php';

$result = $conn->query("SELECT * FROM event_participation");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Activities</title>
</head>
<body>
    <h1>User Activities</h1>
    <table>
        <tr>
            <th>User ID</th>
            <th>Event Name</th>
            <th>Points Earned</th>
            <th>Timestamp</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['user_id'] ?></td>
                <td><?= $row['event_name'] ?></td>
                <td><?= $row['points_earned'] ?></td>
                <td><?= $row['timestamp'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
