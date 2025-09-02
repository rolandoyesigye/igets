<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_with_zero_stock_is_automatically_inactive()
    {
        $product = Product::factory()->create([
            'stock_quantity' => 0,
            'is_active' => true
        ]);

        // The product should automatically be set to inactive due to the model boot method
        $this->assertFalse($product->fresh()->is_active);
        $this->assertTrue($product->fresh()->isOutOfStock());
    }

    public function test_product_with_stock_is_active()
    {
        $product = Product::factory()->create([
            'stock_quantity' => 5,
            'is_active' => true
        ]);

        $this->assertTrue($product->fresh()->is_active);
        $this->assertFalse($product->fresh()->isOutOfStock());
        $this->assertTrue($product->fresh()->isInStock());
    }

    public function test_stock_status_attributes()
    {
        $outOfStockProduct = Product::factory()->create([
            'stock_quantity' => 0
        ]);

        $lowStockProduct = Product::factory()->create([
            'stock_quantity' => 5
        ]);

        $inStockProduct = Product::factory()->create([
            'stock_quantity' => 50
        ]);

        $this->assertEquals('Out of Stock', $outOfStockProduct->stock_status);
        $this->assertEquals('text-red-600', $outOfStockProduct->stock_status_color);

        $this->assertEquals('Low Stock (5 left)', $lowStockProduct->stock_status);
        $this->assertEquals('text-orange-600', $lowStockProduct->stock_status_color);

        $this->assertEquals('In Stock (50 available)', $inStockProduct->stock_status);
        $this->assertEquals('text-green-600', $inStockProduct->stock_status_color);
    }

    public function test_cannot_add_out_of_stock_product_to_cart()
    {
        $product = Product::factory()->create([
            'stock_quantity' => 0,
            'is_active' => false
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('cart.add'), [
                'product_id' => $product->id,
                'quantity' => 1
            ]);

        $response->assertStatus(422);
        $this->assertStringContainsString('out of stock', $response->getContent());
    }

    public function test_cannot_add_more_than_available_stock()
    {
        $product = Product::factory()->create([
            'stock_quantity' => 5,
            'is_active' => true
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('cart.add'), [
                'product_id' => $product->id,
                'quantity' => 10
            ]);

        $response->assertStatus(422);
        $this->assertStringContainsString('Only 5 items available', $response->getContent());
    }
}
