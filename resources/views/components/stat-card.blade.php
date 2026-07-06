@props([
    'title',
    'value',
    'subtitle' => null,
    'trend' => null,
    'trendUp' => true,
    'icon' => null,
    'color' => 'blue',
])

@php
    $iconColors = [
        'blue' => 'bg-blue-50 text-blue-600',
        'green' => 'bg-green-50 text-green-600',
        'red' => 'bg-red-50 text-red-600',
        'yellow' => 'bg-yellow-50 text-yellow-600',
        'purple' => 'bg-purple-50 text-purple-600',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md']) }}>
    <div class="flex items-start justify-between">
        <div class="space-y-2">
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-3xl font-bold tracking-tight text-gray-900">{{ $value }}</p>
            @if ($subtitle)
                <p class="text-sm text-gray-500">{{ $subtitle }}</p>
            @endif
            @if ($trend)
                <p class="text-sm font-medium {{ $trendUp ? 'text-green-600' : 'text-red-600' }}">
                    {{ $trend }}
                </p>
            @endif
        </div>

        @if ($icon)
            <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $iconColors[$color] ?? $iconColors['blue'] }}">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
