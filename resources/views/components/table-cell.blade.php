@props([])

<td {{ $attributes->merge(['class' => 'whitespace-nowrap px-4 py-3.5 text-sm text-app-secondary']) }}>
    {{ $slot }}
</td>
