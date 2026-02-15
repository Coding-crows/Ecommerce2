<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

echo "Updating products with correct IDs...\n\n";

$result = $mysqli->query("SELECT p_id FROM products ORDER BY p_id");
$ids = [];
while ($row = $result->fetch_assoc()) {
    $ids[] = $row['p_id'];
}

foreach ($ids as $index => $id) {
    $imageNum = $index + 1;
    if ($imageNum <= 10) {
        $newPath = "products/{$imageNum}.jpg";
        $query = "UPDATE products SET p_image = '$newPath' WHERE p_id = $id";
        
        if ($mysqli->query($query)) {
            echo "✓ Updated product ID $id with image: $newPath\n";
        }
    }
}

echo "\n✓ Done!\n";
$mysqli->close();
?>
