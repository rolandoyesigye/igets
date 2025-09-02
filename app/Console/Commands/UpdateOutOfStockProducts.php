<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class UpdateOutOfStockProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-out-of-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products with zero stock to be inactive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for products with zero stock...');

        $outOfStockProducts = Product::where('stock_quantity', '<=', 0)
                                    ->where('is_active', true)
                                    ->get();

        if ($outOfStockProducts->isEmpty()) {
            $this->info('No products found that need to be updated.');
            return 0;
        }

        $this->info("Found {$outOfStockProducts->count()} products with zero stock that need to be deactivated.");

        $updatedCount = 0;
        foreach ($outOfStockProducts as $product) {
            $product->update(['is_active' => false]);
            $this->line("Deactivated: {$product->name} (ID: {$product->id})");
            $updatedCount++;
        }

        $this->info("Successfully updated {$updatedCount} products to inactive status.");

        return 0;
    }
}
