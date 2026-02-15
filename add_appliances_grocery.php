<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\AdminCategory;

echo "Adding Appliances and Grocery Categories\n";
echo "========================================\n\n";

// Create Appliances parent category
$appliances = AdminCategory::create([
    'c_name' => 'Appliances',
    'c_commision' => 8,
    'p_c_id' => null
]);
echo "✓ Created: Appliances (ID: {$appliances->id}, Commission: 8%)\n";

// Create Grocery parent category
$grocery = AdminCategory::create([
    'c_name' => 'Grocery',
    'c_commision' => 5,
    'p_c_id' => null
]);
echo "✓ Created: Grocery (ID: {$grocery->id}, Commission: 5%)\n";

// Create some child categories under Appliances
echo "\nCreating child categories under Appliances...\n";

$kitchen = AdminCategory::create([
    'c_name' => 'Kitchen Appliances',
    'c_commision' => 8,
    'p_c_id' => $appliances->id
]);
echo "✓ Created: Kitchen Appliances (Parent: Appliances)\n";

$home = AdminCategory::create([
    'c_name' => 'Home Appliances',
    'c_commision' => 8,
    'p_c_id' => $appliances->id
]);
echo "✓ Created: Home Appliances (Parent: Appliances)\n";

// Create some child categories under Grocery
echo "\nCreating child categories under Grocery...\n";

$food = AdminCategory::create([
    'c_name' => 'Food Items',
    'c_commision' => 5,
    'p_c_id' => $grocery->id
]);
echo "✓ Created: Food Items (Parent: Grocery)\n";

$beverages = AdminCategory::create([
    'c_name' => 'Beverages',
    'c_commision' => 5,
    'p_c_id' => $grocery->id
]);
echo "✓ Created: Beverages (Parent: Grocery)\n";

echo "\n========================================\n";
echo "Complete Category Structure:\n";
echo "========================================\n";

$allCategories = AdminCategory::whereNull('p_c_id')->orderBy('c_name')->get();
foreach ($allCategories as $parent) {
    echo "\n{$parent->c_name} (Commission: {$parent->c_commision}%)\n";
    $children = AdminCategory::where('p_c_id', $parent->id)->orderBy('c_name')->get();
    foreach ($children as $child) {
        echo "  └─ {$child->c_name} (Commission: {$child->c_commision}%)\n";
    }
}

echo "\n✓ Categories added successfully!\n";
?>
