<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Server-side validation (optional)
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Send email (using PHP mail function or any other mailing service)
        $to = "your-email@example.com";
        $headers = "From: $email";
        $body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
        
        if (mail($to, $subject, $body, $headers)) {
            echo "<script>alert('Thank you for contacting us!');</script>";
        } else {
            echo "<script>alert('Sorry, something went wrong. Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - SellPoint</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logo.png" alt="SellPoint Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.html" class="nav-item">Home</a></li>
                <li><a href="about.html" class="nav-item">About</a></li>
                <li><a href="plans.html" class="nav-item">Plans</a></li>
                <li><a href="login.html" class="nav-item">Login</a></li>
                <li><a href="register.html" class="nav-item">Register</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="contact-header">
            <h1>Contact Us</h1>
            <p>If you have any questions or feedback, feel free to reach out to us!</p>
        </section>

        <section class="contact-form-container">
            <form method="POST" action="contact.php">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject">

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 SellPoint. All rights reserved.</p>
    </footer>
</body>
</html>
