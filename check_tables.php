<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

// Check if sessions table exists
$result = $mysqli->query("SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'ecommerce' AND TABLE_NAME = 'sessions'");

if ($result && $result->num_rows > 0) {
    echo "✓ Sessions table exists!\n";
} else {
    echo "✗ Sessions table does not exist\n";
}

// List all tables
echo "\nTables in ecommerce database:\n";
$tables = $mysqli->query("SHOW TABLES");
while ($row = $tables->fetch_row()) {
    echo "  - " . $row[0] . "\n";
}

$mysqli->close();
?>
