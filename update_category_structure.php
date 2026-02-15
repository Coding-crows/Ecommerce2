<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\AdminCategory;
use App\Models\Product;

echo "Setting up Parent-Child Category Structure\n";
echo "===========================================\n\n";

// Clear existing categories and create new hierarchy
echo "Clearing existing categories...\n";
AdminCategory::query()->delete();

// Create parent categories
echo "\nCreating parent categories...\n";
$electronics = AdminCategory::create([
    'c_name' => 'Electronics',
    'c_commision' => 7,
    'p_c_id' => null
]);
echo "✓ Created: Electronics (ID: {$electronics->id})\n";

$accessories = AdminCategory::create([
    'c_name' => 'Accessories',
    'c_commision' => 10,
    'p_c_id' => null
]);
echo "✓ Created: Accessories (ID: {$accessories->id})\n";

// Create child categories under Electronics
echo "\nCreating child categories under Electronics...\n";
$audio = AdminCategory::create([
    'c_name' => 'Audio',
    'c_commision' => 8,
    'p_c_id' => $electronics->id
]);
echo "✓ Created: Audio (Parent: Electronics)\n";

$computers = AdminCategory::create([
    'c_name' => 'Computers',
    'c_commision' => 5,
    'p_c_id' => $electronics->id
]);
echo "✓ Created: Computers (Parent: Electronics)\n";

$mobileDevices = AdminCategory::create([
    'c_name' => 'Mobile Devices',
    'c_commision' => 6,
    'p_c_id' => $electronics->id
]);
echo "✓ Created: Mobile Devices (Parent: Electronics)\n";

// Update existing products with proper categories
echo "\nUpdating product categories...\n";

$productCategories = [
    'Premium Wireless Headphones' => $audio->id,
    'Smart Watch Pro' => $mobileDevices->id,
    'Bluetooth Speaker' => $audio->id,
    'Gaming Mouse RGB' => $computers->id,
    'Mechanical Keyboard' => $computers->id,
    'Webcam HD 1080p' => $computers->id,
    'USB-C Hub 7-in-1' => $accessories->id,
    'Power Bank 20000mAh' => $accessories->id,
    'Phone Stand Adjustable' => $accessories->id,
    'Laptop Stand Ergonomic' => $accessories->id,
];

foreach ($productCategories as $productName => $categoryId) {
    $updated = Product::where('p_name', $productName)->update(['c_id' => $categoryId]);
    if ($updated) {
        echo "✓ Updated: $productName\n";
    }
}

echo "\n===========================================\n";
echo "Final Category Structure:\n";
echo "===========================================\n";

$allCategories = AdminCategory::with('parent')->get();
foreach ($allCategories as $cat) {
    $parent = $cat->parent ? $cat->parent->c_name : 'ROOT';
    echo "{$cat->c_name} (Parent: $parent, Commission: {$cat->c_commision}%)\n";
}

echo "\n✓ Category structure updated successfully!\n";
?>
