<x-layouts.app :title="__('Orders')">
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Orders Management</h2>
                    <div class="text-sm text-gray-500">
                        Total Orders: {{ $orders->total() }}
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form action="{{ route('admin.orders.filter') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Order #, Name, Email, Phone"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">
                                Filter
                            </button>
                            @if(request('search') || request('status'))
                                <a href="{{ route('admin.orders.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Orders Table -->
                <div class="overflow-x-auto">
                    <table id="ordersTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->items->count() }} items</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">UGX {{ number_format($order->total) }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->payment_method }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('M d, Y') }}
                                        <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="text-orange-600 hover:text-orange-900 mr-3">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination removed because DataTables will handle it -->
            </div>
        </div>
    </div>
</div>

<!-- DataTables CSS/JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            pageLength: 10,
            order: [], // disable initial ordering
            language: {
                search: "Search orders:"
            }
        });
    });
</script>
</x-layouts.app>
