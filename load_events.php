<?php
// Database connection
$host = "localhost";
$dbname = "plmun_system";
$username = "root"; // Change if needed
$password = ""; // Change if needed

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get category from frontend
$category = isset($_GET['category']) ? $_GET['category'] : "";

// Fetch events for the selected category
$sql = "SELECT * FROM events WHERE category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

// Return events as JSON
echo json_encode($events);

$conn->close();
?>
