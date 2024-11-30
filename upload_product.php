<?php
session_start();
include('db.php'); // Database connection

// Check if the user is logged in (if required)
if (!isset($_SESSION['user_logged_in'])) {
    // Redirect to login page if not logged in
    header('Location: login.html');
    exit();
}

// Check if the user has an active subscription or needs to pay
$isSubscribed = isset($_SESSION['user_subscription']) && $_SESSION['user_subscription'] === true;

// If the user doesn't have a subscription, redirect to the plans page for payment
if (!$isSubscribed) {
    // Redirect to the payment page
    header('Location: plans.html');
    exit();
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    // Handle image upload
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Allowed file extensions for images
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

    // Check if the file is a valid image
    if (in_array($imageExt, $allowedExtensions)) {
        if ($imageError === 0) {
            if ($imageSize < 1000000) { // Max file size: 1MB
                // Generate a unique file name to avoid conflicts
                $newImageName = uniqid('', true) . '.' . $imageExt;
                $imageDestination = 'uploads/' . $newImageName;

                // Move the uploaded file to the uploads directory
                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                    // Insert product data into the database
                    $sql = "INSERT INTO products (title, description, category, price, discount, image) 
                            VALUES ('$title', '$description', '$category', '$price', '$discount', '$newImageName')";

                    if (mysqli_query($conn, $sql)) {
                        echo "Product uploaded successfully!";
                        // Optionally, you can redirect to a product dashboard or list after successful upload
                        // header('Location: dashboard.php');
                        // exit();
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    echo "Failed to upload image.";
                }
            } else {
                echo "Image size is too large. Maximum size is 1MB.";
            }
        } else {
            echo "Error uploading the image.";
        }
    } else {
        echo "Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.";
    }
}

// Check if the payment was successful (after redirecting from payment page)
if (isset($_GET['payment_success']) && $_GET['payment_success'] == 'true') {
    // Set the session to indicate the user has successfully paid
    $_SESSION['user_subscription'] = true;
} elseif (!$isSubscribed) {
    // Redirect to plans page if the user hasn't paid and doesn't have a subscription
    header('Location: plans.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure you have your CSS linked -->
</head>
<body>
    <div class="upload-container">
        <h2>Upload Your Product</h2>

        <!-- Product Upload Form -->
        <form action="upload_product.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Product Title</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Product Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="home">Home</option>
                    <option value="books">Books</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="discount">Discount</label>
                <input type="number" id="discount" name="discount" required>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" name="submit">Upload Product</button>
        </form>
    </div>
</body>
</html>
