<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with Jumia promo content
     */
    public function index()
    {
        // Fetch products by category
        $laptops = Product::where('category', 'laptops')
                         ->where('is_active', true)
                         ->latest()
                         ->take(6)
                         ->get();
        
        $accessories = Product::where('category', 'accessories')
                             ->where('is_active', true)
                             ->latest()
                             ->take(6)
                             ->get();
        
        $desktops = Product::where('category', 'desktops')
                          ->where('is_active', true)
                          ->latest()
                          ->take(6)
                          ->get();

        // You can pass data to the view here if needed
        $data = [
            'pageTitle' => 'Jumia Promo - Electronics Deals',
            'promoPeriod' => '26 May – 22 June',
            'discountPercentage' => '70%',
            'laptops' => $laptops,
            'accessories' => $accessories,
            'desktops' => $desktops,
        ];

        return view('home.index', $data);
    }

    public function show(Product $product)
    {
        // Get related products from the same category, excluding the current product
        $relatedProducts = Product::where('category', $product->category)
                                 ->where('id', '!=', $product->id)
                                 ->where('is_active', true)
                                 ->latest()
                                 ->take(4)
                                 ->get();

        return view('home.show', compact('product', 'relatedProducts'));
    }

    public function orders()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('home.orders', compact('orders'));
    }
} 