@props([
    'label' => null,
    'name' => null,
    'error' => null,
    'required' => false,
    'placeholder' => 'Select an option',
])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            @if ($required) required @endif
            {{ $attributes->except('class')->merge([
                'class' => 'block w-full appearance-none rounded-lg border bg-white px-3.5 py-2.5 pr-10 text-sm text-gray-900 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 disabled:bg-gray-50 disabled:text-gray-500 '
                    .($error ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300'),
            ]) }}
        >
            @if ($placeholder)
                <option value="" disabled {{ old($name) ? '' : 'selected' }}>{{ $placeholder }}</option>
            @endif
            {{ $slot }}
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>

    @if ($error)
        <p class="text-sm text-red-600" role="alert">{{ $error }}</p>
    @endif
</div>
