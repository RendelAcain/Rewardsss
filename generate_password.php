<?php
// The password for the admin
$password = 'iowdlacsi2';  // Replace this with the actual password for admin

// Generate a hashed password using PASSWORD_DEFAULT
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password
echo "Hashed password: " . $hashed_password;
?>
