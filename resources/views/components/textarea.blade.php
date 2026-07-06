@props([
    'label' => null,
    'name' => null,
    'error' => null,
    'required' => false,
    'rows' => 4,
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

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        @if ($required) required @endif
        {{ $attributes->except('class')->merge([
            'class' => 'block w-full rounded-lg border px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-colors placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 disabled:bg-gray-50 disabled:text-gray-500 resize-y '
                .($error ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300'),
        ]) }}
    >{{ $slot }}</textarea>

    @if ($error)
        <p class="text-sm text-red-600" role="alert">{{ $error }}</p>
    @endif
</div>
