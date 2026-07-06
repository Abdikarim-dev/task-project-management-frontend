@props([
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'mb-8']) }}>
    @if (isset($breadcrumb))
        <div class="mb-3">
            {{ $breadcrumb }}
        </div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $title }}</h1>
            @if ($description)
                <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
            @endif
        </div>

        @if (isset($actions))
            <div class="flex flex-shrink-0 items-center gap-3">
                {{ $actions }}
            </div>
        @endif
    </div>

    @if (isset($tabs))
        <div class="mt-6 border-b border-gray-200">
            {{ $tabs }}
        </div>
    @endif
</div>
