<div class="relative w-full max-w-md"
     x-data="{
        open: @entangle('showResults'),
        selectedIndex: @entangle('selectedIndex')
     }"
     @click.away="open = false; $wire.hideResults()"
     @keydown.escape.window="open = false; $wire.hideResults()"
     @keydown.arrow-down.prevent="$wire.handleKeydown('ArrowDown')"
     @keydown.arrow-up.prevent="$wire.handleKeydown('ArrowUp')"
     @keydown.enter.prevent="$wire.handleKeydown('Enter')">

    <div class="relative">
        <input
            type="text"
            wire:model.live.debounce.300ms="query"
            @focus="open = true"
            placeholder="Search products..."
            class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
            autocomplete="off"
        />

        <!-- Search Icon -->
        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <!-- Clear Button -->
        @if(!empty($query))
            <button
                type="button"
                wire:click="$set('query', '')"
                class="absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="w-4 h-4 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        @endif
    </div>

    <!-- Loading indicator -->
    <div wire:loading wire:target="query" class="absolute right-3 top-3">
        <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <!-- Search Results Dropdown -->
    <div x-show="open && {{ count($products) > 0 || !empty($query) }}"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-80 overflow-y-auto">

        @if(!empty($products))
            <!-- Products Results -->
            <div class="py-2">
                <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                    Products ({{ count($products) }})
                </div>

                @foreach($products as $index => $product)
                    <button
                        type="button"
                        wire:click="selectProduct({{ $product->id }})"
                        class="w-full flex items-center gap-3 px-4 py-3 hover:bg-blue-50 transition-colors duration-150 {{ $selectedIndex === $index ? 'bg-blue-50 border-l-2 border-blue-500' : '' }}"
                    >
                        <div class="flex-shrink-0">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-10 h-10 object-cover rounded-md border border-gray-200">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 text-left">
                            <div class="font-medium text-gray-900 truncate">
                                {{ $product->name }}
                            </div>
                            <div class="text-sm text-gray-500 flex items-center gap-2">
                                <span class="capitalize">{{ $product->category }}</span>
                                @if($product->brand)
                                    <span class="text-gray-300">•</span>
                                    <span>{{ $product->brand }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-right">
                            <div class="font-semibold text-blue-600">
                                {{ $product->formatted_price }}
                            </div>
                            @if($product->original_price && $product->original_price > $product->price)
                                <div class="text-xs text-gray-400 line-through">
                                    {{ $product->formatted_original_price }}
                                </div>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>

            <!-- Show All Results Button -->
            @if(count($products) >= 8)
                <div class="border-t border-gray-100">
                    <button
                        type="button"
                        wire:click="showAllResults"
                        class="w-full px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 font-medium transition-colors duration-150 flex items-center justify-center gap-2"
                    >
                        <span>View all results for "{{ $query }}"</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            @endif

        @elseif(!empty($query) && strlen($query) >= 2)
            <!-- No Results -->
            <div class="px-4 py-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search terms</p>
            </div>
        @elseif(!empty($query) && strlen($query) < 2)
            <!-- Minimum characters message -->
            <div class="px-4 py-3 text-sm text-gray-500 text-center">
                Type at least 2 characters to search
            </div>
        @endif
    </div>
</div>
