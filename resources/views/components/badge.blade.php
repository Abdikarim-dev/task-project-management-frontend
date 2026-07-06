@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
    $variants = [
        'default' => 'bg-surface-hover text-app-secondary',
        'primary' => 'bg-brand-500/15 text-brand-600 dark:text-brand-400',
        'success' => 'bg-green-500/15 text-green-700 dark:text-green-400',
        'warning' => 'bg-yellow-500/15 text-yellow-800 dark:text-yellow-300',
        'danger' => 'bg-red-500/15 text-red-700 dark:text-red-400',
        'info' => 'bg-blue-500/15 text-blue-700 dark:text-blue-400',
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
