@props([
    'striped' => false,
    'flush' => false,
])

<div {{ $attributes->class([
    'min-w-0',
    'overflow-hidden' => ! $flush,
    'rounded-xl border border-app bg-surface shadow-sm' => ! $flush,
]) }}>
    <div class="overflow-x-auto scrollbar-thin">
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
