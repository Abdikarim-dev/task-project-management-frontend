@props([
    'href',
    'active' => false,
])

@php
    $classes = $active
        ? 'bg-brand-50 text-brand-700'
        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900';
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => "flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {$classes}"]) }}
    @if ($active) aria-current="page" @endif
>
    {{ $slot }}
</a>
