<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

echo "Testing Vendor Orders Query\n";
echo "============================\n\n";

// Test with vendor ID 1 (Tech Store)
$vendorId = 1;

echo "Vendor ID: $vendorId\n\n";

// Test the query
echo "Attempting to fetch orders...\n";

try {
    $orders = Order::whereHas('order_item', function ($query) use ($vendorId) {
        $query->whereHas('product', function ($q) use ($vendorId) {
            $q->where('v_id', $vendorId);
        });
    })
    ->with(['billing', 'order_item.product'])
    ->orderByDesc('order_id')
    ->get();

    echo "Query executed successfully!\n";
    echo "Orders found: " . $orders->count() . "\n\n";

    if ($orders->count() > 0) {
        foreach ($orders as $order) {
            echo "Order ID: {$order->order_id}\n";
            echo "Order No: {$order->order_no}\n";
            echo "Status: {$order->status}\n";
            echo "Total: ₹{$order->total}\n";
            echo "Items: " . $order->order_item->count() . "\n";
            echo "---\n";
        }
    } else {
        echo "No orders found for vendor ID $vendorId\n\n";
        
        // Debug: Check all orders
        echo "Total orders in database: " . Order::count() . "\n";
        
        // Debug: Check order items with products
        $allItems = OrderItem::with('product')->get();
        echo "Total order items: " . $allItems->count() . "\n";
        
        foreach ($allItems as $item) {
            $product = $item->product;
            if ($product) {
                echo "  Item {$item->order_item_id}: Product {$product->p_id} (v_id: {$product->v_id})\n";
            } else {
                echo "  Item {$item->order_item_id}: Product ID {$item->p_id} - NO PRODUCT FOUND\n";
            }
        }
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
?>
