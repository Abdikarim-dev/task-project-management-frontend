@props([
    'name',
    'src' => null,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-12 w-12 text-base',
        'xl' => 'h-16 w-16 text-lg',
    ];

    $initials = collect(explode(' ', $name))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->join('');
@endphp

@if ($src)
    <img
        src="{{ $src }}"
        alt="{{ $name }}"
        {{ $attributes->merge(['class' => 'rounded-full object-cover ring-2 ring-white '.($sizes[$size] ?? $sizes['md'])]) }}
    />
@else
    <div
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-full bg-brand-100 font-semibold text-brand-700 ring-2 ring-white '.($sizes[$size] ?? $sizes['md'])]) }}
        aria-label="{{ $name }}"
    >
        {{ $initials }}
    </div>
@endif
