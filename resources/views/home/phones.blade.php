@include('home.nav')

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 px-4 sm:px-6 py-6">
      @forelse($products as $desktop)
      <!-- Product Card -->
        <a href="{{ route('home.show', $desktop) }}" class="block">
          <div class="relative bg-white shadow rounded p-2 hover:shadow-lg transition-shadow">
            @if($desktop->condition)
              <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">
                {{ ucfirst($desktop->condition) }}
              </span>
            @endif
            @if($desktop->image)
              <img src="{{ Storage::url($desktop->image) }}" alt="{{ $desktop->name }}" class="w-full h-32 object-cover rounded mb-2" />
            @else
              <div class="w-full h-32 bg-gray-200 rounded mb-2 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            @endif
            <h3 class="text-sm font-semibold truncate">{{ $desktop->name }}</h3>
            <p class="text-orange-600 font-bold text-sm">UGX {{ number_format($desktop->price) }}</p>
            @if($desktop->original_price && $desktop->original_price > $desktop->price)
              <p class="line-through text-xs text-gray-500">UGX {{ number_format($desktop->original_price) }}</p>
            @endif
            
            <!-- Add to Cart Button -->
            @if($desktop->is_active)
              <form action="{{ route('cart.add') }}" method="POST" class="mt-2" onclick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="product_id" value="{{ $desktop->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-orange-500 text-white text-xs py-1 px-2 rounded hover:bg-orange-600 transition-colors">
                  Add to Cart
                </button>
              </form>
            @else
              <div class="mt-2 text-center">
                <span class="text-xs text-red-600">Out of Stock</span>
              </div>
            @endif
          </div>
        </a>
      @empty
        <div class="col-span-full text-center py-8">
          <p class="text-gray-500">No Phones available at the moment.</p>
      </div>
      @endforelse
  </div>

@include('home.footer')