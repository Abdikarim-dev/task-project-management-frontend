@props([
    'rows' => 5,
    'columns' => 4,
])

<div {{ $attributes->merge(['class' => 'animate-pulse space-y-4']) }} aria-hidden="true">
    @for ($i = 0; $i < $rows; $i++)
        <div class="flex gap-4">
            @for ($j = 0; $j < $columns; $j++)
                <div class="h-4 flex-1 rounded bg-gray-200"></div>
            @endfor
        </div>
    @endfor
</div>
