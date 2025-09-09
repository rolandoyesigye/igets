@extends('layouts.app')

@section('content')
@include('home.nav')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                @if(!empty($query))
                    Search Results for "{{ $query }}"
                @else
                    All Products
                @endif
            </h1>
            <p class="text-gray-600">{{ $results->total() }} products found</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Filters</h3>

                    <form method="GET" action="{{ route('search.results') }}" id="search-filters">
                        <!-- Keep current search query -->
                        <input type="hidden" name="q" value="{{ $query }}">

                        <!-- Category Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Category</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>
                                        {{ ucfirst($cat) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Brand</label>
                            <select name="brand" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Brands</option>
                                @foreach($brands as $brandOption)
                                    <option value="{{ $brandOption }}" {{ $brand === $brandOption ? 'selected' : '' }}>
                                        {{ $brandOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Price Range</label>
                            <div class="flex gap-2 mb-2">
                                <input
                                    type="number"
                                    name="min_price"
                                    value="{{ $minPrice > 0 ? $minPrice : '' }}"
                                    placeholder="Min"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <input
                                    type="number"
                                    name="max_price"
                                    value="{{ $maxPrice > 0 ? $maxPrice : '' }}"
                                    placeholder="Max"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
                            <p class="text-xs text-gray-500">Range: UGX {{ number_format($priceRange['min']) }} - UGX {{ number_format($priceRange['max']) }}</p>
                        </div>

                        <!-- Apply Filters Button -->
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                            Apply Filters
                        </button>

                        <!-- Clear Filters -->
                        <a href="{{ route('search.results', ['q' => $query]) }}" class="block text-center text-sm text-gray-500 hover:text-gray-700 mt-2">
                            Clear all filters
                        </a>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Sort Options -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ $results->count() }} of {{ $results->total() }} products</span>

                        <form method="GET" action="{{ route('search.results') }}" class="flex items-center gap-2">
                            <!-- Keep current filters -->
                            <input type="hidden" name="q" value="{{ $query }}">
                            <input type="hidden" name="category" value="{{ $category }}">
                            <input type="hidden" name="brand" value="{{ $brand }}">
                            <input type="hidden" name="min_price" value="{{ $minPrice }}">
                            <input type="hidden" name="max_price" value="{{ $maxPrice }}">

                            <label class="text-sm text-gray-600">Sort by:</label>
                            <select name="sort" onchange="this.form.submit()" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="price_low" {{ $sortBy === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ $sortBy === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Results -->
                @if($results->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($results as $product)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition duration-200">
                                <a href="{{ route('home.show', $product->id) }}" class="block">
                                    <!-- Product Image -->
                                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-48 object-cover hover:scale-105 transition duration-200">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Stock Status Overlay -->
                                        @if($product->stock_quantity <= 0)
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">Out of Stock</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-4">
                                        <div class="mb-2">
                                            <span class="text-xs text-blue-600 font-medium uppercase tracking-wide">{{ $product->category }}</span>
                                            @if($product->brand)
                                                <span class="text-xs text-gray-400 ml-2">{{ $product->brand }}</span>
                                            @endif
                                        </div>

                                        <h3 class="text-sm font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>

                                        <!-- Price -->
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="text-lg font-bold text-blue-600">{{ $product->formatted_price }}</span>
                                            @if($product->original_price && $product->original_price > $product->price)
                                                <span class="text-sm text-gray-400 line-through">{{ $product->formatted_original_price }}</span>
                                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">
                                                    -{{ $product->calculated_discount_percentage }}%
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Stock Status -->
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full {{ $product->isInStock() ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                            <span class="text-xs {{ $product->stock_status_color }}">{{ $product->stock_status }}</span>
                                        </div>
                                    </div>
                                </a>

                                <!-- Add to Cart Button -->
                                <div class="p-4 pt-0">
                                    @if($product->isInStock())
                                        <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200 text-sm font-medium">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-md cursor-not-allowed text-sm font-medium">
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $results->links() }}
                    </div>
                @else
                    <!-- No Results -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                        <p class="mt-2 text-gray-500">Try adjusting your search terms or filters</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                                Browse All Products
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('home.footer')
@endsection

@push('scripts')
<script>
    // Auto-submit form when filters change
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('search-filters');
        const selects = filterForm.querySelectorAll('select');
        const inputs = filterForm.querySelectorAll('input[type="number"]');

        // Auto-submit on select change
        selects.forEach(select => {
            select.addEventListener('change', function() {
                filterForm.submit();
            });
        });

        // Auto-submit on input change with debounce
        let timeout;
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 1000); // 1 second delay
            });
        });
    });
</script>
@endpush
