<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

// Create new sessions table
echo "Creating new sessions table...\n";
$createTableSQL = "CREATE TABLE `sessions` (
    `id` varchar(255) NOT NULL,
    `user_id` bigint unsigned DEFAULT NULL,
    `ip_address` varchar(45) DEFAULT NULL,
    `user_agent` text DEFAULT NULL,
    `payload` longtext NOT NULL,
    `last_activity` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($mysqli->query($createTableSQL)) {
    echo "✓ Sessions table created successfully!\n";
} else {
    echo "Error creating sessions table: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
