@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h1 class="text-2xl font-bold">{{ $title }}</h1>
    <p class="text-sm text-muted-foreground">{{ $description }}</p>
</div>
