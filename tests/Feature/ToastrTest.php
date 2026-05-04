<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToastrTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_toast_notification()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['success' => 'Test success message'])
            ->get('/cart');

        $response->assertStatus(200);
        $response->assertSee('toastr.success');
        $response->assertSee('Test success message');
    }

    public function test_error_toast_notification()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['error' => 'Test error message'])
            ->get('/cart');

        $response->assertStatus(200);
        $response->assertSee('toastr.error');
        $response->assertSee('Test error message');
    }

    public function test_toastr_css_and_js_loaded()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('toastr.min.css');
        $response->assertSee('toastr.min.js');
    }

    public function test_cart_controller_uses_toastr()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'is_active' => true,
            'stock_quantity' => 10,
        ]);

        $response = $this->actingAs($user)
            ->from(route('home.show', $product->id))
            ->post('/cart/add', [
                'product_id' => $product->id,
                'quantity' => 1,
            ]);

        $response->assertRedirect();
        
        $hasSuccess = $response->getSession()->has('success');
        $hasFlasher = $response->getSession()->has('flasher::envelopes');
        
        $this->assertTrue($hasSuccess || $hasFlasher, 'Neither success session nor flasher envelopes found');

        if ($hasFlasher && !$hasSuccess) {
            $envelopes = $response->getSession()->get('flasher::envelopes');
            $envelope = is_string($envelopes[0]) ? unserialize($envelopes[0]) : $envelopes[0];
            
            $this->assertEquals('success', $envelope->getNotification()->getType());
            $this->assertStringContainsString('Product added to cart successfully!', $envelope->getNotification()->getMessage());
        }
    }
}
