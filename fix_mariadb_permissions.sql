-- Fix MariaDB connection permissions
-- Run this through phpMyAdmin or after starting MariaDB with skip-grant-tables

-- Grant all privileges to root user from localhost
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY '' WITH GRANT OPTION;

-- Grant all privileges to root user from 127.0.0.1
GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' IDENTIFIED BY '' WITH GRANT OPTION;

-- Create root user if it doesn't exist
CREATE USER IF NOT EXISTS 'root'@'localhost' IDENTIFIED BY '';
CREATE USER IF NOT EXISTS 'root'@'127.0.0.1' IDENTIFIED BY '';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;
