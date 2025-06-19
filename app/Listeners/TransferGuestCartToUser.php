<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class TransferGuestCartToUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Only proceed if user is authenticated
        $user = $event->user ?? Auth::user();
        if (!$user) return;

        $cart = session('cart', []);
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_active) {
                $cartItem = Cart::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->first();
                if ($cartItem) {
                    $cartItem->quantity += $quantity;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'session_id' => session()->getId(),
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                }
            }
        }
        // Clear guest cart from session
        session()->forget('cart');
    }
}
