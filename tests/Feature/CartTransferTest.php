<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Login;

class CartTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_service_transfer_functionality()
    {
        // Create a user and product
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 100.00,
            'is_active' => true
        ]);

        // Add item to session cart
        session(['cart' => [$product->id => 2]]);

        // Verify item is in session
        $this->assertTrue(session()->has('cart'));
        $this->assertEquals(2, session('cart')[$product->id]);

        // Test the transfer
        $cartService = new CartService();
        $cartService->transferSessionToUser($user->id);

        // Verify item was transferred to database
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100.00
        ]);

        // Verify session cart was cleared
        $this->assertFalse(session()->has('cart'));
    }

    public function test_cart_service_merge_functionality()
    {
        // Create a user and product
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 100.00,
            'is_active' => true
        ]);

        // Add item to user's database cart
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 100.00
        ]);

        // Add same item to session cart
        session(['cart' => [$product->id => 3]]);

        // Test the transfer
        $cartService = new CartService();
        $cartService->transferSessionToUser($user->id);

        // Verify quantities were merged
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 4, // 1 + 3
            'price' => 100.00
        ]);

        // Verify only one cart item exists (not duplicated)
        $this->assertEquals(1, Cart::where('user_id', $user->id)->count());
    }

    public function test_cart_add_functionality()
    {
        // Create a product
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 100.00,
            'is_active' => true
        ]);

        // Add item to cart as guest
        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response->assertRedirect();
        $this->assertTrue(session()->has('cart'));
        $this->assertEquals(2, session('cart')[$product->id]);
    }

    public function test_login_event_triggers_cart_transfer()
    {
        // Create a user and product
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 100.00,
            'is_active' => true
        ]);

        // Add item to session cart
        session(['cart' => [$product->id => 2]]);

        // Verify item is in session
        $this->assertTrue(session()->has('cart'));
        $this->assertEquals(2, session('cart')[$product->id]);

        // Simulate login event
        event(new Login('web', $user, false));

        // Verify item was transferred to database
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100.00
        ]);

        // Verify session cart was cleared
        $this->assertFalse(session()->has('cart'));
    }
} 