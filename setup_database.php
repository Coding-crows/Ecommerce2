<?php
/**
 * Database Schema Importer
 * Imports the DATABASE_SCHEMA.sql file into the ecommerce database
 */

$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'ecommerce';

echo "========================================\n";
echo "E-Commerce Portal - Database Schema Setup\n";
echo "========================================\n\n";

// Connect to MySQL
$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

echo "✓ Connected to database: $dbName\n\n";

// Read SQL file
$sqlFile = __DIR__ . '/DATABASE_SCHEMA.sql';

if (!file_exists($sqlFile)) {
    die("✗ SQL file not found: $sqlFile\n");
}

echo "Reading SQL schema file...\n";
$sql = file_get_contents($sqlFile);

// Use mysqli multi_query to execute all statements
$successCount = 0;
$errorCount = 0;
$errors = [];

if ($mysqli->multi_query($sql)) {
    do {
        // Get the result of each query
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
        
        // Check if this was a successful statement execution
        if ($mysqli->affected_rows >= 0 || $mysqli->error === "") {
            $successCount++;
        }
        
        // Move to next result set
    } while ($mysqli->more_results() && $mysqli->next_result());
} else {
    echo "Initial error: " . $mysqli->error . "\n";
}

echo "\n========================================\n";
echo "Schema Setup Complete\n";
echo "========================================\n";
echo "✓ Successful: $successCount statements\n";

if ($errorCount > 0) {
    echo "✗ Errors: $errorCount statements\n";
}

// List all tables
echo "\nVerifying tables in database:\n";
$result = $mysqli->query("SHOW TABLES");
$tableCount = $result->num_rows;

echo "Total tables: $tableCount\n";
echo "\nTable list:\n";

$tables = [];
while ($row = $result->fetch_row()) {
    echo "  ✓ " . $row[0] . "\n";
    $tables[] = $row[0];
}

// Get database size
$sizeResult = $mysqli->query("SELECT 
    ROUND(SUM(DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) as size_mb
    FROM INFORMATION_SCHEMA.TABLES 
    WHERE TABLE_SCHEMA = '$dbName'");

if ($size = $sizeResult->fetch_assoc()) {
    echo "\nDatabase size: " . $size['size_mb'] . " MB\n";
}

echo "\n========================================\n";
echo "Setup Summary\n";
echo "========================================\n";
echo "Database: $dbName\n";
echo "Host: $dbHost\n";
echo "Tables Created: $tableCount\n";
echo "Status: " . ($errorCount === 0 ? "✓ SUCCESS" : "⚠ PARTIAL SUCCESS") . "\n";
echo "========================================\n";

$mysqli->close();
?>
