<?php
// Include the database connection
require_once("../db/db.php");

// Check if a search query is provided
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch products based on the search query
$query = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
$searchParam = "%" . $searchQuery . "%";
$query->bind_param("ss", $searchParam, $searchParam);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - SellPoint</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <div class="container">
            <h1>Search Results</h1>
            <form action="search.php" method="GET">
                <input type="text" name="search" placeholder="Search for products..." value="<?php echo $searchQuery; ?>">
                <button type="submit" class="btn-primary">Search</button>
            </form>
        </div>
    </header>

    <!-- Search Results Section -->
    <section class="search-results">
        <div class="container">
            <?php if ($result->num_rows > 0): ?>
                <div class="products-list">
                    <?php while ($product = $result->fetch_assoc()): ?>
                        <div class="product-card">
                            <img src="../uploads/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <h3><?php echo $product['name']; ?></h3>
                            <p>Ksh <?php echo $product['price']; ?></p>
                            <a href="product_view.php?product_id=<?php echo $product['id']; ?>" class="btn-primary">View Product</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No products found for your search.</p>
            <?php endif; ?>
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
