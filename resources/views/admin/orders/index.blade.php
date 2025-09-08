    <x-layouts.app :title="__('Order Management')">
        <div class="min-h-full bg-gray-50 dark:bg-zinc-900">
        <!-- Page Header -->
        <div class="bg-white dark:bg-zinc-800 shadow-sm border-b border-gray-200 dark:border-zinc-700">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            Order Management
                        </h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Manage orders, statuses, and payments across your platform.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Total Orders: {{ $orders->total() }}
                        </div>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Count</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $orders->count() }}
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
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Unprocessed</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $orders->where('status', 'pending')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Processing</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $orders->where('status', 'processing')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Delivered</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $orders->where('status', 'delivered')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Orders</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage and track all customer orders</p>
                </div>

                <div class="block lg:hidden">
                    <div class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($orders as $order)
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $order->order_number }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->items->count() }} items</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400
                                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400
                                        @elseif($order->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->first_name }} {{ $order->last_name }}</span>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->email }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->phone }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Total Amount</p>
                                        <p class="font-semibold text-gray-900 dark:text-white">UGX {{ number_format($order->total) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->payment_method }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Order Date</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('h:i A') }}</p>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-gray-200 dark:border-zinc-700">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg transition-colors"
                                       wire:navigate>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No orders found</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No orders match your current filters.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="hidden lg:block overflow-x-auto">
                    <table id="ordersTable" class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                        <thead class="bg-gray-50 dark:bg-zinc-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->order_number }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->items->count() }} items</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->first_name }} {{ $order->last_name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->email }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">UGX {{ number_format($order->total) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->payment_method }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400
                                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400
                                            @elseif($order->status == 'delivered') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400
                                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <div>{{ $order->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors"
                                           wire:navigate>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No orders found</h3>
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No orders match your current filters.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-700">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
            </x-layouts.app>

            @push('scripts')
                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
                <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
                <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

                <script>
                    $(document).ready(function() {
                        // Only initialize DataTable on desktop (screens wider than 1024px, since this uses lg:block)
                        if (window.innerWidth >= 1024) {
                            $('#ordersTable').DataTable({
                                responsive: true,
                                pageLength: 25,
                                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                order: [[4, 'desc']], // Sort by date
                                language: {
                                    search: "Search orders:",
                                    lengthMenu: "Show _MENU_ orders per page",
                                    info: "Showing _START_ to _END_ of _TOTAL_ orders",
                                    infoEmpty: "Showing 0 to 0 of 0 orders",
                                    infoFiltered: "(filtered from _MAX_ total orders)",
                                    paginate: {
                                        first: "First",
                                        last: "Last",
                                        next: "Next",
                                        previous: "Previous"
                                    }
                                },
                                columnDefs: [
                                    {
                                        targets: [5], // Actions column
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
                                const isDesktop = window.innerWidth >= 1024; // Check for lg breakpoint
                                const tableExists = $.fn.DataTable.isDataTable('#ordersTable');

                                if (isDesktop && !tableExists) {
                                    // Initialize DataTable for desktop view
                                    $('#ordersTable').DataTable({
                                        responsive: true,
                                        pageLength: 25,
                                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                        order: [[4, 'desc']],
                                        language: {
                                            search: "Search orders:",
                                            lengthMenu: "Show _MENU_ orders per page",
                                            info: "Showing _START_ to _END_ of _TOTAL_ orders",
                                            infoEmpty: "Showing 0 to 0 of 0 orders",
                                            infoFiltered: "(filtered from _MAX_ total orders)",
                                            paginate: {
                                                first: "First",
                                                last: "Last",
                                                next: "Next",
                                                previous: "Previous"
                                            }
                                        },
                                        columnDefs: [
                                            {
                                                targets: [5],
                                                orderable: false,
                                                searchable: false
                                            }
                                        ]
                                    });
                                } else if (!isDesktop && tableExists) {
                                    // Destroy DataTable for mobile view
                                    $('#ordersTable').DataTable().destroy();
                                }
                            }, 250);
                        });
                    });
                </script>
            @endpush