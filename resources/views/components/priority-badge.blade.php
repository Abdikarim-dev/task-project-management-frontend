@props([
    'priority',
])

@php
    $config = match ($priority) {
        'high' => ['label' => 'High', 'variant' => 'danger'],
        'medium' => ['label' => 'Medium', 'variant' => 'warning'],
        'low' => ['label' => 'Low', 'variant' => 'success'],
        default => ['label' => ucfirst($priority), 'variant' => 'default'],
    };
@endphp

<x-badge :variant="$config['variant']" {{ $attributes }}>
    {{ $config['label'] }}
</x-badge>
