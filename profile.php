<?php
// Include the database connection
require_once("../db/db.php");

// Start session and check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Update profile info if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phone'];
    $newPassword = $_POST['password'];
    
    // Update the user's profile information in the database
    $updateQuery = $conn->prepare("UPDATE users SET email = ?, phone = ?, password = ? WHERE id = ?");
    $updateQuery->bind_param("sssi", $newEmail, $newPhone, password_hash($newPassword, PASSWORD_DEFAULT), $user_id);
    $updateQuery->execute();
    
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - SellPoint</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <div class="container">
            <h1>Profile Settings</h1>
        </div>
    </header>

    <!-- Profile Update Form -->
    <section class="profile-form">
        <div class="container">
            <form action="profile.php" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="btn-primary">Update Profile</button>
            </form>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2024 SellPoint. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
