<?php
// Include the database connection
require_once("../db/db.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the product data
    $productName = $_POST["product_name"];
    $productDescription = $_POST["product_description"];
    $productPrice = $_POST["product_price"];
    $productCategory = $_POST["product_category"];
    $productImage = $_FILES["product_image"]["name"];

    // Set the upload directory for product images
    $targetDir = "../uploads/products/";
    $targetFile = $targetDir . basename($productImage);

    // Upload the image
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
        // Insert product details into the database
        $query = $conn->prepare("INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("ssdss", $productName, $productDescription, $productPrice, $productCategory, $productImage);
        $query->execute();

        // Redirect to the product listing page
        header("Location: product_view.php?product_id=" . $conn->insert_id);
        exit(); // Ensure the script stops after redirection
    } else {
        $error_message = "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell with Us - SellPoint</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <div class="container">
            <h1>Sell with Us</h1>
            <p>Upload your products and start selling today!</p>
        </div>
    </header>

    <!-- Sell Product Form Section -->
    <section class="sell-product-form">
        <div class="container">
            <?php
                // Display error message if file upload failed
                if (isset($error_message)) {
                    echo "<p class='error'>$error_message</p>";
                }
            ?>
            <form action="sell_with_us.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" placeholder="Enter product name" required>

                <label for="product_description">Product Description</label>
                <textarea id="product_description" name="product_description" placeholder="Enter product description" required></textarea>

                <label for="product_price">Product Price (Ksh)</label>
                <input type="number" id="product_price" name="product_price" placeholder="Enter product price" required>

                <label for="product_category">Category</label>
                <select id="product_category" name="product_category" required>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="home">Home Appliances</option>
                    <option value="beauty">Beauty & Personal Care</option>
                    <option value="sports">Sports</option>
                    <option value="other">Other</option>
                </select>

                <label for="product_image">Product Image</label>
                <input type="file" id="product_image" name="product_image" required>

                <button type="submit" class="btn-primary">Upload Product</button>
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
