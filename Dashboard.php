<?php
// Include the database connection
require_once("../db/db.php");

// Check if the user is logged in (You can modify this based on your session management)
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch products uploaded by the logged-in seller
$user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session
$query = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - SellPoint</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <div class="container">
            <h1>Seller Dashboard</h1>
            <p>Manage your products and sales</p>
            <a href="sell_with_us.php" class="btn-primary">Add New Product</a>
        </div>
    </header>

    <!-- Seller's Products Section -->
    <section class="seller-products">
        <div class="container">
            <h2>Your Products</h2>
            <div class="product-grid">
                <?php while ($product = $result->fetch_assoc()) { ?>
                    <div class="product-card">
                        <img src="products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                        <h3><?php echo $product['name']; ?></h3>
                        <p>Price: Ksh <?php echo $product['price']; ?></p>
                        <p>Category: <?php echo ucfirst($product['category']); ?></p>
                        <a href="product_view.php?product_id=<?php echo $product['id']; ?>" class="btn-secondary">View Product</a>
                        <a href="edit_product.php?product_id=<?php echo $product['id']; ?>" class="btn-primary">Edit</a>
                        <a href="delete_product.php?product_id=<?php echo $product['id']; ?>" class="btn-danger">Delete</a>
                    </div>
                <?php } ?>
            </div>
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
