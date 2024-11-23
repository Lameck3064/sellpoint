<?php
// Include database connection
require_once("../db/db.php");

// Check if product ID is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Delete the product from the database
    $query = $conn->prepare("DELETE FROM products WHERE id = ?");
    $query->bind_param("i", $product_id);
    $query->execute();

    // Redirect to the dashboard
    header("Location: dashboard.php");
    exit();
} else {
    echo "Product not found!";
    exit();
}
?>
