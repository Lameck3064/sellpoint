<?php
// Include database connection
include('db/db.php');

// Handle form submission for product upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $sub_title = $_POST['sub_title'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];

    // Insert product into database (simplified)
    $sql = "INSERT INTO products (product_name, category, sub_title, price, discount, description) VALUES ('$product_name', '$category', '$sub_title', '$price', '$discount', '$description')";
    if (mysqli_query($conn, $sql)) {
        echo "Product uploaded successfully!";
    } else {
        echo "Error uploading product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell With Us</title>
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
        <section class="form-container">
            <h2>Upload Your Product</h2>
            <form action="sell_with_us.php" method="POST" enctype="multipart/form-data">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" required>
                
                <label for="category">Category</label>
                <input type="text" id="category" name="category" required>
                
                <label for="sub_title">Subtitle</label>
                <input type="text" id="sub_title" name="sub_title" required>
                
                <label for="price">Price (Ksh)</label>
                <input type="number" id="price" name="price" required>
                
                <label for="discount">Discount (%)</label>
                <input type="number" id="discount" name="discount" required>
                
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
                
                <button type="submit">Upload Product</button>
            </form>
        </section>
    </main>
</body>
</html>
