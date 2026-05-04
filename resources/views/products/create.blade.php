<x-layouts.app :title="__('Add Product')">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h1 class="text-3xl font-bold tracking-tight">{{ __('Add New Product') }}</h1>
                <p class="text-sm text-muted-foreground">{{ __('Create a new entry in your product catalog.') }}</p>
            </div>
            <x-ui.button variant="outline" :href="route('products.index')" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="m15 18-6-6 6-6"/></svg>
                Back to Inventory
            </x-ui.button>
        </div>

        <x-ui.card class="p-0 overflow-hidden">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="p-6 sm:p-8 space-y-8">
                    <!-- Basic Information Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/></svg>
                            <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground">{{ __('Basic Information') }}</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-ui.label for="name">{{ __('Product Name') }} <span class="text-destructive">*</span></x-ui.label>
                                <x-ui.input id="name" name="name" value="{{ old('name') }}" placeholder="e.g. MacBook Pro 14" required autofocus />
                                @error('name') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="brand">{{ __('Brand') }}</x-ui.label>
                                <x-ui.input id="brand" name="brand" value="{{ old('brand') }}" placeholder="e.g. Apple" />
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
                                placeholder="Describe the product features and specifications..."
                            >{{ old('description') }}</textarea>
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
                                <x-ui.input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" required />
                                @error('price') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="original_price">{{ __('Original Price (UGX)') }}</x-ui.label>
                                <x-ui.input type="number" id="original_price" name="original_price" value="{{ old('original_price') }}" step="0.01" />
                                @error('original_price') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="stock_quantity">{{ __('Stock Quantity') }}</x-ui.label>
                                <x-ui.input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" />
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
                                    <option value="laptops" {{ old('category') == 'laptops' ? 'selected' : '' }}>Laptops</option>
                                    <option value="phones" {{ old('category') == 'phones' ? 'selected' : '' }}>Phones</option>
                                    <option value="accessories" {{ old('category') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                                </select>
                                @error('category') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="condition">{{ __('Condition') }}</x-ui.label>
                                <select id="condition" name="condition" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="refurbished" {{ old('condition') == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                </select>
                                @error('condition') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-ui.label for="sku">{{ __('SKU (Stock Keeping Unit)') }}</x-ui.label>
                                <x-ui.input id="sku" name="sku" value="{{ old('sku') }}" placeholder="Leave empty for auto-generation" />
                                @error('sku') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <x-ui.label for="warranty">{{ __('Warranty') }}</x-ui.label>
                                <x-ui.input id="warranty" name="warranty" value="{{ old('warranty') }}" placeholder="e.g. 1 Year Manufacturers Warranty" />
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

                        <div class="grid gap-2">
                            <x-ui.label for="image">{{ __('Main Product Image') }}</x-ui.label>
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-muted/30 hover:bg-muted/50 border-input transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground mb-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                        <p class="mb-1 text-sm text-muted-foreground"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-muted-foreground/60">PNG, JPG, WEBP or GIF (MAX. 2MB)</p>
                                    </div>
                                    <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                            @error('image') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Visibility Section -->
                    <div class="flex flex-col sm:flex-row gap-6 pt-4">
                        <div class="flex items-center space-x-2 bg-muted/40 p-4 rounded-xl border border-border/50 flex-1">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-input text-primary focus:ring-primary">
                            <div class="grid gap-1.5 leading-none">
                                <label for="is_active" class="text-sm font-bold leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">{{ __('Active Status') }}</label>
                                <p class="text-xs text-muted-foreground">{{ __('Product will be visible in the storefront.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 bg-muted/40 p-4 rounded-xl border border-border/50 flex-1">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 rounded border-input text-primary focus:ring-primary">
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
                    <x-ui.button variant="default" type="submit" class="px-8">
                        {{ __('Add Product to Catalog') }}
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.app>
