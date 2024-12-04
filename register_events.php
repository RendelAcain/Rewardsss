<?php
session_start();

if (!isset($_SESSION['school_id'])) {
    header("Location: index.html"); // Redirect if not logged in
    exit();
}

$school_id = $_SESSION['school_id'];

// Connect to the database
$connection = new mysqli("localhost", "root", "", "plmun_engagement_system");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch student ID using school_id
$query = "SELECT id FROM students WHERE school_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('s', $school_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$student_id = $student['id'];

// Get the event to register for
$event_id = $_POST['event_id'];
$points_awarded = 10; // Example: 10 points for participating in any event

// Insert participation into student_events table
$query = "INSERT INTO student_events (student_id, event_id, points_awarded) VALUES (?, ?, ?)";
$stmt = $connection->prepare($query);
$stmt->bind_param('iii', $student_id, $event_id, $points_awarded);
$stmt->execute();

// Update student's points
$query = "UPDATE students SET points = points + ? WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('ii', $points_awarded, $student_id);
$stmt->execute();

header("Location: dashboard.php"); // Redirect to the dashboard
?>