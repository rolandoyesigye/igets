<x-layouts.app :title="__('Edit Product')">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h1 class="text-3xl font-bold tracking-tight">{{ __('Edit Product') }}</h1>
                <p class="text-sm text-muted-foreground">{{ __('Update the details for ') }} <span class="font-bold text-foreground">{{ $product->name }}</span></p>
            </div>
            <x-ui.button variant="outline" :href="route('products.index')" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="m15 18-6-6 6-6"/></svg>
                Back to Inventory
            </x-ui.button>
        </div>

        <x-ui.card class="p-0 overflow-hidden shadow-lg border-primary/10">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="p-6 sm:p-8 space-y-8">
                    <!-- Status Alert for Out of Stock -->
                    @if($product->isOutOfStock())
                        <div class="bg-destructive/10 border border-destructive/20 rounded-xl p-4 flex gap-3 text-destructive items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            <div class="space-y-1">
                                <p class="text-sm font-bold">{{ __('Out of Stock Alert') }}</p>
                                <p class="text-xs">{{ __('This product has been automatically deactivated because the stock quantity is zero.') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Basic Information Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/></svg>
                            <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground">{{ __('Basic Information') }}</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-ui.label for="name">{{ __('Product Name') }} <span class="text-destructive">*</span></x-ui.label>
                                <x-ui.input id="name" name="name" value="{{ old('name', $product->name) }}" required autofocus />
                                @error('name') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="brand">{{ __('Brand') }}</x-ui.label>
                                <x-ui.input id="brand" name="brand" value="{{ old('brand', $product->brand) }}" placeholder="e.g. Apple" />
                                @error('brand') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <x-ui.label for="description">{{ __('Description') }}</x-ui.label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4" 
                                class="flex min-h-[120px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            >{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Pricing & Inventory Section -->
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center gap-2 border-b pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                            <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground">{{ __('Pricing & Inventory') }}</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <x-ui.label for="price">{{ __('Sale Price (UGX)') }} <span class="text-destructive">*</span></x-ui.label>
                                <x-ui.input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" required />
                                @error('price') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="original_price">{{ __('Original Price (UGX)') }}</x-ui.label>
                                <x-ui.input type="number" id="original_price" name="original_price" value="{{ old('original_price', $product->original_price) }}" step="0.01" />
                                @error('original_price') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="stock_quantity">{{ __('Stock Quantity') }}</x-ui.label>
                                <x-ui.input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" />
                                @error('stock_quantity') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center gap-2 border-b pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M2 3h20"/><path d="M21 3v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V3"/><path d="m7 21 5-5 5 5"/></svg>
                            <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground">{{ __('Classification & Details') }}</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-ui.label for="category">{{ __('Category') }} <span class="text-destructive">*</span></x-ui.label>
                                <select id="category" name="category" required class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    <option value="">Select Category</option>
                                    <option value="laptops" {{ old('category', $product->category) == 'laptops' ? 'selected' : '' }}>Laptops</option>
                                    <option value="phones" {{ old('category', $product->category) == 'phones' ? 'selected' : '' }}>Phones</option>
                                    <option value="accessories" {{ old('category', $product->category) == 'accessories' ? 'selected' : '' }}>Accessories</option>
                                </select>
                                @error('category') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="condition">{{ __('Condition') }}</x-ui.label>
                                <select id="condition" name="condition" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                </select>
                                @error('condition') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-ui.label for="sku">{{ __('SKU (Stock Keeping Unit)') }}</x-ui.label>
                                <x-ui.input id="sku" name="sku" value="{{ old('sku', $product->sku) }}" />
                                @error('sku') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="warranty">{{ __('Warranty') }}</x-ui.label>
                                <x-ui.input id="warranty" name="warranty" value="{{ old('warranty', $product->warranty) }}" />
                                @error('warranty') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center gap-2 border-b pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground">{{ __('Product Media') }}</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                            <div class="space-y-4">
                                @if($product->image)
                                    <div class="space-y-2">
                                        <x-ui.label>{{ __('Current Image') }}</x-ui.label>
                                        <div class="aspect-square w-full max-w-[200px] relative rounded-xl overflow-hidden border shadow-sm">
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <x-ui.label for="image">{{ __('Update Main Image') }}</x-ui.label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-muted/30 hover:bg-muted/50 border-input transition-colors">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground mb-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                            <p class="mb-1 text-sm text-muted-foreground"><span class="font-semibold">Click to update</span></p>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                    </label>
                                </div>
                                <p class="text-[10px] text-muted-foreground">{{ __('Leave empty to keep the current image.') }}</p>
                                @error('image') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Visibility Section -->
                    <div class="flex flex-col sm:flex-row gap-6 pt-4">
                        <div class="flex items-center space-x-2 bg-muted/40 p-4 rounded-xl border border-border/50 flex-1">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-input text-primary focus:ring-primary">
                            <div class="grid gap-1.5 leading-none">
                                <label for="is_active" class="text-sm font-bold leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">{{ __('Active Status') }}</label>
                                <p class="text-xs text-muted-foreground">{{ __('Product will be visible in the storefront.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 bg-muted/40 p-4 rounded-xl border border-border/50 flex-1">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="h-4 w-4 rounded border-input text-primary focus:ring-primary">
                            <div class="grid gap-1.5 leading-none">
                                <label for="is_featured" class="text-sm font-bold leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">{{ __('Featured Product') }}</label>
                                <p class="text-xs text-muted-foreground">{{ __('Highlight this product on the home page.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer / Action Buttons -->
                <div class="bg-muted/20 border-t p-6 flex flex-col sm:flex-row justify-end gap-3 translate-x-0">
                    <x-ui.button variant="outline" :href="route('products.index')" wire:navigate>
                        Cancel
                    </x-ui.button>
                    <x-ui.button variant="default" type="submit" class="px-8 font-bold">
                        {{ __('Update Product Details') }}
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.app>
