<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product; // assuming your model is Product

class ProductSearch extends Component
{
    public $query = '';
    public $products = [];

    public function updatedQuery()
    {
        $this->products = Product::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('description', 'like', '%' . $this->query . '%')
            ->take(5) // limit results
            ->get();
    }

    public function render()
    {
        return view('livewire.product-search');
    }
}

