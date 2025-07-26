@include('home.nav')

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <svg class="mx-auto h-20 w-20 text-green-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
    </svg>
    <h1 class="text-3xl font-bold text-green-700 mb-4">Order Placed Successfully!</h1>
    <p class="text-lg text-blue-700 mb-6">Thank you for your purchase. Your order <span class="font-semibold">#{{ $order->order_number }}</span> has been received and is being processed.</p>
    <div class="bg-white rounded-lg shadow-md p-6 text-left mx-auto max-w-lg">
        <h2 class="text-xl font-semibold mb-2">Order Summary</h2>
        <ul class="divide-y divide-gray-200 mb-4">
            @foreach($order->items as $item)
                <li class="py-2 flex justify-between items-center">
                    <span>{{ $item->product_name }} <span class="text-xs text-gray-500">x{{ $item->quantity }}</span></span>
                    <span>UGX {{ number_format($item->total) }}</span>
                </li>
            @endforeach
        </ul>
        <div class="flex justify-between font-semibold">
            <span>Total</span>
            <span>UGX {{ number_format($order->total) }}</span>
        </div>
    </div>
    <a href="{{ route('home') }}" class="mt-8 inline-block bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors duration-200">Continue Shopping</a>
</div>

@include('home.footer') 