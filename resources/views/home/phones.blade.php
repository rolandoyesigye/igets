@include('home.nav')

<!-- Category Header with Search -->
<div class="bg-white shadow-sm border-b">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Phones</h1>
        <p class="text-gray-600 text-sm">Discover the latest smartphones and mobile devices</p>
      </div>

      <!-- Category-specific search -->
      <div class="w-full sm:w-96">
        <div class="relative">
          <input
            type="text"
            placeholder="Search phones..."
            class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            onkeypress="if(event.key==='Enter') { window.location.href='{{ route('search.results') }}?q=' + encodeURIComponent(this.value) + '&category=phones'; }"
          />
          <div class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
        </div>

        <!-- Quick filter tags -->
        <div class="flex flex-wrap gap-2 mt-3">
          <a href="{{ route('search.results') }}?q=iphone&category=phones" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
            iPhone
          </a>
          <a href="{{ route('search.results') }}?q=samsung&category=phones" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
            Samsung
          </a>
          <a href="{{ route('search.results') }}?q=android&category=phones" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
            Android
          </a>
          <a href="{{ route('search.results') }}?q=smartphone&category=phones" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
            Smartphones
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 px-4 sm:px-6 py-6">
      @forelse($products as $phone)
      <!-- Product Card -->
        <a href="{{ route('home.show', $phone) }}" class="block">
          <div class="relative bg-white shadow rounded p-2 hover:transition duration-500 ease-in-out hover:bg-gray-100 transform hover:-translate-y-1 hover:scale-110">
            @if($phone->condition)
              <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">
                {{ ucfirst($phone->condition) }}
              </span>
            @endif
            @if($phone->image)
              <img src="{{ Storage::url($phone->image) }}" alt="{{ $phone->name }}" class="w-full h-32 object-cover rounded mb-2" />
            @else
              <div class="w-full h-32 bg-blue-100 rounded mb-2 flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            @endif
            <h3 class="text-sm font-semibold truncate">{{ $phone->name }}</h3>
            <p class="text-green-600 font-bold text-sm">UGX {{ number_format($phone->price) }}</p>
            @if($phone->original_price && $phone->original_price > $phone->price)
              <p class="line-through text-xs text-blue-500">UGX {{ number_format($phone->original_price) }}</p>
            @endif

            <!-- Stock Status -->
            <p class="text-xs {{ $phone->stock_status_color }} font-medium">{{ $phone->stock_status }}</p>

            <!-- Add to Cart Button -->
            @if($phone->isInStock())
              <form action="{{ route('cart.add') }}" method="POST" class="mt-2" onclick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="product_id" value="{{ $phone->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-green-500 text-white text-xs py-1 px-2 rounded hover:bg-green-600 transition-colors">
                  Add to Cart
                </button>
              </form>
            @else
              <div class="mt-2 text-center">
                <span class="text-xs text-red-600 font-medium">Out of Stock</span>
              </div>
            @endif
          </div>
        </a>
      @empty
        <div class="col-span-full text-center py-8">
          <p class="text-blue-500">No Phones available at the moment.</p>
      </div>
      @endforelse
  </div>

@include('home.footer')
