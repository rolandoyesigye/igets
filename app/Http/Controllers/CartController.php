<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
        }

        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('product')
                        ->get();

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

        $product = Product::findOrFail($request->product_id);
        
        if (!$product->is_active) {
            return back()->with('error', 'This product is currently out of stock.');
        }

        if (Auth::check()) {
            // For authenticated users, save to database
            $cartItem = Cart::where('user_id', Auth::id())
                           ->where('product_id', $request->product_id)
                           ->first();

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $cartItem->quantity + $request->quantity
                ]);
            } else {
                Cart::create([
                    'session_id' => session()->getId(),
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $product->price
                ]);
            }
        } else {
            // For guest users, save to session
            $cart = session('cart', []);
            $productId = $request->product_id;
            
            if (isset($cart[$productId])) {
                $cart[$productId] += $request->quantity;
            } else {
                $cart[$productId] = $request->quantity;
            }
            
            session(['cart' => $cart]);
        }

        return back();
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        if (Auth::check() && $cart->user_id === Auth::id()) {
            $cart->update(['quantity' => $request->quantity]);
            return back()->with('success', 'Cart updated successfully!');
        }

        return back()->with('error', 'Unauthorized action.');
    }

    /**
     * Remove item from cart
     */
    public function remove(Cart $cart)
    {
        if (Auth::check() && $cart->user_id === Auth::id()) {
            $cart->delete();
            return back()->with('success', 'Item removed from cart!');
        }

        return back()->with('error', 'Unauthorized action.');
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

        return back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count for navigation
     */
    public function getCartCount()
    {
        $count = 0;
        
        if (Auth::check()) {
            $count = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            $count = array_sum($cart);
        }

        return response()->json(['count' => $count]);
    }
} 