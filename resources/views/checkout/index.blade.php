@include('home.nav')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-blue-900 mb-8">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @csrf
        <!-- Shipping Details -->
        <div class="space-y-6">
            <h2 class="text-xl font-semibold mb-4">Shipping Details</h2>
            <div>
                <label class="block text-blue-700 font-medium mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->name ?? '') }}" class="w-full border border-blue-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-blue-700 font-medium mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border border-blue-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-blue-700 font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full border border-blue-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-blue-700 font-medium mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-blue-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-blue-700 font-medium mb-1">Address</label>
                <input type="text" name="address" value="{{ old('address') }}" class="w-full border border-blue-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-blue-700 font-medium mb-1">City</label>
                <input type="text" name="city" value="{{ old('city') }}" class="w-full border border-blue-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-blue-700 font-medium mb-1">Postal Code</label>
                <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="w-full border border-blue-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
        </div>

        <!-- Order Summary & Payment -->
        <div class="space-y-6">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            <div class="bg-white rounded-lg shadow-md p-4">
                <ul class="divide-y divide-blue-200 mb-4">
                    @foreach($cartItems as $item)
                        <li class="py-2 flex justify-between items-center">
                            <span>{{ $item->product->name }} <span class="text-xs text-blue-500">x{{ $item->quantity }}</span></span>
                            <span>UGX {{ number_format($item->product->price * $item->quantity) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="flex justify-between font-semibold">
                    <span>Subtotal ({{ $totalItems }} items)</span>
                    <span>UGX {{ number_format($subtotal) }}</span>
                </div>
                <div class="flex justify-between text-sm text-blue-600 mt-2">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="flex justify-between text-xl font-bold border-t pt-4 mt-4">
                    <span>Total</span>
                    <span>UGX {{ number_format($subtotal) }}</span>
                </div>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2">Payment Method</h2>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="cash_on_delivery" class="mr-2" checked>
                        <span>Cash on Delivery</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="mobile_money" class="mr-2">
                        <span>Mobile Money</span>
                    </label>
                </div>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition-colors duration-200 mt-4">
                Place Order
            </button>
        </div>
    </form>
</div>

@include('home.footer') 