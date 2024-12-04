<?php
session_start();
include 'db_connection.php';

// Assuming the user is logged in and email is stored in session
$email = $_SESSION['email']; // Retrieve email from session

// Query user data
$sql = "SELECT * FROM users WHERE email = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $db_email, $db_name, $db_hobbies);
        $stmt->fetch();
    }
}
?>