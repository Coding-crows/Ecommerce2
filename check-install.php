<?php
// Check if vendor/autoload.php exists
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "✓ vendor/autoload.php exists\n";
    echo "✓ Composer dependencies are properly installed\n";
} else {
    echo "✗ vendor/autoload.php is missing\n";
    echo "Running composer install...\n";
    exec('composer install 2>&1', $output, $return_code);
    foreach ($output as $line) {
        echo $line . "\n";
    }
    if ($return_code === 0) {
        echo "\n✓ Composer install completed successfully\n";
    } else {
        echo "\n✗ Composer install failed with code: $return_code\n";
    }
}

// Check if the symphony deprecation-contracts file exists
$file = __DIR__ . '/vendor/symfony/deprecation-contracts/function.php';
if (file_exists($file)) {
    echo "✓ symfony/deprecation-contracts/function.php exists\n";
} else {
    echo "✗ symfony/deprecation-contracts/function.php is missing\n";
}
?>
