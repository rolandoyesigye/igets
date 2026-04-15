<?php

use Livewire\Volt\Component;

new class extends Component {
    // Notification settings page
}; ?>

<section class="max-w-2xl">
    <x-settings.layout :heading="__('Notifications')" :subheading="__('Manage your notification preferences and recent alerts')">
        <div class="space-y-6">
            <div class="rounded-3xl border border-border bg-background p-4 shadow-sm">
                <div class="flex items-center justify-between gap-4 p-4 rounded-2xl bg-muted">
                    <div>
                        <h3 class="text-lg font-semibold">{{ __('Notification center') }}</h3>
                        <p class="text-sm text-muted-foreground">{{ __('View and manage your latest notifications from the app.') }}</p>
                    </div>
                    <form method="POST" action="{{ route('notifications.readAll') }}">
                        @csrf
                        @method('PUT')
                        <x-ui.button variant="outline" type="submit">{{ __('Mark all read') }}</x-ui.button>
                    </form>
                </div>

                <div class="divide-y divide-border">
                    @forelse(auth()->user()->notifications->sortByDesc('created_at') as $notification)
                        <div class="flex flex-col gap-3 p-4 {{ $notification->read_at ? 'bg-background' : 'bg-primary/5' }}">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        @if(! empty($notification->data['url']))
                                            <a href="{{ $notification->data['url'] }}" class="font-semibold text-primary hover:underline">{{ $notification->data['title'] ?? __('Notification') }}</a>
                                        @else
                                            <span class="font-semibold">{{ $notification->data['title'] ?? __('Notification') }}</span>
                                        @endif
                                        @if(! $notification->read_at)
                                            <span class="inline-flex items-center rounded-full bg-primary px-2 py-0.5 text-[11px] font-semibold text-primary-foreground">{{ __('Unread') }}</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-muted-foreground">{{ $notification->data['message'] ?? __('No message available.') }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs uppercase tracking-[0.18em] text-muted-foreground">{{ $notification->created_at->diffForHumans() }}</span>
                                    @unless($notification->read_at)
                                        <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                            @csrf
                                            @method('PUT')
                                            <x-ui.button variant="secondary" type="submit" size="sm">{{ __('Mark read') }}</x-ui.button>
                                        </form>
                                    @endunless
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-muted-foreground">
                            {{ __('You have no notifications yet.') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </x-settings.layout>
</section>
