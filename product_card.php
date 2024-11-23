<?php
// Example product data (replace with dynamic DB fetch logic)
$products = [
    ["title" => "Product 1", "price" => "Ksh 1,000", "image" => "../assets/images/product1.jpg"],
    ["title" => "Product 2", "price" => "Ksh 2,500", "image" => "../assets/images/product2.jpg"],
    ["title" => "Product 3", "price" => "Ksh 5,000", "image" => "../assets/images/product3.jpg"],
];

foreach ($products as $product) {
    echo "
    <div class='product-card'>
        <img src='{$product['image']}' alt='{$product['title']}'>
        <h3>{$product['title']}</h3>
        <p>{$product['price']}</p>
        <a href='product_view.php' class='btn-primary'>View Product</a>
    </div>";
}
?>
