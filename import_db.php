<?php
// Read the SQL file
$sqlFile = __DIR__ . '/Project Database/ecommerce_portal.sql';

if (!file_exists($sqlFile)) {
    die("SQL file not found: $sqlFile\n");
}

$sql = file_get_contents($sqlFile);

// Connect to MySQL
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

// Execute the SQL
if ($mysqli->multi_query($sql)) {
    echo "✓ Database imported successfully!\n";
    while ($mysqli->more_results() && $mysqli->next_result()) {
        if (is_object($mysqli->use_result())) {
            $mysqli->use_result()->free();
        }
    }
} else {
    die("Error executing SQL: " . $mysqli->error . "\n");
}

$mysqli->close();
?>
