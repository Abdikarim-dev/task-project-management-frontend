@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'error' => null,
    'required' => false,
    'disabled' => false,
])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-app-secondary">
            {{ $label }}
            @if ($required)
                <span class="text-red-500" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        @if ($required) required @endif
        @if ($disabled) disabled @endif
        {{ $attributes->except('class')->merge([
            'class' => 'block w-full rounded-lg border px-3.5 py-2.5 text-sm text-app-primary shadow-sm transition-colors placeholder:text-app-muted focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 disabled:cursor-not-allowed disabled:opacity-70 disabled:bg-surface-hover bg-surface-input border-app '
                .($error ? 'border-red-400 focus:ring-red-500 focus:border-red-500' : ''),
        ]) }}
    />

    @if ($error)
        <p class="text-sm text-red-500" role="alert">{{ $error }}</p>
    @endif
</div>
