<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'plmun_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch events from the database
$course = $_GET['course'];
$sql = "SELECT event_name, description, points FROM events WHERE category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $course);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

$stmt->close();
$conn->close();

// Return JSON response
echo json_encode($events);
?>
