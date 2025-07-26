<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use App\Traits\ToastrNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use ToastrNotifications;

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart page
     */
    public function index()
    {
        $cartItems = $this->cartService->getItems();
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Add a product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        try {
            $this->cartService->add($request->product_id, $request->quantity);
            return $this->toastSuccess('Product added to cart successfully!');
        } catch (\Exception $e) {
            return $this->toastError($e->getMessage());
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        if ($this->cartService->update($itemId, $request->quantity)) {
            return $this->toastSuccess('Cart updated successfully!');
        }

        return $this->toastError('Failed to update cart item.');
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        if ($this->cartService->remove($itemId)) {
            return $this->toastSuccess('Item removed from cart!');
        }

        return $this->toastError('Failed to remove item from cart.');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $this->cartService->clear();
        return $this->toastSuccess('Cart cleared successfully!');
    }

    /**
     * Get cart count for navigation
     */
    public function getCartCount()
    {
        $count = $this->cartService->getCount();
        return response()->json(['count' => $count]);
    }
} 