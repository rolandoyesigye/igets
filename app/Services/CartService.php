<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Add a product to cart
     */
    public function add($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        
        if (!$product->is_active) {
            throw new \Exception('This product is currently out of stock.');
        }

        if (Auth::check()) {
            return $this->addToDatabase($product, $quantity);
        } else {
            return $this->addToSession($product, $quantity);
        }
    }

    /**
     * Add product to database cart (authenticated users)
     */
    private function addToDatabase($product, $quantity)
    {
        $cartItem = Cart::where('user_id', Auth::id())
                       ->where('product_id', $product->id)
                       ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }

        return true;
    }

    /**
     * Add product to session cart (guest users)
     */
    private function addToSession($product, $quantity)
    {
        $cart = session('cart', []);
        $productId = $product->id;
        
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        
        session(['cart' => $cart]);
        return true;
    }

    /**
     * Get cart items
     */
    public function getItems()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())
                      ->with('product')
                      ->get();
        } else {
            return $this->getSessionItems();
        }
    }

    /**
     * Get session cart items with product details
     */
    private function getSessionItems()
    {
        $cart = session('cart', []);
        $items = collect();

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $items->push((object) [
                    'id' => 'session_' . $productId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'product' => $product,
                    'is_session_item' => true
                ]);
            }
        }

        return $items;
    }

    /**
     * Update cart item quantity
     */
    public function update($itemId, $quantity)
    {
        if (Auth::check()) {
            $cartItem = Cart::findOrFail($itemId);
            if ($cartItem->user_id === Auth::id()) {
                $cartItem->update(['quantity' => $quantity]);
                return true;
            }
        } else {
            // Handle session cart update
            if (str_starts_with($itemId, 'session_')) {
                $productId = str_replace('session_', '', $itemId);
                $cart = session('cart', []);
                if (isset($cart[$productId])) {
                    $cart[$productId] = $quantity;
                    session(['cart' => $cart]);
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        if (Auth::check()) {
            $cartItem = Cart::findOrFail($itemId);
            if ($cartItem->user_id === Auth::id()) {
                $cartItem->delete();
                return true;
            }
        } else {
            // Handle session cart removal
            if (str_starts_with($itemId, 'session_')) {
                $productId = str_replace('session_', '', $itemId);
                $cart = session('cart', []);
                unset($cart[$productId]);
                session(['cart' => $cart]);
                return true;
            }
        }

        return false;
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
        return true;
    }

    /**
     * Get cart count
     */
    public function getCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            return array_sum($cart);
        }
    }

    /**
     * Transfer session cart to user cart
     */
    public function transferSessionToUser($userId)
    {
        $sessionCart = session('cart', []);
        
        foreach ($sessionCart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                // Check if user already has this product
                $userCartItem = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                if ($userCartItem) {
                    // Merge quantities
                    $userCartItem->quantity += $quantity;
                    $userCartItem->save();
                } else {
                    // Create new cart item
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product->price
                    ]);
                }
            }
        }
        
        // Clear session cart
        session()->forget('cart');
    }
} 