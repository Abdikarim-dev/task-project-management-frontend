@props([
    'status',
])

@php
    $config = match ($status) {
        'planning' => ['label' => 'Planning', 'variant' => 'info'],
        'active', 'in_progress' => ['label' => ucfirst(str_replace('_', ' ', $status)), 'variant' => 'primary'],
        'completed' => ['label' => 'Completed', 'variant' => 'success'],
        'on_hold' => ['label' => 'On Hold', 'variant' => 'warning'],
        'to_do' => ['label' => 'To Do', 'variant' => 'default'],
        default => ['label' => ucfirst(str_replace('_', ' ', $status)), 'variant' => 'default'],
    };
@endphp

<x-badge :variant="$config['variant']" {{ $attributes }}>
    {{ $config['label'] }}
</x-badge>
