<?php
// Include the database connection
require_once("../db/db.php");

// Get product ID from URL
$product_id = $_GET['product_id'];

// Fetch the product details from the database
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

// Update product details if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["product_name"];
    $productDescription = $_POST["product_description"];
    $productPrice = $_POST["product_price"];
    $productCategory = $_POST["product_category"];
    
    // Handle image update (if a new image is uploaded)
    $productImage = $_FILES["product_image"]["name"];
    if ($productImage) {
        $targetDir = "../uploads/products/";
        $targetFile = $targetDir . basename($productImage);
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
            $query = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, image=? WHERE id=?");
            $query->bind_param("ssdssi", $productName, $productDescription, $productPrice, $productCategory, $productImage, $product_id);
        }
    } else {
        $query = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=? WHERE id=?");
        $query->bind_param("ssdsi", $productName, $productDescription, $productPrice, $productCategory, $product_id);
    }

    $query->execute();
    header("Location: dashboard.php"); // Redirect to dashboard after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - SellPoint</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <div class="container">
            <h1>Edit Product</h1>
            <p>Update your product details</p>
        </div>
    </header>

    <!-- Edit Product Form Section -->
    <section class="edit-product-form">
        <div class="container">
            <form action="edit_product.php?product_id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo $product['name']; ?>" required>

                <label for="product_description">Product Description</label>
                <textarea id="product_description" name="product_description" required><?php echo $product['description']; ?></textarea>

                <label for="product_price">Product Price (Ksh)</label>
                <input type="number" id="product_price" name="product_price" value="<?php echo $product['price']; ?>" required>

                <label for="product_category">Category</label>
                <select id="product_category" name="product_category" required>
                    <option value="electronics" <?php echo $product['category'] == 'electronics' ? 'selected' : ''; ?>>Electronics</option>
                    <option value="clothing" <?php echo $product['category'] == 'clothing' ? 'selected' : ''; ?>>Clothing</option>
                    <option value="home" <?php echo $product['category'] == 'home' ? 'selected' : ''; ?>>Home Appliances</option>
                    <option value="beauty" <?php echo $product['category'] == 'beauty' ? 'selected' : ''; ?>>Beauty & Personal Care</option>
                    <option value="sports" <?php echo $product['category'] == 'sports' ? 'selected' : ''; ?>>Sports</option>
                    <option value="other" <?php echo $product['category'] == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>

                <label for="product_image">Product Image (Leave blank to keep current image)</label>
                <input type="file" id="product_image" name="product_image">

                <button type="submit" class="btn-primary">Update Product</button>
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
