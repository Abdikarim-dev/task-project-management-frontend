@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
    $variants = [
        'default' => 'bg-gray-100 text-gray-700',
        'primary' => 'bg-brand-100 text-brand-700',
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger' => 'bg-red-100 text-red-700',
        'info' => 'bg-blue-100 text-blue-700',
        'dark' => 'bg-gray-800 text-white',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-0.5 text-xs',
        'lg' => 'px-3 py-1 text-sm',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center font-medium rounded-full '.($variants[$variant] ?? $variants['default']).' '.($sizes[$size] ?? $sizes['md'])]) }}>
    {{ $slot }}
</span>
