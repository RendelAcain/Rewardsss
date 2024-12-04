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

// Get data from the frontend
$data = json_decode(file_get_contents("php://input"), true);

$user_id = 1; // Replace with actual user session ID
$event_id = $data['event_id'];
$points = $data['points'];

// Insert event participation
$sql = "INSERT INTO event_participation (user_id, event_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $event_id);

if ($stmt->execute()) {
    // Update user points
    $updatePoints = "UPDATE users SET points = points + ? WHERE id = ?";
    $updateStmt = $conn->prepare($updatePoints);
    $updateStmt->bind_param("ii", $points, $user_id);
    $updateStmt->execute();

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}

$conn->close();
?>
