<x-layouts.app>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">Order #{{ $order->order_number }}</h2>
                        <p class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        Back to Orders
                    </a>
                </div>

                <!-- Order Status Update -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3">Update Order Status</h3>
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">
                            Update Status
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Customer Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Customer Information</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="font-medium">Name:</span> {{ $order->first_name }} {{ $order->last_name }}
                            </div>
                            <div>
                                <span class="font-medium">Email:</span> {{ $order->email }}
                            </div>
                            <div>
                                <span class="font-medium">Phone:</span> {{ $order->phone }}
                            </div>
                            <div>
                                <span class="font-medium">Address:</span> {{ $order->address }}
                            </div>
                            <div>
                                <span class="font-medium">City:</span> {{ $order->city }}
                            </div>
                            <div>
                                <span class="font-medium">Postal Code:</span> {{ $order->postal_code }}
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Order Summary</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="font-medium">Order Number:</span> {{ $order->order_number }}
                            </div>
                            <div>
                                <span class="font-medium">Payment Method:</span> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                            </div>
                            <div>
                                <span class="font-medium">Status:</span> 
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium">Subtotal:</span> UGX {{ number_format($order->subtotal) }}
                            </div>
                            <div>
                                <span class="font-medium">Shipping:</span> UGX {{ number_format($order->shipping) }}
                            </div>
                            <div class="text-lg font-bold">
                                <span class="font-medium">Total:</span> UGX {{ number_format($order->total) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3">Order Items</h3>
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                            @if($item->product)
                                                <div class="text-sm text-gray-500">SKU: {{ $item->product->id }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            UGX {{ number_format($item->price) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            UGX {{ number_format($item->total) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>