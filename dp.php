<?php
// Database credentials
$servername = "localhost"; // Usually 'localhost'
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "sellpoint";     // The name of your database

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
