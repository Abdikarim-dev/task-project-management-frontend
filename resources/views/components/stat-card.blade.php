@props([
    'title',
    'value',
    'subtitle' => null,
    'trend' => null,
    'trendUp' => true,
    'color' => 'blue',
])

@php
    $iconColors = [
        'blue' => 'bg-brand-500/15 text-brand-600 dark:text-brand-400',
        'green' => 'bg-green-500/15 text-green-600 dark:text-green-400',
        'red' => 'bg-red-500/15 text-red-600 dark:text-red-400',
        'yellow' => 'bg-yellow-500/15 text-yellow-600 dark:text-yellow-400',
        'purple' => 'bg-purple-500/15 text-purple-600 dark:text-purple-400',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl border border-app bg-surface p-6 shadow-sm transition-shadow hover:shadow-md']) }}>
    <div class="flex items-start justify-between">
        <div class="space-y-2">
            <p class="text-sm font-medium text-app-secondary">{{ $title }}</p>
            <p class="text-3xl font-bold tracking-tight text-app-primary">{{ $value }}</p>
            @if ($subtitle)
                <p class="text-sm text-app-muted">{{ $subtitle }}</p>
            @endif
            @if ($trend)
                <p class="text-sm font-medium {{ $trendUp ? 'text-green-500' : 'text-red-500' }}">
                    {{ $trend }}
                </p>
            @endif
        </div>

        @isset($icon)
            <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $iconColors[$color] ?? $iconColors['blue'] }}">
                {{ $icon }}
            </div>
        @endisset
    </div>
</div>
