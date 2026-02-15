<?php
/**
 * Update image paths to use storage folder
 */

$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

echo "========================================\n";
echo "Update Image Paths to Storage\n";
echo "========================================\n\n";

// Update banner images
echo "Updating banner images...\n";
for ($i = 1; $i <= 4; $i++) {
    $newPath = "banners/slider{$i}.png";
    $query = "UPDATE banners SET b_image = '$newPath' WHERE b_id = $i";
    
    if ($mysqli->query($query)) {
        echo "✓ Updated banner $i: $newPath\n";
    } else {
        echo "✗ Error updating banner $i: " . $mysqli->error . "\n";
    }
}

echo "\nUpdating product images...\n";
// Update product images
for ($i = 1; $i <= 10; $i++) {
    $newPath = "products/{$i}.jpg";
    $query = "UPDATE products SET p_image = '$newPath' WHERE p_id = $i";
    
    if ($mysqli->query($query)) {
        echo "✓ Updated product $i: $newPath\n";
    } else {
        echo "✗ Error updating product $i: " . $mysqli->error . "\n";
    }
}

echo "\n========================================\n";
echo "Verification\n";
echo "========================================\n";

echo "\nBanners:\n";
$result = $mysqli->query("SELECT b_id, b_image, b_alt FROM banners");
while ($row = $result->fetch_assoc()) {
    echo "  ID {$row['b_id']}: {$row['b_image']}\n";
}

echo "\nProducts:\n";
$result = $mysqli->query("SELECT p_id, p_name, p_image FROM products LIMIT 10");
while ($row = $result->fetch_assoc()) {
    echo "  ID {$row['p_id']}: {$row['p_name']} - {$row['p_image']}\n";
}

echo "\n✓ All paths updated to use storage!\n";
echo "========================================\n";

$mysqli->close();
?>
