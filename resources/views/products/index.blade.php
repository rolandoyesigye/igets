<x-layouts.app :title="__('Products')">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-bold tracking-tight text-foreground">
                    Products Management
                </h1>
                <p class="text-sm font-medium text-muted-foreground">
                    Manage your product inventory and catalog
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col items-end px-4 border-r">
                    <span class="text-xs font-semibold text-muted-foreground uppercase tracking-wider">Total Products</span>
                    <span class="text-sm font-bold">{{ $products->count() }}</span>
                </div>
                <x-ui.button variant="default" :href="route('products.create')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Add Product
                </x-ui.button>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Active Products</h3>
                    <div class="bg-green-100 dark:bg-green-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 dark:text-green-400 font-bold"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $products->where('is_active', true)->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1">Currently live on store</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Out of Stock</h3>
                    <div class="bg-destructive/10 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-destructive"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $products->filter(fn($p) => $p->isOutOfStock())->count() }}</div>
                <p class="text-xs text-destructive font-medium mt-1">Require immediate restock</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Categories</h3>
                    <div class="bg-primary/10 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="m16.5 9.4 4.5 2.8 4.5-2.8V5.8L21 3l-4.5 2.8v3.6Z"/><path d="M21 15.9v4.9"/><path d="M3 5.8 7.5 3 12 5.8v3.6L7.5 12.2 3 9.4V5.8Z"/><path d="M3 14.6 7.5 11.8 12 14.6v3.6L7.5 21 3 18.2v-3.6Z"/><path d="m16.5 18.2 4.5 2.8 4.5-2.8v-3.6l-4.5-2.8-4.5 2.8v3.6Z"/><path d="M12 11.4 7.5 8.6 3 11.4v3.6l4.5 2.8 4.5-2.8v-3.6Z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $products->pluck('category')->unique()->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1">Product groupings</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Inventory Value</h3>
                    <div class="bg-blue-100 dark:bg-blue-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400 font-bold"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                    </div>
                </div>
                <div class="text-xl font-bold">UGX {{ number_format($products->sum('price')) }}</div>
                <p class="text-xs text-green-600 font-medium mt-1">+4.5% volume growth</p>
            </x-ui.card>
        </div>

        <!-- Products Table Section -->
        <x-ui.card class="overflow-hidden shadow-md">
            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between border-b gap-4">
                <div>
                    <h3 class="text-lg font-semibold">All Products</h3>
                    <p class="text-sm text-muted-foreground">Manage and track your entire inventory catalog.</p>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <x-ui.input placeholder="Filter products..." class="max-w-[300px]" id="tableSearch" />
                    <x-ui.button variant="outline" size="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    </x-ui.button>
                </div>
            </div>

            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b bg-muted/30">
                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground w-[80px]">Image</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Product Details</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden md:table-cell">Category</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden sm:table-cell">Inventory</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="[&_tr:last-child]:border-0">
                        @forelse($products as $product)
                            <tr class="border-b transition-colors hover:bg-muted/50 product-row" data-name="{{ strtolower($product->name) }}" data-sku="{{ strtolower($product->sku) }}">
                                <td class="p-4 align-middle">
                                    <div class="h-12 w-12 rounded-lg border bg-background flex items-center justify-center overflow-hidden">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground/40"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="font-bold text-foreground">
                                        <a href="{{ route('home.show', $product) }}" class="hover:text-primary transition-colors">
                                            {{ $product->name }}
                                        </a>
                                    </div>
                                    <div class="text-xs font-mono text-muted-foreground">{{ $product->sku }}</div>
                                    @if($product->brand)
                                        <div class="text-xs text-muted-foreground/80 mt-1 italic">{{ $product->brand }}</div>
                                    @endif
                                </td>
                                <td class="p-4 align-middle hidden md:table-cell">
                                    <x-ui.badge variant="secondary" class="font-medium">
                                        {{ $product->category }}
                                    </x-ui.badge>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="font-bold text-primary">UGX {{ number_format($product->price) }}</div>
                                    @if($product->original_price && $product->original_price > $product->price)
                                        <div class="text-xs text-muted-foreground line-through">UGX {{ number_format($product->original_price) }}</div>
                                        <div class="text-[10px] text-green-600 font-bold uppercase tracking-tighter">Save {{ $product->discount_percentage }}%</div>
                                    @endif
                                </td>
                                <td class="p-4 align-middle hidden sm:table-cell">
                                    <div class="flex flex-col gap-1">
                                        <x-ui.badge :variant="$product->isOutOfStock() ? 'destructive' : 'outline'" class="w-fit">
                                            {{ $product->stock_status }}
                                        </x-ui.badge>
                                        <span class="text-[10px] text-muted-foreground ml-1">Stock on hand</span>
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <x-ui.badge :variant="$product->is_active ? 'default' : 'secondary'">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </x-ui.badge>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-ui.button variant="ghost" size="icon" :href="route('products.edit', $product)" title="Edit" wire:navigate>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground hover:text-primary transition-colors"><path d="M12 22h6.5"/><path d="M12 14.5l6.469-6.469a1 1 0 0 0-1.414-1.414L10.586 13.086a1 1 0 0 0-.293.707V15.5h1.707a1 1 0 0 0 .707-.293Z"/></svg>
                                        </x-ui.button>
                                        <x-ui.button
                                            variant="ghost"
                                            size="icon"
                                            type="button"
                                            class="group product-delete-button"
                                            data-delete-url="{{ route('products.destroy', $product) }}"
                                            data-product-name="{{ $product->name }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground group-hover:text-destructive transition-colors"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        </x-ui.button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-24 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="bg-muted p-4 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                        </div>
                                        <h3 class="text-xl font-bold">No products found</h3>
                                        <p class="text-muted-foreground">Get started by creating your first product listing.</p>
                                        <x-ui.button :href="route('products.create')" class="mt-4" wire:navigate>Create Product</x-ui.button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
                <div class="p-6 border-t">
                    {{ $products->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>

    <x-ui.modal name="confirm-delete-product">
        <form id="product-delete-form" method="POST" action="" class="space-y-6">
            @csrf
            @method('DELETE')

            <div class="space-y-2">
                <h2 class="text-xl font-bold text-destructive">Confirm delete</h2>
                <p class="text-sm text-muted-foreground">
                    Are you sure you want to delete <span id="delete-product-name" class="font-semibold"></span>? This action cannot be undone.
                </p>
            </div>

            <div class="flex justify-end gap-3">
                <x-ui.button
                    variant="outline"
                    type="button"
                    x-on:click="$dispatch('close-modal', 'confirm-delete-product')"
                >
                    Cancel
                </x-ui.button>

                <x-ui.button variant="destructive" type="submit">
                    Delete Product
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    @push('scripts')
    <script>
        (function() {
            const initProductTable = function() {
                const searchInput = document.getElementById('tableSearch');
                const rows = document.querySelectorAll('.product-row');
                const deleteButtons = document.querySelectorAll('.product-delete-button');
                const deleteForm = document.getElementById('product-delete-form');
                const deleteProductName = document.getElementById('delete-product-name');

                if (searchInput) {
                    searchInput.addEventListener('input', function(e) {
                        const term = e.target.value.toLowerCase();

                        rows.forEach(row => {
                            const name = row.getAttribute('data-name');
                            const sku = row.getAttribute('data-sku');

                            if (name.includes(term) || sku.includes(term)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });
                }

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        if (deleteForm && deleteProductName) {
                            deleteForm.action = this.dataset.deleteUrl;
                            deleteProductName.textContent = this.dataset.productName;
                            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-delete-product' }));
                        }
                    });
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initProductTable);
            } else {
                initProductTable();
            }
        })();
    </script>
    @endpush
</x-layouts.app>
