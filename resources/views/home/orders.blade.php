@include('home.nav')

<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>
    @if($orders->count())
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-6 py-4">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">UGX {{ number_format($order->total) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($order->status == 'pending') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'processing') bg-blue-200 text-blue-900
                                    @elseif($order->status == 'shipped') bg-blue-300 text-blue-900
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                    @elseif($order->status == 'cancelled') bg-blue-50 text-blue-400
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('checkout.success', $order) }}" class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <p class="text-blue-600">You have not placed any orders yet.</p>
    @endif
</div>

@include('home.footer')