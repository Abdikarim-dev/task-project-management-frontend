@props([
    'striped' => false,
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            @if (isset($header))
                <thead class="bg-gray-50">
                    {{ $header }}
                </thead>
            @endif
            <tbody class="divide-y divide-gray-200 bg-white {{ $striped ? '[&>tr:nth-child(even)]:bg-gray-50/50' : '' }}">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    @if (isset($footer))
        <div class="border-t border-gray-200 bg-gray-50 px-4 py-3">
            {{ $footer }}
        </div>
    @endif
</div>
