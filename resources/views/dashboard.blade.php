<x-layouts.app :title="__('Dashboard')">
    <div class="min-h-full bg-gray-50 dark:bg-zinc-900">
        <!-- Page Header -->
        <div class="bg-white dark:bg-zinc-800 shadow-sm border-b border-gray-200 dark:border-zinc-700">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            Welcome back, {{ auth()->user()->name }}!
                        </h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Here's what's happening with your business today.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ now()->format('l, F j, Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-4 sm:px-6 lg:px-8 py-6 space-y-8">
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('access-dashboard'))
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                    <!-- Total Orders Card -->
                    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-zinc-700 hover:shadow-lg transition-all duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Orders</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format(\App\Models\Order::count()) }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">
                                            +12% from last month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Products Card -->
                    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-zinc-700 hover:shadow-lg transition-all duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Products</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format(\App\Models\Product::count()) }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">
                                            +8 this week
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Users Card -->
                    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-zinc-700 hover:shadow-lg transition-all duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format(\App\Models\User::count()) }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">
                                            +5% from last month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Card -->
                    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-zinc-700 hover:shadow-lg transition-all duration-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">UGX {{ number_format(\App\Models\Order::where('status', 'delivered')->sum('total')) }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">
                                            +23% from last month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-zinc-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Frequently used admin tasks</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Manage Orders -->
                            <a href="{{ route('admin.orders.index') }}"
                               class="group relative p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl border-2 border-transparent hover:border-blue-200 dark:hover:border-blue-700 hover:shadow-lg transition-all duration-200"
                               wire:navigate>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            Manage Orders
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View and manage all customer orders</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Manage Products -->
                            <a href="{{ route('products.index') }}"
                               class="group relative p-6 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl border-2 border-transparent hover:border-green-200 dark:hover:border-green-700 hover:shadow-lg transition-all duration-200"
                               wire:navigate>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                            Manage Products
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add, edit, and manage products</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Add Product -->
                            <a href="{{ route('products.create') }}"
                               class="group relative p-6 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl border-2 border-transparent hover:border-purple-200 dark:hover:border-purple-700 hover:shadow-lg transition-all duration-200"
                               wire:navigate>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                            Add New Product
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Create a new product listing</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-zinc-700">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Orders</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Latest customer orders</p>
                            </div>
                            <div class="mt-3 sm:mt-0">
                                <a href="{{ route('admin.orders.index') }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors"
                                   wire:navigate>
                                    View all orders
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                                <thead class="bg-gray-50 dark:bg-zinc-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                                    @forelse(\App\Models\Order::with('user')->latest()->take(5)->get() as $order)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $order->order_number }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->items->count() }} items</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->first_name }} {{ $order->last_name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                UGX {{ number_format($order->total) }}
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
                                                <div class="text-xs">{{ $order->created_at->format('h:i A') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors"
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
                                                    <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No orders yet</h3>
                                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No orders have been placed yet.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <!-- Non-Admin View -->
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="px-6 py-12 text-center">
                        <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-indigo-100 dark:bg-indigo-900/50">
                            <svg class="h-12 w-12 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Welcome to your Dashboard</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                            You don't have admin privileges to view detailed analytics. Contact your administrator if you need access.
                        </p>
                        <div class="mt-8">
                            <a href="{{ route('home') }}"
                               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                               wire:navigate>
                                Browse Products
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
