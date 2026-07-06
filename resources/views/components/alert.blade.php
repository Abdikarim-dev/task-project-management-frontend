@props([
    'type' => 'info',
    'dismissible' => true,
])

@php
    $styles = [
        'success' => 'bg-green-50 text-green-800 border-green-200',
        'error' => 'bg-red-50 text-red-800 border-red-200',
        'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'info' => 'bg-blue-50 text-blue-800 border-blue-200',
    ];

    $icons = [
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
        'error' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />',
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />',
        'info' => '<path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />',
    ];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    role="alert"
    {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-lg border px-4 py-3 '.($styles[$type] ?? $styles['info'])]) }}
>
    <svg class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        {!! $icons[$type] ?? $icons['info'] !!}
    </svg>

    <div class="flex-1 text-sm font-medium">
        {{ $slot }}
    </div>

    @if ($dismissible)
        <button type="button" x-on:click="show = false" class="shrink-0 rounded-md p-1 hover:bg-black/5 transition-colors" aria-label="Dismiss">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
