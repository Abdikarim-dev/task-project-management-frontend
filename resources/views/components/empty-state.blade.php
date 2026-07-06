@props([
    'title',
    'description' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-xl border border-dashed border-app bg-surface-hover/50 px-6 py-16 text-center']) }}>
    @if ($icon)
        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-surface-hover text-app-muted">
            {!! $icon !!}
        </div>
    @else
        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-surface-hover text-app-muted">
            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
        </div>
    @endif

    <h3 class="text-base font-semibold text-app-primary">{{ $title }}</h3>

    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-app-secondary">{{ $description }}</p>
    @endif

    @if (isset($action))
        <div class="mt-6">
            {{ $action }}
        </div>
    @endif
</div>
