<?php
/**
 * Update Products with Actual Images from assets/images/products
 */

$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'ecommerce';

$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

echo "========================================\n";
echo "Update Products with Real Images\n";
echo "========================================\n\n";

// Get vendor and category
$vendor = $mysqli->query("SELECT id FROM venders LIMIT 1")->fetch_assoc();
$category = $mysqli->query("SELECT id FROM categories LIMIT 1")->fetch_assoc();

if (!$vendor || !$category) {
    die("Vendor or category not found!\n");
}

$vendorId = $vendor['id'];
$categoryId = $category['id'];

// Delete existing products
echo "Clearing existing products...\n";
$mysqli->query("DELETE FROM products");
echo "✓ Existing products cleared\n\n";

// Products matching the 10 images in assets/images/products
$products = [
    [
        'p_name' => 'Premium Wireless Headphones',
        'p_price' => '2999',
        'p_stock' => '50',
        'p_description' => 'High-quality wireless headphones with noise cancellation and premium sound quality',
        'p_image' => 'assets/images/products/1.jpg'
    ],
    [
        'p_name' => 'Smart Watch Pro',
        'p_price' => '4999',
        'p_stock' => '35',
        'p_description' => 'Advanced smartwatch with fitness tracking and heart rate monitor',
        'p_image' => 'assets/images/products/2.jpg'
    ],
    [
        'p_name' => 'Bluetooth Speaker',
        'p_price' => '1599',
        'p_stock' => '60',
        'p_description' => 'Portable bluetooth speaker with crystal clear sound and deep bass',
        'p_image' => 'assets/images/products/3.jpg'
    ],
    [
        'p_name' => 'Gaming Mouse RGB',
        'p_price' => '1299',
        'p_stock' => '45',
        'p_description' => 'Professional gaming mouse with customizable RGB lighting',
        'p_image' => 'assets/images/products/4.jpg'
    ],
    [
        'p_name' => 'Mechanical Keyboard',
        'p_price' => '3499',
        'p_stock' => '30',
        'p_description' => 'RGB mechanical keyboard with blue switches for gaming and typing',
        'p_image' => 'assets/images/products/5.jpg'
    ],
    [
        'p_name' => 'Webcam HD 1080p',
        'p_price' => '1999',
        'p_stock' => '40',
        'p_description' => 'Full HD webcam with auto-focus and built-in microphone',
        'p_image' => 'assets/images/products/6.jpg'
    ],
    [
        'p_name' => 'USB-C Hub 7-in-1',
        'p_price' => '1499',
        'p_stock' => '55',
        'p_description' => 'Multiport USB-C hub with HDMI, USB 3.0, and SD card reader',
        'p_image' => 'assets/images/products/7.jpg'
    ],
    [
        'p_name' => 'Power Bank 20000mAh',
        'p_price' => '1999',
        'p_stock' => '70',
        'p_description' => 'High-capacity power bank with fast charging support',
        'p_image' => 'assets/images/products/8.jpg'
    ],
    [
        'p_name' => 'Phone Stand Adjustable',
        'p_price' => '599',
        'p_stock' => '100',
        'p_description' => 'Premium aluminum phone stand with adjustable viewing angles',
        'p_image' => 'assets/images/products/9.jpg'
    ],
    [
        'p_name' => 'Laptop Stand Ergonomic',
        'p_price' => '1699',
        'p_stock' => '40',
        'p_description' => 'Aluminum laptop stand with ventilation for better cooling',
        'p_image' => 'assets/images/products/10.jpg'
    ],
];

echo "Adding products with real images...\n";

foreach ($products as $product) {
    $name = $mysqli->real_escape_string($product['p_name']);
    $price = $product['p_price'];
    $stock = $product['p_stock'];
    $desc = $mysqli->real_escape_string($product['p_description']);
    $image = $product['p_image'];
    
    $query = "INSERT INTO products (v_id, p_name, p_price, c_id, p_stock, p_description, p_image, created_at, updated_at)
              VALUES ('$vendorId', '$name', '$price', '$categoryId', '$stock', '$desc', '$image', NOW(), NOW())";
    
    if ($mysqli->query($query)) {
        echo "✓ Added: $name (₹$price) - $image\n";
    } else {
        echo "✗ Error: " . $mysqli->error . "\n";
    }
}

echo "\n========================================\n";
echo "Summary\n";
echo "========================================\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM products")->fetch_assoc();
echo "Total Products: " . $result['count'] . " ✓\n";

echo "\nProduct List:\n";
$products = $mysqli->query("SELECT p_name, p_price, p_image FROM products ORDER BY p_id");
while ($row = $products->fetch_assoc()) {
    echo "  • {$row['p_name']} - ₹{$row['p_price']}\n";
}

echo "\n✓ Setup Complete!\n";
echo "========================================\n";

$mysqli->close();
?>
