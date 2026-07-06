@props([
    'padding' => true,
])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-app bg-surface shadow-sm'.($padding ? ' p-6' : '')]) }}>
    @if (isset($header))
        <div class="mb-4 flex flex-col gap-1 border-b border-app-subtle pb-4{{ $padding ? '' : ' px-6 pt-6' }}">
            {{ $header }}
        </div>
    @endif

    @if (! $padding && ! isset($header))
        <div class="px-6 pb-6">{{ $slot }}</div>
    @else
        {{ $slot }}
    @endif

    @if (isset($footer))
        <div class="mt-4 border-t border-app-subtle pt-4">
            {{ $footer }}
        </div>
    @endif
</div>
