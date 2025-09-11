<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class ProductSearch extends Component
{
    public $query = "";
    public $products = [];
    public $showResults = false;
    public $selectedIndex = -1;

    protected $listeners = ["hideSearch" => "hideResults"];

    /**
     * Update search results when query changes
     */
    public function updatedQuery(): void
    {
        if (strlen($this->query) >= 2) {
            $this->products = Product::query()
                ->search($this->query)
                ->where("is_active", true)
                ->take(8)
                ->get();

            $this->showResults = true;
            $this->selectedIndex = -1;
        } else {
            $this->products = [];
            $this->showResults = false;
        }
    }

    /**
     * Select a product from search results
     *
     * @param int $productId
     * @return RedirectResponse
     */
    public function selectProduct(int $productId): RedirectResponse
    {
        $product = Product::query()->find($productId);
        if ($product) {
            return redirect()->route("home.show", $product->id);
        }
        return redirect()->back();
    }

    /**
     * Hide search results
     */
    public function hideResults(): void
    {
        $this->showResults = false;
    }

    /**
     * Show all search results
     */
    public function showAllResults(): RedirectResponse
    {
        if (!empty($this->query)) {
            return redirect()->route("search.results", ["q" => $this->query]);
        }
        return redirect()->back();
    }

    /**
     * Handle keyboard navigation
     *
     * @param string $key
     */
    public function handleKeydown(string $key): void
    {
        if ($key === "Escape") {
            $this->hideResults();
        } elseif ($key === "ArrowDown") {
            $this->selectedIndex = min(
                $this->selectedIndex + 1,
                count($this->products) - 1,
            );
        } elseif ($key === "ArrowUp") {
            $this->selectedIndex = max($this->selectedIndex - 1, -1);
        } elseif ($key === "Enter") {
            if (
                $this->selectedIndex >= 0 &&
                isset($this->products[$this->selectedIndex])
            ) {
                $this->selectProduct($this->products[$this->selectedIndex]->id);
            } elseif (!empty($this->query)) {
                $this->showAllResults();
            }
        }
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view("livewire.product-search");
    }
}
