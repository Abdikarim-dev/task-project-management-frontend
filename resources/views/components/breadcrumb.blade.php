@props([
    'items' => [],
])

@if (count($items))
    <nav aria-label="Breadcrumb" {{ $attributes }}>
        <ol class="flex items-center gap-1.5 text-sm text-app-secondary">
            @foreach ($items as $index => $item)
                <li class="flex items-center gap-1.5">
                    @if ($index > 0)
                        <svg class="h-4 w-4 text-app-muted" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    @endif

                    @if (isset($item['url']) && $index < count($items) - 1)
                        <a href="{{ $item['url'] }}" class="transition-colors hover:text-app-primary">{{ $item['label'] }}</a>
                    @else
                        <span class="font-medium text-app-primary" aria-current="page">{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
