<?php
session_start();
include 'db.php'; // Include your DB connection

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Fetch products from the database
$query = "SELECT * FROM products";  // Assuming products are stored in the 'products' table
$result = mysqli_query($conn, $query);

if ($result) {
    // Display products in the table
    while ($product = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $product['name'] . "</td>";
        echo "<td>" . $product['category'] . "</td>";
        echo "<td>" . $product['price'] . "</td>";
        echo "<td><a href='edit_product.php?id=" . $product['id'] . "'>Edit</a> | <a href='delete_product.php?id=" . $product['id'] . "'>Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "No products found.";
}
?>
