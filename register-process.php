<?php
// Start session
session_start();

// Assuming you have database connection code here
include('db_connection.php');

// Get data from POST
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

// Example: Check if the email already exists
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If email already exists
    echo "Email already exists!";
} else {
    // Insert new user into database
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    if ($stmt->execute()) {
        // Registration successful, redirect to login page
        header("Location: login.html");
        exit();
    } else {
        // If there is an error inserting the data
        echo "Error: Could not register the user.";
    }
}

// Close connection
$stmt->close();
$conn->close();
?>
