<x-layouts.app :title="__('Products')">
    <div class="min-h-full bg-gray-50 dark:bg-zinc-900">
        <!-- Page Header -->
        <div class="bg-white dark:bg-zinc-800 shadow-sm border-b border-gray-200 dark:border-zinc-700">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            Products Management
                        </h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Manage your product inventory and catalog
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Total Products: {{ $products->count() }}
                        </div>
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                           wire:navigate>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Product
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Products</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $products->where('is_active', true)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Out of Stock</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $products->filter(function($product) { return $product->isOutOfStock(); })->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Categories</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $products->pluck('category')->unique()->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Value</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                UGX {{ number_format($products->sum('price')) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Products</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage your entire product catalog</p>
                </div>

                <!-- Mobile Cards View (visible on small screens) -->
                <div class="block lg:hidden">
                    <div class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($products as $product)
                            <div class="p-6 space-y-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-16 h-16 object-cover rounded-xl">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $product->name }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $product->sku }}</p>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400">
                                                {{ $product->category }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Price</p>
                                        <p class="font-semibold text-gray-900 dark:text-white">UGX {{ number_format($product->price) }}</p>
                                        @if($product->original_price && $product->original_price > $product->price)
                                            <p class="text-xs text-gray-500 line-through">UGX {{ number_format($product->original_price) }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Stock Status</p>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $product->isOutOfStock() ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400' :
                                               'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400' }}">
                                            {{ $product->stock_status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-zinc-700">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400' :
                                               'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this product?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-sm font-medium transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No products found</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first product.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Desktop Table View (hidden on small screens) -->
                <div class="hidden lg:block overflow-x-auto">
                    <table id="productsTable" class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                        <thead class="bg-gray-50 dark:bg-zinc-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Image</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stock</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-12 h-12 object-cover rounded-xl">
                                        @else
                                            <div class="w-12 h-12 bg-gray-100 dark:bg-zinc-700 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                <a href="{{ route('home.show', $product) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                    {{ $product->name }}
                                                </a>
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $product->sku }}</div>
                                            @if($product->brand)
                                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ $product->brand }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400">
                                            {{ $product->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">UGX {{ number_format($product->price) }}</div>
                                            @if($product->original_price && $product->original_price > $product->price)
                                                <div class="text-sm text-gray-500 dark:text-gray-400 line-through">UGX {{ number_format($product->original_price) }}</div>
                                                @if($product->discount_percentage)
                                                    <div class="text-xs text-green-600 dark:text-green-400 font-medium">-{{ $product->discount_percentage }}%</div>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $product->isOutOfStock() ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400' :
                                               'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400' }}">
                                            {{ $product->stock_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400' :
                                                   'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            @if($product->isOutOfStock())
                                                <div class="text-xs text-red-600 dark:text-red-400 font-medium">Auto-disabled</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('products.edit', $product) }}"
                                               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors"
                                               title="Edit product">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors"
                                                        title="Delete product">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No products found</h3>
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first product.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            // Only initialize DataTable on desktop (screens wider than 1024px)
            if (window.innerWidth >= 1024) {
                $('#productsTable').DataTable({
                    responsive: true,
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    order: [[1, 'asc']], // Sort by name column
                    language: {
                        search: "Search products:",
                        lengthMenu: "Show _MENU_ products per page",
                        info: "Showing _START_ to _END_ of _TOTAL_ products",
                        infoEmpty: "Showing 0 to 0 of 0 products",
                        infoFiltered: "(filtered from _MAX_ total products)",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous"
                        }
                    },
                    columnDefs: [
                        {
                            targets: [0, 6], // Image and Actions columns
                            orderable: false,
                            searchable: false
                        }
                    ],
                    dom: '<"flex flex-col sm:flex-row justify-between items-center mb-6"lf>rt<"flex flex-col sm:flex-row justify-between items-center mt-6"ip>',
                    initComplete: function() {
                        // Add custom styling to DataTables elements
                        $('.dataTables_wrapper').addClass('text-gray-900 dark:text-white');
                        $('.dataTables_filter input').addClass('px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-zinc-700 dark:text-white');
                        $('.dataTables_length select').addClass('px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-zinc-700 dark:text-white');
                        $('.dataTables_paginate .paginate_button').addClass('px-3 py-2 mx-1 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700 hover:text-gray-700 dark:hover:text-white transition-colors');
                        $('.dataTables_paginate .paginate_button.current').addClass('!bg-indigo-600 !text-white !border-indigo-600 hover:!bg-indigo-700 dark:!bg-indigo-600 dark:!border-indigo-600 dark:hover:!bg-indigo-700');
                    }
                });
            }

            // Handle window resize to reinitialize DataTable if needed
            let resizeTimer;
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    const isDesktop = window.innerWidth >= 1024;
                    const tableExists = $.fn.DataTable.isDataTable('#productsTable');

                    if (isDesktop && !tableExists) {
                        // Initialize DataTable for desktop view
                        $('#productsTable').DataTable({
                            responsive: true,
                            pageLength: 25,
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            order: [[1, 'asc']],
                            columnDefs: [
                                {
                                    targets: [0, 6],
                                    orderable: false,
                                    searchable: false
                                }
                            ]
                        });
                    } else if (!isDesktop && tableExists) {
                        // Destroy DataTable for mobile view
                        $('#productsTable').DataTable().destroy();
                    }
                }, 250);
            });
        });
    </script>
    @endpush
</x-layouts.app>
