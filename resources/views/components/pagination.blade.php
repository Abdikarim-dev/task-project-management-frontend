@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" {{ $attributes->merge(['class' => 'flex items-center justify-between']) }}>
        <div class="text-sm text-gray-500">
            Showing
            <span class="font-medium text-gray-700">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-medium text-gray-700">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-medium text-gray-700">{{ $paginator->total() }}</span>
            results
        </div>

        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-400 cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Previous
                </a>
            @endif

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="inline-flex items-center rounded-lg bg-brand-600 px-3.5 py-2 text-sm font-medium text-white">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Next
                </a>
            @else
                <span class="inline-flex items-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-400 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
    </nav>
@endif
