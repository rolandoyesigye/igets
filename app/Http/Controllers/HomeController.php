<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with Jumia promo content
     */
    public function index()
    {
        // You can pass data to the view here if needed
        $data = [
            'pageTitle' => 'Jumia Promo - Electronics Deals',
            'promoPeriod' => '26 May – 22 June',
            'discountPercentage' => '70%',
        ];

        return view('home.index', $data);
    }
} 