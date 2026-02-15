<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

echo "Checking Orders and Products Data:\n";
echo "====================================\n\n";

// Check orders
echo "Orders:\n";
$result = $mysqli->query("SELECT order_id, user_id, order_no, status, total FROM orders LIMIT 5");
while($row = $result->fetch_assoc()) {
    echo "  Order {$row['order_id']}: {$row['order_no']} - Status: {$row['status']} - Total: ₹{$row['total']}\n";
}

// Check order items
echo "\nOrder Items:\n";
$result = $mysqli->query("SELECT order_item_id, order_id, p_id, name, price, qty FROM order_items LIMIT 5");
while($row = $result->fetch_assoc()) {
    echo "  Item {$row['order_item_id']}: Order {$row['order_id']} - Product ID: {$row['p_id']} - {$row['name']} (Qty: {$row['qty']})\n";
}

// Check products with vendor IDs
echo "\nProducts with Vendor IDs:\n";
$result = $mysqli->query("SELECT p_id, p_name, v_id FROM products LIMIT 10");
while($row = $result->fetch_assoc()) {
    echo "  Product {$row['p_id']}: {$row['p_name']} - Vendor ID: {$row['v_id']}\n";
}

// Check vendors
echo "\nVendors:\n";
$result = $mysqli->query("SELECT id, fullname FROM venders");
while($row = $result->fetch_assoc()) {
    echo "  Vendor ID: {$row['id']} - {$row['fullname']}\n";
}

$mysqli->close();
?>
