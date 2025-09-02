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
        
        // Check if product is active and in stock
        if (!$product->is_active) {
            throw new \Exception('This product is currently unavailable.');
        }

        if ($product->isOutOfStock()) {
            throw new \Exception('This product is out of stock.');
        }

        // Check if requested quantity is available
        if ($product->stock_quantity < $quantity) {
            throw new \Exception('Only ' . $product->stock_quantity . ' items available in stock.');
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
            $newQuantity = $cartItem->quantity + $quantity;
            
            // Check if total quantity exceeds available stock
            if ($newQuantity > $product->stock_quantity) {
                throw new \Exception('Cannot add more items. Only ' . $product->stock_quantity . ' items available in stock.');
            }
            
            $cartItem->update([
                'quantity' => $newQuantity
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
        
        $currentQuantity = isset($cart[$productId]) ? $cart[$productId] : 0;
        $newQuantity = $currentQuantity + $quantity;
        
        // Check if total quantity exceeds available stock
        if ($newQuantity > $product->stock_quantity) {
            throw new \Exception('Cannot add more items. Only ' . $product->stock_quantity . ' items available in stock.');
        }
        
        $cart[$productId] = $newQuantity;
        session(['cart' => $cart]);
        return true;
    }

    /**
     * Get cart items
     */
    public function getItems()
    {
        if (Auth::check()) {
            return Cart::with('product')
                      ->where('user_id', Auth::id())
                      ->get()
                      ->map(function ($item) {
                          // Check if product is still available
                          if (!$item->product || !$item->product->is_active || $item->product->isOutOfStock()) {
                              $item->product_available = false;
                          } else {
                              $item->product_available = true;
                          }
                          return $item;
                      });
        } else {
            $cart = session('cart', []);
            $items = collect();
            
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $item = (object) [
                        'id' => $productId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'product' => $product,
                        'product_available' => $product->is_active && !$product->isOutOfStock()
                    ];
                    $items->push($item);
                }
            }
            
            return $items;
        }
    }

    /**
     * Update cart item quantity
     */
    public function update($itemId, $quantity)
    {
        if (Auth::check()) {
            $cartItem = Cart::find($itemId);
            if (!$cartItem || $cartItem->user_id !== Auth::id()) {
                return false;
            }

            $product = $cartItem->product;
            if (!$product || !$product->is_active || $product->isOutOfStock()) {
                return false;
            }

            if ($quantity > $product->stock_quantity) {
                throw new \Exception('Only ' . $product->stock_quantity . ' items available in stock.');
            }

            $cartItem->update(['quantity' => $quantity]);
            return true;
        } else {
            $cart = session('cart', []);
            if (!isset($cart[$itemId])) {
                return false;
            }

            $product = Product::find($itemId);
            if (!$product || !$product->is_active || $product->isOutOfStock()) {
                return false;
            }

            if ($quantity > $product->stock_quantity) {
                throw new \Exception('Only ' . $product->stock_quantity . ' items available in stock.');
            }

            $cart[$itemId] = $quantity;
            session(['cart' => $cart]);
            return true;
        }
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        if (Auth::check()) {
            $cartItem = Cart::where('id', $itemId)
                           ->where('user_id', Auth::id())
                           ->first();
            
            if ($cartItem) {
                $cartItem->delete();
                return true;
            }
        } else {
            $cart = session('cart', []);
            if (isset($cart[$itemId])) {
                unset($cart[$itemId]);
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
     * Get cart total
     */
    public function getTotal()
    {
        $items = $this->getItems();
        return $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
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
} 