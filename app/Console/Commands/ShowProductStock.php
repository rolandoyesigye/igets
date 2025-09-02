<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ShowProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:show-stock {--category= : Filter by category}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show current stock status of all products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = Product::orderBy('category')->orderBy('name');
        
        if ($category = $this->option('category')) {
            $query->where('category', $category);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            $this->info('No products found.');
            return 0;
        }

        $this->info('Product Stock Status:');
        $this->line('');

        $headers = ['ID', 'Name', 'Category', 'Stock Qty', 'Status', 'Active'];
        $rows = [];

        foreach ($products as $product) {
            $statusColor = $product->isOutOfStock() ? 'red' : 'green';
            $statusText = $product->stock_status;
            
            $rows[] = [
                $product->id,
                $product->name,
                ucfirst($product->category),
                $product->stock_quantity,
                $this->colorize($statusText, $statusColor),
                $product->is_active ? 'Yes' : 'No'
            ];
        }

        $this->table($headers, $rows);

        // Summary
        $this->line('');
        $this->info('Summary:');
        $this->line('Total Products: ' . $products->count());
        $this->line('Out of Stock: ' . $products->where('stock_quantity', '<=', 0)->count());
        $this->line('In Stock: ' . $products->where('stock_quantity', '>', 0)->count());
        $this->line('Active Products: ' . $products->where('is_active', true)->count());

        return 0;
    }

    private function colorize($text, $color)
    {
        $colors = [
            'red' => "\033[31m",
            'green' => "\033[32m",
            'yellow' => "\033[33m",
            'reset' => "\033[0m"
        ];

        return $colors[$color] . $text . $colors['reset'];
    }
}
