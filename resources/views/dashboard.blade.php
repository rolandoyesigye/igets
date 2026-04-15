<x-layouts.app :title="__('Dashboard')">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-bold tracking-tight text-foreground">
                Hey, {{ explode(' ', auth()->user()->name)[0] }}!
            </h1>
            <p class="text-sm font-medium text-muted-foreground">
                {{ now()->format('l, F j, Y') }}
            </p>
        </div>

        @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('access-dashboard'))
            <!-- Statistics Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Total Orders -->
                <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                    <div class="flex items-center justify-between space-y-0 pb-2">
                        <h3 class="text-sm font-medium text-muted-foreground">Total Orders</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-muted-foreground group-hover:text-primary transition-colors"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="text-2xl font-bold">{{ number_format(\App\Models\Order::count()) }}</div>
                    <p class="text-xs text-green-600 font-medium mt-1">+12.5% from last month</p>
                </x-ui.card>

                <!-- Total Products -->
                <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                    <div class="flex items-center justify-between space-y-0 pb-2">
                        <h3 class="text-sm font-medium text-muted-foreground">Total Products</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-muted-foreground group-hover:text-primary transition-colors"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    </div>
                    <div class="text-2xl font-bold">{{ number_format(\App\Models\Product::count()) }}</div>
                    <p class="text-xs text-green-600 font-medium mt-1">+8 new added this week</p>
                </x-ui.card>

                <!-- Users -->
                <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                    <div class="flex items-center justify-between space-y-0 pb-2">
                        <h3 class="text-sm font-medium text-muted-foreground">Active Users</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-muted-foreground group-hover:text-primary transition-colors"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    </div>
                    <div class="text-2xl font-bold">{{ number_format(\App\Models\User::count()) }}</div>
                    <p class="text-xs text-green-600 font-medium mt-1">+5.2% grow rate</p>
                </x-ui.card>

                <!-- Revenue -->
                <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                    <div class="flex items-center justify-between space-y-0 pb-2">
                        <h3 class="text-sm font-medium text-muted-foreground">Total Revenue</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-4 w-4 text-muted-foreground group-hover:text-primary transition-colors"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div class="text-2xl font-bold">UGX {{ number_format(\App\Models\Order::where('status', 'delivered')->sum('total')) }}</div>
                    <p class="text-xs text-green-600 font-medium mt-1">+23% vs last quarter</p>
                </x-ui.card>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
                <!-- Recent Orders Table -->
                <x-ui.card class="col-span-4 overflow-hidden">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Recent Orders</h3>
                            <p class="text-sm text-muted-foreground">Manage your latest customer transactions.</p>
                        </div>
                        <x-ui.button variant="outline" size="sm" :href="route('admin.orders.index')" wire:navigate>
                            View All
                        </x-ui.button>
                    </div>
                    <div class="relative w-full overflow-auto">
                        <table class="w-full caption-bottom text-sm px-6 pb-6">
                            <thead class="[&_tr]:border-b bg-muted/50">
                                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Customer</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Total</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                    <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="[&_tr:last-child]:border-0 px-4">
                                @forelse(\App\Models\Order::with('user')->latest()->take(5)->get() as $order)
                                    <tr class="border-b transition-colors hover:bg-muted/50">
                                        <td class="p-4 align-middle">
                                            <div class="font-medium">#{{ $order->order_number }}</div>
                                            <div class="text-xs text-muted-foreground">{{ $order->items->count() }} items</div>
                                        </td>
                                        <td class="p-4 align-middle font-medium">
                                            {{ $order->first_name }} {{ $order->last_name }}
                                        </td>
                                        <td class="p-4 align-middle font-bold text-primary">
                                            {{ number_format($order->total) }}
                                        </td>
                                        <td class="p-4 align-middle">
                                            <x-ui.badge :variant="match($order->status) {
                                                'delivered' => 'default',
                                                'pending' => 'secondary',
                                                'cancelled' => 'destructive',
                                                default => 'outline'
                                            }">
                                                {{ ucfirst($order->status) }}
                                            </x-ui.badge>
                                        </td>
                                        <td class="p-4 align-middle text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary hover:underline font-medium" wire:navigate>View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="h-24 text-center align-middle text-muted-foreground">
                                            No recent orders found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-ui.card>

                <!-- Quick Actions -->
                <x-ui.card class="col-span-3 p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold">Quick Actions</h3>
                        <p class="text-sm text-muted-foreground">Common administrative tasks.</p>
                    </div>
                    
                    <div class="space-y-4">
                        <x-ui.button variant="outline" class="w-full justify-start h-14 group" :href="route('products.create')" wire:navigate>
                            <div class="bg-primary/10 p-2 rounded-lg mr-3 group-hover:bg-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary group-hover:text-primary-foreground transition-colors"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </div>
                            <div class="text-left">
                                <div class="font-bold">Add Product</div>
                                <div class="text-xs text-muted-foreground">List a new item for sale</div>
                            </div>
                        </x-ui.button>

                        <x-ui.button variant="outline" class="w-full justify-start h-14 group" :href="route('products.index')" wire:navigate>
                            <div class="bg-primary/10 p-2 rounded-lg mr-3 group-hover:bg-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary group-hover:text-primary-foreground transition-colors"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                            </div>
                            <div class="text-left">
                                <div class="font-bold">Inventory</div>
                                <div class="text-xs text-muted-foreground">Manage your product stock</div>
                            </div>
                        </x-ui.button>

                        <x-ui.button variant="outline" class="w-full justify-start h-14 group" :href="route('admin.users.index')" wire:navigate>
                            <div class="bg-primary/10 p-2 rounded-lg mr-3 group-hover:bg-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary group-hover:text-primary-foreground transition-colors"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                            <div class="text-left">
                                <div class="font-bold">Customers</div>
                                <div class="text-xs text-muted-foreground">Manage user accounts and data</div>
                            </div>
                        </x-ui.button>
                    </div>
                </x-ui.card>
            </div>
        @else
            <!-- Non-Admin View Placeholder -->
            <x-ui.card class="p-12 text-center space-y-4">
                <div class="mx-auto w-16 h-16 bg-muted rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h2 class="text-2xl font-bold">Access Restricted</h2>
                <p class="text-muted-foreground max-w-sm mx-auto">You do not have the necessary permissions to view the administrative dashboard.</p>
                <x-ui.button variant="default" :href="route('home')" wire:navigate>Return home</x-ui.button>
            </x-ui.card>
        @endif
    </div>
</x-layouts.app>
