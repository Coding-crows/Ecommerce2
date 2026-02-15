<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');
$result = $mysqli->query('DESCRIBE venders');

echo "Venders Table Structure:\n";
echo "========================\n";
while($col = $result->fetch_assoc()) {
    echo "Field: " . $col['Field'] . "\n";
    echo "  Type: " . $col['Type'] . "\n";
    echo "  Null: " . $col['Null'] . "\n";
    echo "  Default: " . ($col['Default'] ?? 'NULL') . "\n";
    echo "------------------------\n";
}
?>
