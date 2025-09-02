<x-layouts.app :title="__('Products')">
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Products Management</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your product inventory</p>
            </div>
            <a href="{{ route('products.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Add Product</span>
            </a>
        </div>

        <!-- Flash Messages -->


        <!-- DataTable Container -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <table id="productsTable" class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Image</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Category</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Brand</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Price</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Stock</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="py-3 px-4">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            <a href="{{ route('home.show', $product) }}" class="hover:text-blue-600 transition-colors">
                                                {{ $product->name }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $product->sku }}</div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $product->category }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-gray-900 dark:text-white">
                                    {{ $product->brand ?? 'N/A' }}
                                </td>
                                <td class="py-3 px-4">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">UGX {{ number_format($product->price) }}</div>
                                        @if($product->original_price && $product->original_price > $product->price)
                                            <div class="text-sm text-gray-500 line-through">UGX {{ number_format($product->original_price) }}</div>
                                            @if($product->discount_percentage)
                                                <div class="text-xs text-green-600 font-medium">-{{ $product->discount_percentage }}%</div>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $product->isOutOfStock() ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                           'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                        {{ $product->stock_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if($product->isOutOfStock())
                                        <div class="mt-1">
                                            <span class="text-xs text-red-600 font-medium">Auto-disabled due to zero stock</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                    title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                responsive: true,
                pageLength: 10,
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
                        targets: [0, 7], // Image and Actions columns
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4"lf>rt<"flex flex-col sm:flex-row justify-between items-center mt-4"ip>',
                initComplete: function() {
                    // Add custom styling to DataTables elements
                    $('.dataTables_wrapper').addClass('text-gray-900 dark:text-white');
                    $('.dataTables_filter input').addClass('px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white');
                    $('.dataTables_length select').addClass('px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white');
                    $('.dataTables_paginate .paginate_button').addClass('px-3 py-2 mx-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white');
                    $('.dataTables_paginate .paginate_button.current').addClass('bg-blue-600 text-white border-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:border-blue-600 dark:hover:bg-blue-700');
                }
            });
        });
    </script>
</x-layouts.app>