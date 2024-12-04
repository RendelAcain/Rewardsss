<?php
// Start session to manage user login state
session_start();

// Include database connection
include('db_connection.php');

// Initialize an error message variable
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $error = "Please fill out all fields.";
    } else {
        // Check if user exists in the database
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch user data
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Store user information in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.html");
                } else {
                    header("Location: dashboard.html");
                }
                exit();
            } else {
                $error = "Incorrect password. Please try again.";
            }
        } else {
            $error = "No account found with that email.";
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
    <title>Login - PLMun Student Engagement System</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background-color: #000; /* Set background color to black */
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar h1 {
            color: white;
            font-size: 24px;
        }

        .navbar ul {
            list-style: none;
            display: flex;
        }

        .navbar ul li {
            margin: 0 15px;
        }

        .navbar ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        /* Login Section */
        .login-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
        }

        .login-container img {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="plmun.png" alt="PLMun Logo">
        </div>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="register.html">Register</a></li>
        </ul>
    </nav>

    <!-- Login Form -->
    <section class="login-section">
        <div class="login-container">
            <img src="plmun.png" alt="PLMun Logo" class="login-image">
            <h2>Login</h2>
            <form method="POST" action="">
                <label for="email">Institutional Email (IE)</label>
                <input type="email" id="email" name="email" required placeholder="Enter your institutional email">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">

                <button type="submit">Login</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Pamantasan ng Lungsod ng Muntinlupa. All rights reserved.</p>
    </footer>
</body>
</html>
