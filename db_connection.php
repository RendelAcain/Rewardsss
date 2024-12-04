<?php
$servername = "localhost"; // or "127.0.0.1"
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "plmun_engagement_system"; // the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error; // Add more details for debugging
    die();
}
?>