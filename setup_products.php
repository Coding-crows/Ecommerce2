<?php
/**
 * Setup Categories and Products with Sample Data
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
echo "Setup Categories and Products\n";
echo "========================================\n\n";

// Check categories
$catCount = $mysqli->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc();

if ($catCount['count'] == 0) {
    echo "Creating categories...\n";
    
    $categories = [
        ['c_name' => 'Electronics', 'c_commision' => '5'],
        ['c_name' => 'Accessories', 'c_commision' => '10'],
        ['c_name' => 'Mobile Devices', 'c_commision' => '3'],
        ['c_name' => 'Computers', 'c_commision' => '4'],
        ['c_name' => 'Audio', 'c_commision' => '8'],
    ];
    
    foreach ($categories as $cat) {
        $query = "INSERT INTO categories (c_name, c_commision, created_at, updated_at)
                  VALUES ('{$cat['c_name']}', '{$cat['c_commision']}', NOW(), NOW())";
        
        if ($mysqli->query($query)) {
            echo "✓ Category added: {$cat['c_name']}\n";
        }
    }
} else {
    echo "Categories already exist: " . $catCount['count'] . "\n";
}

// Get vendor
$vendor = $mysqli->query("SELECT id FROM venders LIMIT 1")->fetch_assoc();
if (!$vendor) {
    die("No vendors found!\n");
}
$vendorId = $vendor['id'];

// Get first category
$category = $mysqli->query("SELECT id FROM categories LIMIT 1")->fetch_assoc();
if (!$category) {
    die("No categories found!\n");
}
$categoryId = $category['id'];

// Check products
$prodCount = $mysqli->query("SELECT COUNT(*) as count FROM products")->fetch_assoc();

if ($prodCount['count'] == 0) {
    echo "\nCreating sample products...\n";
    
    $products = [
        ['p_name' => 'Wireless Headphones Pro', 'p_price' => '2999', 'p_stock' => '50'],
        ['p_name' => 'USB-C Fast Charging Cable', 'p_price' => '499', 'p_stock' => '100'],
        ['p_name' => 'Adjustable Phone Stand', 'p_price' => '599', 'p_stock' => '75'],
        ['p_name' => '20000mAh Power Bank', 'p_price' => '1999', 'p_stock' => '40'],
        ['p_name' => 'Tempered Glass Screen Protector', 'p_price' => '299', 'p_stock' => '200'],
        ['p_name' => 'Ergonomic Laptop Stand', 'p_price' => '1499', 'p_stock' => '30'],
        ['p_name' => 'Portable Bluetooth Speaker', 'p_price' => '1599', 'p_stock' => '45'],
        ['p_name' => 'Wireless Mouse', 'p_price' => '799', 'p_stock' => '60'],
        ['p_name' => 'Keyboard Mechanical RGB', 'p_price' => '3499', 'p_stock' => '35'],
        ['p_name' => 'USB Hub 7 Port', 'p_price' => '899', 'p_stock' => '55'],
        ['p_name' => 'Webcam 1080p HD', 'p_price' => '1299', 'p_stock' => '40'],
        ['p_name' => 'Phone Case Protective', 'p_price' => '399', 'p_stock' => '150'],
    ];
    
    foreach ($products as $product) {
        $name = $mysqli->real_escape_string($product['p_name']);
        $price = $product['p_price'];
        $stock = $product['p_stock'];
        $desc = 'High quality ' . strtolower($name);
        $image = 'assets/images/products/product-' . rand(1, 3) . '.jpg';
        
        $query = "INSERT INTO products (v_id, p_name, p_price, c_id, p_stock, p_description, p_image, created_at, updated_at)
                  VALUES ('$vendorId', '$name', '$price', '$categoryId', '$stock', '$desc', '$image', NOW(), NOW())";
        
        if ($mysqli->query($query)) {
            echo "✓ Product added: $name\n";
        }
    }
} else {
    echo "Products already exist: " . $prodCount['count'] . "\n";
}

echo "\n========================================\n";
echo "Final Database Summary\n";
echo "========================================\n";

$result1 = $mysqli->query("SELECT COUNT(*) as count FROM banners")->fetch_assoc();
$result2 = $mysqli->query("SELECT COUNT(*) as count FROM products")->fetch_assoc();
$result3 = $mysqli->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc();
$result4 = $mysqli->query("SELECT COUNT(*) as count FROM venders")->fetch_assoc();

echo "Banners: " . $result1['count'] . " ✓\n";
echo "Categories: " . $result3['count'] . " ✓\n";
echo "Products: " . $result2['count'] . " ✓\n";
echo "Vendors: " . $result4['count'] . " ✓\n";

echo "\n✓ Setup Complete!\n";
echo "========================================\n";

$mysqli->close();
?>
