<x-layouts.app :title="__('Dashboard')">
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                            <p class="mt-2 text-gray-600">Monitor store activity and manage resources</p>
                        </div>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-orange-600 text-white rounded-md shadow hover:bg-orange-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/></svg>
                            New Product
                        </a>
                    </div>

                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('access-dashboard'))
                        <!-- Admin Statistics -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                            <div class="bg-white border border-blue-100 p-5 rounded-xl shadow-sm">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-500 rounded-lg shadow-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-xs font-medium text-blue-600">Total Orders</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Order::count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white border border-green-100 p-5 rounded-xl shadow-sm">
                                <div class="flex items-center">
                                    <div class="p-2 bg-green-500 rounded-lg shadow-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-xs font-medium text-green-600">Total Products</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Product::count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white border border-yellow-100 p-5 rounded-xl shadow-sm">
                                <div class="flex items-center">
                                    <div class="p-2 bg-yellow-500 rounded-lg shadow-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-xs font-medium text-yellow-600">Total Users</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white border border-purple-100 p-5 rounded-xl shadow-sm">
                                <div class="flex items-center">
                                    <div class="p-2 bg-purple-500 rounded-lg shadow-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-xs font-medium text-purple-600">Revenue</p>
                                        <p class="text-2xl font-bold text-gray-900">UGX {{ number_format(\App\Models\Order::where('status', 'delivered')->sum('total')) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                            <a href="{{ route('admin.orders.index') }}" class="block p-6 bg-white border border-gray-200 rounded-xl hover:shadow-md transition-all hover:-translate-y-0.5">
                                <div class="flex items-center">
                                    <div class="p-2 bg-orange-500 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Manage Orders</h3>
                                        <p class="text-gray-600">View and manage all customer orders</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('products.index') }}" class="block p-6 bg-white border border-gray-200 rounded-xl hover:shadow-md transition-all hover:-translate-y-0.5">
                                <div class="flex items-center">
                                    <div class="p-2 bg-green-500 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Manage Products</h3>
                                        <p class="text-gray-600">Add, edit, and manage products</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('products.create') }}" class="block p-6 bg-white border border-gray-200 rounded-xl hover:shadow-md transition-all hover:-translate-y-0.5">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-500 rounded-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Add Product</h3>
                                        <p class="text-gray-600">Create a new product listing</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Recent Orders -->
                        <div class="mt-8">
                            <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach(\App\Models\Order::with('user')->latest()->take(5)->get() as $order)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-600 hover:text-orange-900">
                                                        {{ $order->order_number }}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $order->first_name }} {{ $order->last_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    UGX {{ number_format($order->total) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full border
                                                        @if($order->status == 'pending') bg-blue-50 text-blue-700 border-blue-200
                                                        @elseif($order->status == 'processing') bg-amber-50 text-amber-700 border-amber-200
                                                        @elseif($order->status == 'shipped') bg-indigo-50 text-indigo-700 border-indigo-200
                                                        @elseif($order->status == 'delivered') bg-green-50 text-green-700 border-green-200
                                                        @elseif($order->status == 'cancelled') bg-rose-50 text-rose-700 border-rose-200
                                                        @endif">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $order->created_at->format('M d, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Welcome to your Dashboard</h2>
                            <p class="text-gray-600">You don't have admin privileges to view this content.</p>
            </div>
                    @endif
            </div>
            </div>
        </div>
    </div>
</x-layouts.app>
