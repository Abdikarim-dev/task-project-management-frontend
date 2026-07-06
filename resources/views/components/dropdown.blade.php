@props([
    'align' => 'right',
])

@php
    $alignment = match ($align) {
        'left' => 'left-0 origin-top-left',
        'right' => 'right-0 origin-top-right',
        default => 'right-0 origin-top-right',
    };
@endphp

<div x-data="{ open: false }" class="relative" @click.outside="open = false" {{ $attributes }}>
    @isset($trigger)
        <div x-on:click="open = !open">
            {{ $trigger }}
        </div>
    @endisset

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mt-2 w-56 rounded-lg bg-white shadow-lg ring-1 ring-gray-200 focus:outline-none {{ $alignment }}"
        style="display: none;"
        role="menu"
    >
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
