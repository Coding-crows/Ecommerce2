<?php
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'ecommerce';

echo "========================================\n";
echo "Database Schema Setup\n";
echo "========================================\n\n";

$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

echo "✓ Connected to database: $dbName\n\n";

$sqlFile = __DIR__ . '/DATABASE_SCHEMA.sql';

if (!file_exists($sqlFile)) {
    die("✗ SQL file not found: $sqlFile\n");
}

echo "Reading SQL schema file...\n";
$sql = file_get_contents($sqlFile);

if ($mysqli->multi_query($sql)) {
    echo "✓ Executing SQL statements...\n";
    
    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
    
    echo "✓ All statements executed\n\n";
} else {
    die("✗ Error: " . $mysqli->error . "\n");
}

// Verify tables
echo "Verifying tables created:\n";
$result = $mysqli->query("SHOW TABLES");
$count = 0;

$tables = [];
while ($row = $result->fetch_row()) {
    echo "  ✓ " . $row[0] . "\n";
    $tables[] = $row[0];
    $count++;
}

echo "\nTotal tables: $count\n";

// Get info for each table
echo "\nTable Structures:\n";
foreach ($tables as $table) {
    $res = $mysqli->query("SELECT COUNT(*) as col_count FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA = '$dbName'");
    $info = $res->fetch_assoc();
    echo "  - $table (" . $info['col_count'] . " columns)\n";
}

echo "\n========================================\n";
echo "✓ Setup Complete!\n";
echo "========================================\n";

$mysqli->close();
?>
