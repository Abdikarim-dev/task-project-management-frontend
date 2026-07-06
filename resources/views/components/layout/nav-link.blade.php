@props([
    'href',
    'active' => false,
])

@php
    $classes = $active
        ? 'border-l-2 border-brand-500 bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-400'
        : 'border-l-2 border-transparent text-app-secondary hover:bg-surface-hover hover:text-app-primary';
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => "flex items-center gap-3 rounded-r-lg px-3 py-2.5 text-sm font-medium transition-colors {$classes}"]) }}
    @if ($active) aria-current="page" @endif
>
    {{ $slot }}
</a>
