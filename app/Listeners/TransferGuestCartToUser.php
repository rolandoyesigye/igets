<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\CartService;
use Illuminate\Auth\Events\Login;

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
        // Get session cart data before it gets cleared
        $sessionCart = session('cart', []);
        
        if (!empty($sessionCart)) {
            $cartService = new CartService();
            $cartService->transferSessionToUser($event->user->id);
        }
    }
}
