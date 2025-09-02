<div class="relative w-64" x-data="{ open: true }" @click.away="open = false">
    <input 
        type="text" 
        wire:model.debounce.300ms="query"
        x-on:focus="open = true"
        placeholder="Search products..." 
        class="px-3 py-2 border border-blue-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-green-400"
    />

    @if(!empty($products) && open)
        <div class="absolute z-50 bg-white border border-gray-200 mt-1 rounded-md w-full shadow-lg max-h-60 overflow-y-auto">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->id) }}" 
                   class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 transition">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="h-8 w-8 object-cover rounded">
                    <span class="text-sm text-gray-700">{{ $product->name }}</span>
                </a>
            @empty
                <div class="px-4 py-2 text-gray-500 text-sm">No results found</div>
            @endforelse
        </div>
    @endif
</div>