<x-layouts.app>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Order #{{ $order->order_number }}</h2>
                    <p class="text-gray-600 mt-1 text-sm">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="inline-block bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-700 transition">
                    ← Back to Orders
                </a>
            </div>

            <!-- Order Status Update -->
            <div class="bg-white p-6 rounded-lg shadow space-y-4">
                <h3 class="text-xl font-semibold text-gray-800">Update Order Status</h3>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-wrap gap-4 items-center">
                    @csrf
                    @method('PUT')
                    <select name="status" class="w-48 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-orange-500 text-white px-5 py-2 rounded-lg hover:bg-orange-600 transition">
                        Update
                    </button>
                </form>
            </div>

            <!-- Info Sections -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Info -->
                <div class="bg-white p-6 rounded-lg shadow space-y-2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Customer Information</h3>
                    <div><span class="font-medium">Name:</span> {{ $order->first_name }} {{ $order->last_name }}</div>
                    <div><span class="font-medium">Email:</span> {{ $order->email }}</div>
                    <div><span class="font-medium">Phone:</span> {{ $order->phone }}</div>
                    <div><span class="font-medium">Address:</span> {{ $order->address }}</div>
                    <div><span class="font-medium">City:</span> {{ $order->city }}</div>
                    <div><span class="font-medium">Postal Code:</span> {{ $order->postal_code }}</div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white p-6 rounded-lg shadow space-y-2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Order Summary</h3>
                    <div><span class="font-medium">Order Number:</span> {{ $order->order_number }}</div>
                    <div><span class="font-medium">Payment Method:</span> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                    <div class="flex items-center space-x-2">
                        <span class="font-medium">Status:</span>
                        <span class="inline-block text-xs font-semibold px-2 py-1 rounded-full
                            @class([
                                'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                                'bg-blue-100 text-blue-800' => $order->status === 'processing',
                                'bg-purple-100 text-purple-800' => $order->status === 'shipped',
                                'bg-green-100 text-green-800' => $order->status === 'delivered',
                                'bg-red-100 text-red-800' => $order->status === 'cancelled',
                            ])">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div><span class="font-medium">Subtotal:</span> UGX {{ number_format($order->subtotal) }}</div>
                    <div><span class="font-medium">Shipping:</span> UGX {{ number_format($order->shipping) }}</div>
                    <div class="text-lg font-bold text-gray-900 mt-2">
                        <span class="font-medium">Total:</span> UGX {{ number_format($order->total) }}
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Order Items</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-50 border-b text-gray-600 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Product</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">Qty</th>
                                <th class="px-6 py-3">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                                        @if($item->product)
                                            <div class="text-sm text-gray-500">SKU: {{ $item->product->id }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">UGX {{ number_format($item->price) }}</td>
                                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">UGX {{ number_format($item->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
