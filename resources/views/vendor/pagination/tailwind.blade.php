@if ($paginator->hasPages())
    <nav class="flex flex-wrap justify-center items-center gap-2 mt-8" role="navigation">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 border border-border-subtle rounded-lg text-sm bg-surface-container-low text-outline cursor-not-allowed">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 border border-border-subtle rounded-lg text-sm bg-surface-container-lowest text-primary hover:bg-surface-container transition-colors">&laquo;</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1.5 border border-border-subtle rounded-lg text-sm bg-surface-container-lowest text-outline">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 border border-primary rounded-lg text-sm bg-primary text-on-primary font-bold cursor-default">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 border border-border-subtle rounded-lg text-sm bg-surface-container-lowest text-primary hover:bg-surface-container transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 border border-border-subtle rounded-lg text-sm bg-surface-container-lowest text-primary hover:bg-surface-container transition-colors">&raquo;</a>
        @else
            <span class="px-3 py-1.5 border border-border-subtle rounded-lg text-sm bg-surface-container-low text-outline cursor-not-allowed">&raquo;</span>
        @endif

    </nav>
@endif
