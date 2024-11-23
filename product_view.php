<?php
// Include database connection
require_once("../db/db.php");

// Get product ID from URL
$product_id = $_GET['product_id'];

// Fetch product details from the database
$query = $conn->prepare("SELECT * FROM products WHERE id = ?");
$query->bind_param("i", $product_id);
$query->execute();
$result = $query->get_result();
$product = $result->fetch_assoc();

// Check if product exists
if (!$product) {
    echo "Product not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - SellPoint</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Product Details Section -->
    <section class="product-details">
        <div class="container">
            <h2><?php echo $product['name']; ?></h2>
            <img src="../uploads/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
            <p><?php echo $product['description']; ?></p>
            <p>Price: Ksh <?php echo $product['price']; ?></p>
            <p>Category: <?php echo ucfirst($product['category']); ?></p>
            <button class="btn-primary">Add to Cart</button>
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
