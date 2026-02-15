<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

echo "Checking order_items table structure:\n";
echo "======================================\n";

$result = $mysqli->query("DESCRIBE order_items");
while($col = $result->fetch_assoc()) {
    echo "Field: {$col['Field']} | Type: {$col['Type']} | Null: {$col['Null']} | Key: {$col['Key']}\n";
}

echo "\nSample order_items data:\n";
$result = $mysqli->query("SELECT * FROM order_items LIMIT 3");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
?>
