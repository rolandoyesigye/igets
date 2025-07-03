<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

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
    public function handle(Login $event)
    {
        $sessionId = Session::getId();
        $user = $event->user;

        // Get all guest cart items for this session
        $guestCartItems = Cart::where('session_id', $sessionId)->get();

        foreach ($guestCartItems as $item) {
            // Check if user already has this product in their cart
            $userCartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $item->product_id)
                ->first();

            if ($userCartItem) {
                // Merge quantities
                $userCartItem->quantity += $item->quantity;
                $userCartItem->save();
                $item->delete(); // Remove guest cart item
            } else {
                // Assign guest cart item to user
                $item->user_id = $user->id;
                $item->session_id = null;
                $item->save();
            }
        }
    }
}
