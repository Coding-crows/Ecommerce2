<?php
$mysqli = new mysqli('127.0.0.1', 'root', '');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

// Drop and recreate the database
echo "Dropping ecommerce database...\n";
$mysqli->query("DROP DATABASE IF EXISTS ecommerce");

echo "Creating ecommerce database...\n";
$mysqli->query("CREATE DATABASE IF NOT EXISTS ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

$mysqli->select_db('ecommerce');

// Read and import the SQL file
$sqlFile = __DIR__ . '/Project Database/ecommerce_portal.sql';
$sql = file_get_contents($sqlFile);

echo "Importing SQL dump...\n";
if ($mysqli->multi_query($sql)) {
    while ($mysqli->more_results() && $mysqli->next_result()) {
        if (is_object($mysqli->use_result())) {
            $mysqli->use_result()->free();
        }
    }
    echo "✓ Database recreated successfully!\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}

// Verify sessions table
$result = $mysqli->query("SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'ecommerce' AND TABLE_NAME = 'sessions'");
if ($result && $result->num_rows > 0) {
    echo "✓ Sessions table confirmed to exist!\n";
} else {
    echo "✗ Sessions table still missing!\n";
}

$mysqli->close();
?>
