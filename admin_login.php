<?php
// Start the session
session_start();

// Include your database connection (adjust the path as necessary)
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the user exists in the database
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    // Check if user is found
    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $admin['password'])) {
            // Set session variables to keep the user logged in
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];

            // Redirect to the admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Password is incorrect
            $error_message = "Incorrect password.";
        }
    } else {
        // Admin not found
        $error_message = "Admin with this email does not exist.";
    }
}
?>

<!-- If there's an error, display the message on the login form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="form-container">
        <form action="admin_login.php" method="POST" id="loginForm">
            <h2>Login to Admin Panel</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
