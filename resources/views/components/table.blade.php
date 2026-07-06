@props([
    'striped' => false,
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-app bg-surface shadow-sm']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-[var(--border)]">
            @if (isset($header))
                <thead class="bg-surface-hover">
                    {{ $header }}
                </thead>
            @endif
            <tbody class="divide-y divide-[var(--border)] bg-surface {{ $striped ? '[&>tr:nth-child(even)]:bg-surface-hover/50' : '' }}">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    @if (isset($footer))
        <div class="border-t border-app bg-surface-hover px-4 py-3">
            {{ $footer }}
        </div>
    @endif
</div>
