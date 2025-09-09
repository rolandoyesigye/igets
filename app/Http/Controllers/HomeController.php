<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\SearchAnalytics;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * Display the home page with Jumia promo content
     */
    public function index(): View
    {
        // Fetch products by category
        $laptops = Product::query()
            ->where("category", "laptops")
            ->where("is_active", true)
            ->latest()
            ->take(6)
            ->get();

        $accessories = Product::query()
            ->where("category", "accessories")
            ->where("is_active", true)
            ->latest()
            ->take(6)
            ->get();

        $phones = Product::query()
            ->where("category", "phones")
            ->where("is_active", true)
            ->latest()
            ->take(6)
            ->get();

        // You can pass data to the view here if needed
        $data = [
            "pageTitle" => "Jumia Promo - Electronics Deals",
            "promoPeriod" => "26 May – 22 June",
            "discountPercentage" => "70%",
            "laptops" => $laptops,
            "accessories" => $accessories,
            "phones" => $phones,
        ];

        return view("home.index", $data);
    }

    /**
     * Display a product
     */
    public function show(Product $product): View
    {
        // Get related products from the same category, excluding the current product
        $relatedProducts = Product::query()
            ->where("category", $product->category)
            ->where("id", "!=", $product->id)
            ->where("is_active", true)
            ->latest()
            ->take(4)
            ->get();

        return view("home.show", compact("product", "relatedProducts"));
    }

    /**
     * Display user orders
     */
    public function orders(): View
    {
        $orders = \App\Models\Order::query()
            ->where("user_id", auth()->id())
            ->with("items.product")
            ->latest()
            ->paginate(10);

        return view("home.orders", compact("orders"));
    }

    /**
     * Display laptops category
     */
    public function laptops(): View
    {
        $products = Product::query()
            ->where("category", "laptops")
            ->where("is_active", true)
            ->latest()
            ->paginate(12);
        return view("home.laptops", compact("products"));
    }

    /**
     * Display accessories category
     */
    public function accessories(): View
    {
        $products = Product::query()
            ->where("category", "accessories")
            ->where("is_active", true)
            ->latest()
            ->paginate(12);
        return view("home.accessories", compact("products"));
    }

    /**
     * Display phones category
     */
    public function phones(): View
    {
        $products = Product::query()
            ->where("category", "phones")
            ->where("is_active", true)
            ->latest()
            ->paginate(12);
        return view("home.phones", compact("products"));
    }

    /**
     * Search for products
     */
    public function search(Request $request): View
    {
        $query = $request->get("q", "");
        $category = $request->get("category", "");
        $minPrice = $request->get("min_price", 0);
        $maxPrice = $request->get("max_price", 0);
        $brand = $request->get("brand", "");
        $sortBy = $request->get("sort", "name");

        $products = Product::query()->where("is_active", true);

        // Search in name, description, brand
        if (!empty($query)) {
            $products->where(function ($q) use ($query) {
                $q->where("name", "like", "%" . $query . "%")
                    ->orWhere("description", "like", "%" . $query . "%")
                    ->orWhere("brand", "like", "%" . $query . "%")
                    ->orWhere("category", "like", "%" . $query . "%");
            });
        }

        // Filter by category
        if (!empty($category)) {
            $products->where("category", $category);
        }

        // Filter by brand
        if (!empty($brand)) {
            $products->where("brand", $brand);
        }

        // Filter by price range
        if ($minPrice > 0) {
            $products->where("price", ">=", $minPrice);
        }
        if ($maxPrice > 0) {
            $products->where("price", "<=", $maxPrice);
        }

        // Sort products
        switch ($sortBy) {
            case "price_low":
                $products->orderBy("price", "asc");
                break;
            case "price_high":
                $products->orderBy("price", "desc");
                break;
            case "newest":
                $products->orderBy("created_at", "desc");
                break;
            case "oldest":
                $products->orderBy("created_at", "asc");
                break;
            default:
                $products->orderBy("name", "asc");
        }

        $results = $products->paginate(12)->withQueryString();

        // Track search analytics
        if (!empty($query)) {
            SearchAnalytics::trackSearch(
                $query,
                $results->total(),
                auth()->id(),
            );
            SearchAnalytics::incrementTodaySearchCount();
            SearchAnalytics::updateAverageResults($results->total());
        }

        // Get filter options for the sidebar
        $categories = Product::query()
            ->where("is_active", true)
            ->distinct()
            ->pluck("category")
            ->filter()
            ->sort()
            ->values();

        $brands = Product::query()
            ->where("is_active", true)
            ->distinct()
            ->pluck("brand")
            ->filter()
            ->sort()
            ->values();

        $priceRange = [
            "min" =>
                Product::query()->where("is_active", true)->min("price") ?? 0,
            "max" =>
                Product::query()->where("is_active", true)->max("price") ?? 0,
        ];

        return view(
            "home.search",
            compact(
                "results",
                "query",
                "category",
                "brand",
                "minPrice",
                "maxPrice",
                "sortBy",
                "categories",
                "brands",
                "priceRange",
            ),
        );
    }

    /**
     * API endpoint for Ajax search suggestions
     */
    public function apiSearch(Request $request): JsonResponse
    {
        $query = $request->get("q", "");
        $category = $request->get("category", "");

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where("is_active", true)
            ->where(function ($q) use ($query) {
                $q->where("name", "like", "%" . $query . "%")
                    ->orWhere("description", "like", "%" . $query . "%")
                    ->orWhere("brand", "like", "%" . $query . "%")
                    ->orWhere("category", "like", "%" . $query . "%");
            });

        // Filter by category if provided (for context-aware search)
        if (!empty($category)) {
            $products->where("category", $category);
        }

        $products = $products
            ->take(8)
            ->get([
                "id",
                "name",
                "price",
                "original_price",
                "image",
                "category",
                "brand",
            ]);

        // Track API search analytics
        SearchAnalytics::trackSearch($query, $products->count(), auth()->id());

        return response()->json(
            $products->map(function ($product) {
                return [
                    "id" => $product->id,
                    "name" => $product->name,
                    "price" => $product->formatted_price,
                    "original_price" => $product->formatted_original_price,
                    "image" => $product->image
                        ? asset("storage/" . $product->image)
                        : null,
                    "category" => $product->category,
                    "brand" => $product->brand,
                    "url" => route("home.show", $product->id),
                ];
            }),
        );
    }

    /**
     * Get search suggestions for autocomplete
     */
    public function getSearchSuggestions(Request $request): JsonResponse
    {
        $query = $request->get("q", "");

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Get suggestions from analytics
        $analyticsSuggestions = SearchAnalytics::getSearchSuggestions(
            $query,
            5,
        );

        // Get suggestions from product names, categories, and brands
        $productSuggestions = Product::query()
            ->where("is_active", true)
            ->where(function ($q) use ($query) {
                $q->where("name", "like", "%" . $query . "%")
                    ->orWhere("category", "like", "%" . $query . "%")
                    ->orWhere("brand", "like", "%" . $query . "%");
            })
            ->distinct()
            ->limit(10)
            ->get(["name", "category", "brand"])
            ->flatMap(function ($product) {
                return collect([
                    $product->name,
                    $product->category,
                    $product->brand,
                ])
                    ->filter()
                    ->map(function ($value) {
                        return strtolower($value);
                    });
            })
            ->unique()
            ->take(8)
            ->values()
            ->toArray();

        // Combine and deduplicate suggestions
        $allSuggestions = collect($analyticsSuggestions)
            ->merge($productSuggestions)
            ->unique()
            ->take(10)
            ->values()
            ->toArray();

        return response()->json($allSuggestions);
    }
}
