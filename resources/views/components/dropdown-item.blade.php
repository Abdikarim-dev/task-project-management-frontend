@props([
    'href' => '#',
])

<a
    href="{{ $href }}"
    role="menuitem"
    {{ $attributes->merge(['class' => 'flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors']) }}
>
    {{ $slot }}
</a>
