@props([
    'padding' => true,
])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-gray-200 bg-white shadow-sm'.($padding ? ' p-6' : '')]) }}>
    @if (isset($header))
        <div class="mb-4 flex items-center justify-between border-b border-gray-100 pb-4">
            {{ $header }}
        </div>
    @endif

    {{ $slot }}

    @if (isset($footer))
        <div class="mt-4 border-t border-gray-100 pt-4">
            {{ $footer }}
        </div>
    @endif
</div>
