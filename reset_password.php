<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    // Connect to database
    require_once("../db/db.php");

    // Check if the email exists
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Generate a reset token
        $resetToken = bin2hex(random_bytes(32));
        $query = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $query->bind_param("ss", $resetToken, $email);
        $query->execute();

        // Send the reset link (mockup)
        $resetLink = "https://example.com/reset_password_form.php?token=$resetToken";
        echo "Reset link sent: $resetLink";
    } else {
        echo "Email not found!";
    }
}
?>
