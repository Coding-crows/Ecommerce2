<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

echo "Checking products and vendors relationship...\n\n";

// Check products table structure
$result = $mysqli->query("DESCRIBE products");
echo "Products table columns:\n";
while($col = $result->fetch_assoc()) {
    if(strpos($col['Field'], 'v_id') !== false || strpos($col['Field'], 'vendor') !== false) {
        echo "  - {$col['Field']} ({$col['Type']}) Null: {$col['Null']}\n";
    }
}

// Check current products
echo "\nCurrent products v_id values:\n";
$result = $mysqli->query("SELECT p_id, p_name, v_id FROM products LIMIT 5");
while($row = $result->fetch_assoc()) {
    echo "  Product {$row['p_id']}: v_id = {$row['v_id']}\n";
}

// Check vendors
echo "\nVendors in database:\n";
$result = $mysqli->query("SELECT id, fullname FROM venders");
while($row = $result->fetch_assoc()) {
    echo "  Vendor ID: {$row['id']} - {$row['fullname']}\n";
}

$mysqli->close();
?>
