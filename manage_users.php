<?php
session_start();
include 'db.php'; // Include your DB connection

// Only allow access if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Fetch users from the database
$query = "SELECT * FROM users";  // Assuming users are stored in the 'users' table
$result = mysqli_query($conn, $query);

if ($result) {
    // Code to display users in table
    while ($user = mysqli_fetch_assoc($result)) {
        // Display each user in the table
        echo "<tr>";
        echo "<td>" . $user['username'] . "</td>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td><a href='edit_user.php?id=" . $user['id'] . "'>Edit</a> | <a href='delete_user.php?id=" . $user['id'] . "'>Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "No users found.";
}
?>
