<x-layouts.app :title="__('Order Management')">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-bold tracking-tight text-foreground">
                    Order Management
                </h1>
                <p class="text-sm font-medium text-muted-foreground">
                    Manage orders, statuses, and payments across your platform.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col items-end px-4 border-r">
                    <span class="text-xs font-semibold text-muted-foreground uppercase tracking-wider">Total Orders</span>
                    <span class="text-sm font-bold">{{ $orders->total() }}</span>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Pending Orders</h3>
                    <div class="bg-yellow-100 dark:bg-yellow-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-600 dark:text-yellow-400"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $orders->where('status', 'pending')->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1">Awaiting processing</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Processing</h3>
                    <div class="bg-blue-100 dark:bg-blue-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $orders->where('status', 'processing')->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1">Currently being handled</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Delivered</h3>
                    <div class="bg-green-100 dark:bg-green-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 dark:text-green-400"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $orders->where('status', 'delivered')->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1 text-green-600 font-medium">Completed transactions</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Total Revenue</h3>
                    <div class="bg-primary/10 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                    </div>
                </div>
                <div class="text-xl font-bold truncate">UGX {{ number_format($orders->sum('total')) }}</div>
                <p class="text-xs text-muted-foreground mt-1">Gross sales value</p>
            </x-ui.card>
        </div>

        <!-- Orders Table Section -->
        <x-ui.card class="overflow-hidden shadow-md">
            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between border-b gap-4">
                <div>
                    <h3 class="text-lg font-semibold">Orders Ledger</h3>
                    <p class="text-sm text-muted-foreground">A complete history of customer purchases and order states.</p>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <x-ui.input placeholder="Search orders..." class="max-w-[300px]" id="orderSearch" />
                </div>
            </div>

            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b bg-muted/30">
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order ID</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Customer</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden sm:table-cell">Total</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden md:table-cell">Date</th>
                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="[&_tr:last-child]:border-0">
                        @forelse($orders as $order)
                            <tr class="border-b transition-colors hover:bg-muted/50 order-row" data-id="{{ strtolower($order->order_number) }}" data-customer="{{ strtolower($order->first_name . ' ' . $order->last_name) }}">
                                <td class="p-4 align-middle">
                                    <div class="font-bold text-foreground">#{{ $order->order_number }}</div>
                                    <div class="text-xs text-muted-foreground">{{ $order->items->count() }} line items</div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex flex-col">
                                        <span class="font-bold">{{ $order->first_name }} {{ $order->last_name }}</span>
                                        <span class="text-[10px] text-muted-foreground truncate max-w-[150px]">{{ $order->email }}</span>
                                    </div>
                                </td>
                                <td class="p-4 align-middle hidden sm:table-cell font-bold text-primary">
                                    UGX {{ number_format($order->total) }}
                                </td>
                                <td class="p-4 align-middle">
                                    <x-ui.badge :variant="match($order->status) {
                                        'delivered' => 'default',
                                        'pending' => 'secondary',
                                        'cancelled' => 'destructive',
                                        'processing' => 'outline',
                                        'shipped' => 'secondary',
                                        default => 'outline'
                                    }">
                                        {{ ucfirst($order->status) }}
                                    </x-ui.badge>
                                </td>
                                <td class="p-4 align-middle hidden md:table-cell text-xs">
                                    <div class="flex flex-col">
                                        <span>{{ $order->created_at->format('M d, Y') }}</span>
                                        <span class="text-muted-foreground font-mono">{{ $order->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <x-ui.button variant="ghost" size="sm" :href="route('admin.orders.show', $order)" wire:navigate>
                                        View
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                    </x-ui.button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-24 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="bg-muted p-4 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                        </div>
                                        <h3 class="text-xl font-bold">No orders found</h3>
                                        <p class="text-muted-foreground">Try adjusting your filters or search criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->count() > 0)
                <div class="p-6 border-t">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('orderSearch');
            const rows = document.querySelectorAll('.order-row');

            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                
                rows.forEach(row => {
                    const id = row.getAttribute('data-id');
                    const customer = row.getAttribute('data-customer');
                    
                    if (id.includes(term) || customer.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
    @endpush
</x-layouts.app>