@props([
    'placeholder' => 'Search...',
    'name' => 'search',
    'value' => '',
])

<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <svg class="h-4 w-4 text-app-muted" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
    </div>
    <input
        type="search"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->except('class')->merge([
            'class' => 'block w-full rounded-lg border border-app bg-surface-input py-2 pl-10 pr-4 text-sm text-app-primary shadow-sm placeholder:text-app-muted focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500',
        ]) }}
    />
</div>
