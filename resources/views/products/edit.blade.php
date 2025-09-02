<x-layouts.app :title="__('Edit Product')">
    <div class="max-w-4xl mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Product: {{ $product->name }}</h1>
        
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand', $product->brand) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('brand') border-red-500 @enderror">
                        @error('brand')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (UGX) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="original_price" class="block text-sm font-medium text-gray-700 mb-2">Original Price (UGX)</label>
                        <input type="number" id="original_price" name="original_price" value="{{ old('original_price', $product->original_price) }}" step="0.01"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('original_price') border-red-500 @enderror">
                        @error('original_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('stock_quantity') border-red-500 @enderror">
                        @error('stock_quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @if($product->isOutOfStock())
                            <p class="text-orange-600 text-sm mt-1">⚠️ Product will be automatically deactivated due to zero stock</p>
                        @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select id="category" name="category" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('category') border-red-500 @enderror">
                            <option value="">Select Category</option>
                            <option value="laptops" {{ old('category', $product->category) == 'laptops' ? 'selected' : '' }}>Laptops</option>
                            <option value="desktops" {{ old('category', $product->category) == 'desktops' ? 'selected' : '' }}>Phones</option>
                            <option value="accessories" {{ old('category', $product->category) == 'accessories' ? 'selected' : '' }}>Accessories</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                        <select id="condition" name="condition"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('condition') border-red-500 @enderror">
                            <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                            <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                            <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                        </select>
                        @error('condition')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU (Leave empty for auto-generation)</label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('sku') border-red-500 @enderror">
                        @error('sku')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="warranty" class="block text-sm font-medium text-gray-700 mb-2">Warranty</label>
                        <input type="text" id="warranty" name="warranty" value="{{ old('warranty', $product->warranty) }}" placeholder="e.g., 1 Year"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('warranty') border-red-500 @enderror">
                        @error('warranty')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    @if($product->image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('image') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm text-gray-700">Active Product</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm text-gray-700">Featured Product</span>
                    </label>
                </div>
                
                <!-- Stock Status Display -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Current Stock Status</h3>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $product->isOutOfStock() ? 'bg-red-100 text-red-800' : 
                               'bg-green-100 text-green-800' }}">
                            {{ $product->stock_status }}
                        </span>
                        @if($product->isOutOfStock())
                            <span class="text-sm text-red-600">⚠️ Product is currently inactive due to zero stock</span>
                        @endif
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
