<?php
// Start session to handle messages
session_start();

// Include database connection
include('db_connection.php');

// Initialize a variable for the error message
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Set the error message
            $error = "Email already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user with a default role of 'user'
            $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, 'user')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                // Registration successful, redirect to login page
                header("Location: login.html");
                exit();
            } else {
                $error = "An error occurred. Please try again.";
            }
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();

// Trigger a JavaScript alert if there's an error
if (!empty($error)) {
    echo "<script>alert('$error');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PLMun Student Engagement System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #4CAF50;
            padding: 15px;
            text-align: center;
            color: white;
        }

        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1>PLMun Student Engagement System</h1>
    </div>

    <!-- Register Section -->
    <div class="register-container">
        <h2>Register</h2>

        <!-- Registration Form -->
        <form method="POST" action="">
            <label for="email">Institutional Email (IE)</label>
            <input type="email
