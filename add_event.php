<?php
// Database connection
$host = "localhost";
$dbname = "plmun_system";
$username = "root"; // Update if necessary
$password = ""; // Update if necessary

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $points = $_POST["points"];
    $category = $_POST["category"];

    // Insert event into the database
    $sql = "INSERT INTO events (name, description, points, category) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $name, $description, $points, $category);

    if ($stmt->execute()) {
        echo "<p>Event successfully added!</p>";
        echo '<a href="add_event.html">Add Another Event</a>';
        echo ' | <a href="dashboard.html">Go to Dashboard</a>';
    } else {
        echo "<p>Error adding event: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>
