<?php
include 'db.php';

// Initialize filter variables
$category = isset($_GET['category']) ? $_GET['category'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';

// Fetch latest products
$query = "SELECT * FROM products ORDER BY created_at DESC LIMIT 10";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SellPoint - Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="animations.css">
    <script defer src="script.js"></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logo.png" alt="SellPoint Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="policies.html">Policies</a></li>
                <li><a href="plans.html">Plans</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="register.html">Register</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="filter-section">
            <form action="index.php" method="GET">
                <select name="category">
                    <option value="">Select Category</option>
                    <option value="electronics" <?php echo ($category == 'electronics') ? 'selected' : ''; ?>>Electronics</option>
                    <option value="fashion" <?php echo ($category == 'fashion') ? 'selected' : ''; ?>>Fashion</option>
                    <option value="home_appliances" <?php echo ($category == 'home_appliances') ? 'selected' : ''; ?>>Home Appliances</option>
                </select>
                <input type="number" name="min_price" placeholder="Min Price" value="<?php echo $min_price; ?>">
                <input type="number" name="max_price" placeholder="Max Price" value="<?php echo $max_price; ?>">
                <button type="submit">Search</button>
            </form>
        </section>
        <section class="product-listing">
            <h2>Latest Products</h2>
            <div class="product-container">
                <?php while ($product = mysqli_fetch_assoc($result)) { ?>
                    <div class="product-item">
                        <img src="uploads/<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p><?php echo substr($product['description'], 0, 100); ?>...</p>
                        <p><strong>Price: Ksh <?php echo $product['price']; ?></strong></p>
                        <a href="product_details.php?id=<?php echo $product['id']; ?>">View Product</a>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 SellPoint. All rights reserved.</p>
    </footer>
</body>
</html>
