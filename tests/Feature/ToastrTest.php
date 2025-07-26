<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToastrTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_toast_notification()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/cart');
            
        $response->assertStatus(200);
        $response->assertSee('toastr.success');
    }

    public function test_error_toast_notification()
    {
        $response = $this->get('/cart');
        
        $response->assertStatus(200);
        $response->assertSee('toastr.error');
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
            'is_active' => true
        ]);

        $response = $this->actingAs($user)
            ->post('/cart/add', [
                'product_id' => $product->id,
                'quantity' => 1
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
} 