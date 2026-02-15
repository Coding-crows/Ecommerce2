<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ecommerce');

echo "Making id_number and other vendor fields nullable...\n\n";

$fields = [
    'id_number',
    'business_name',
    'business_type',
    'gst_number',
    'business_category',
    'bank_account_no',
    'payment_methord',
    'image'
];

foreach ($fields as $field) {
    $query = "ALTER TABLE venders MODIFY COLUMN $field VARCHAR(255) NULL";
    
    if ($mysqli->query($query)) {
        echo "✓ Made $field nullable\n";
    } else {
        echo "✗ Error with $field: " . $mysqli->error . "\n";
    }
}

echo "\n✓ All fields updated successfully!\n";
echo "Vendors can now be created without providing all business details.\n";

$mysqli->close();
?>
