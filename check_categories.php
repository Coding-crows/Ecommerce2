<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\AdminCategory;

echo "Current Categories:\n";
echo "===================\n";

$categories = AdminCategory::all();
foreach($categories as $cat) {
    echo "ID: {$cat->id} | Name: {$cat->c_name} | Parent ID: " . ($cat->p_c_id ?? 'NULL') . "\n";
}
?>
