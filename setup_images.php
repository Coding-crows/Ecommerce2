<?php
/**
 * Setup Banners and Products with Images
 * This script adds carousel banners and product images to the database
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
echo "Setup Banners and Product Images\n";
echo "========================================\n\n";

// Sample banner images (slider images exist in public/assets/images/)
$banners = [
    ['b_image' => 'assets/images/slider1.png', 'b_alt' => 'Summer Sale - Up to 50% Off'],
    ['b_image' => 'assets/images/slider2.png', 'b_alt' => 'New Arrivals - Fresh Tech Products'],
    ['b_image' => 'assets/images/slider3.png', 'b_alt' => 'Exclusive Deals - Electronics'],
    ['b_image' => 'assets/images/slider4.png', 'b_alt' => 'Flash Sale - Limited Time Offer'],
];

// Check if banners already exist
$result = $mysqli->query("SELECT COUNT(*) as count FROM banners");
$row = $result->fetch_assoc();
$bannerCount = $row['count'];

echo "Current banners in database: $bannerCount\n";

if ($bannerCount == 0) {
    echo "\nInserting banner images...\n";
    foreach ($banners as $banner) {
        $image = $banner['b_image'];
        $alt = $banner['b_alt'];
        
        $query = "INSERT INTO banners (b_image, b_alt, created_at, updated_at) 
                  VALUES ('$image', '$alt', NOW(), NOW())";
        
        if ($mysqli->query($query)) {
            echo "✓ Banner added: $alt\n";
        } else {
            echo "✗ Error: " . $mysqli->error . "\n";
        }
    }
} else {
    echo "Banners already exist. Skipping...\n";
}

// Setup products with images if needed
echo "\n\nSetup Products with Images:\n";

// Get all categories
$categories = $mysqli->query("SELECT * FROM categories LIMIT 5");
$categoryList = [];
while ($cat = $categories->fetch_assoc()) {
    $categoryList[] = $cat;
}

// Get first vendor
$vendorResult = $mysqli->query("SELECT id FROM venders LIMIT 1");
$vendor = $vendorResult->fetch_assoc();

if (!$vendor) {
    echo "No vendors found. Creating a sample vendor...\n";
    
    $vendorQuery = "INSERT INTO venders (
        fullname, phone, email, password, address, id_number, 
        business_name, business_type, gst_number, business_category, 
        bank_account_no, payment_methord, image, status, created_at, updated_at
    ) VALUES (
        'Tech Store', '9876543210', 'vendor@techstore.com', '".password_hash('password', PASSWORD_BCRYPT)."',
        '123 Tech Street', 'ID123456789',
        'Tech Store', 'Electronics', 'GST123456', 'Electronics',
        '1234567890', 'Bank Transfer', 'vendor.jpg', 'verified', NOW(), NOW()
    )";
    
    if ($mysqli->query($vendorQuery)) {
        echo "✓ Sample vendor created\n";
        $vendor = ['id' => $mysqli->insert_id];
    } else {
        die("Error creating vendor: " . $mysqli->error . "\n");
    }
}

$vendorId = $vendor['id'];

// Sample products with images
$products = [
    [
        'p_name' => 'Wireless Headphones',
        'p_price' => '2999',
        'p_description' => 'Premium wireless headphones with noise cancellation',
        'p_image' => 'assets/images/products/headphones.jpg',
        'p_stock' => '50'
    ],
    [
        'p_name' => 'USB-C Cable',
        'p_price' => '499',
        'p_description' => 'Durable USB-C charging and data cable',
        'p_image' => 'assets/images/products/cable.jpg',
        'p_stock' => '100'
    ],
    [
        'p_name' => 'Phone Stand',
        'p_price' => '599',
        'p_description' => 'Adjustable metal phone stand for all devices',
        'p_image' => 'assets/images/products/stand.jpg',
        'p_stock' => '75'
    ],
    [
        'p_name' => 'Power Bank',
        'p_price' => '1999',
        'p_description' => '20000mAh portable power bank with fast charging',
        'p_image' => 'assets/images/products/powerbank.jpg',
        'p_stock' => '40'
    ],
    [
        'p_name' => 'Screen Protector',
        'p_price' => '299',
        'p_description' => 'Tempered glass screen protector for smartphones',
        'p_image' => 'assets/images/products/protector.jpg',
        'p_stock' => '200'
    ],
    [
        'p_name' => 'Laptop Stand',
        'p_price' => '1499',
        'p_description' => 'Ergonomic laptop stand for better posture',
        'p_image' => 'assets/images/products/laptop-stand.jpg',
        'p_stock' => '30'
    ],
];

echo "\nInserting sample products...\n";

if (count($categoryList) > 0) {
    $categoryId = $categoryList[0]['id'];
    
    // Check if products exist
    $productCount = $mysqli->query("SELECT COUNT(*) as count FROM products");
    $pcount = $productCount->fetch_assoc();
    
    if ($pcount['count'] == 0) {
        foreach ($products as $product) {
            $name = $product['p_name'];
            $price = $product['p_price'];
            $desc = $product['p_description'];
            $image = $product['p_image'];
            $stock = $product['p_stock'];
            
            $query = "INSERT INTO products (v_id, p_name, p_price, c_id, p_stock, p_description, p_image, created_at, updated_at)
                      VALUES ('$vendorId', '$name', '$price', '$categoryId', '$stock', '$desc', '$image', NOW(), NOW())";
            
            if ($mysqli->query($query)) {
                echo "✓ Product added: $name\n";
            } else {
                echo "✗ Error: " . $mysqli->error . "\n";
            }
        }
    } else {
        echo "Products already exist. Skipping...\n";
    }
} else {
    echo "No categories found. Please create categories first.\n";
}

echo "\n========================================\n";
echo "Setup Complete!\n";
echo "========================================\n";

// Verify data
echo "\nDatabase Summary:\n";
$banners_count = $mysqli->query("SELECT COUNT(*) as count FROM banners")->fetch_assoc();
$products_count = $mysqli->query("SELECT COUNT(*) as count FROM products")->fetch_assoc();
$categories_count = $mysqli->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc();

echo "Banners: " . $banners_count['count'] . "\n";
echo "Products: " . $products_count['count'] . "\n";
echo "Categories: " . $categories_count['count'] . "\n";

$mysqli->close();
?>
