<?php
// admin_auth_check.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if not an admin or not logged in
    header('Location: admin_login.php');
    exit();
}
?>
