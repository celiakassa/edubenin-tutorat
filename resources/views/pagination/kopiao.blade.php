@if ($paginator->hasPages())
    <nav class="kp-pagination" role="navigation" aria-label="Pagination">
        {{-- Précédent --}}
        @if ($paginator->onFirstPage())
            <span class="kp-page disabled" aria-disabled="true"><i class="fas fa-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="kp-page" rel="prev" aria-label="Précédent"><i class="fas fa-chevron-left"></i></a>
        @endif

        {{-- Numéros de page --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="kp-page dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="kp-page active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="kp-page">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Suivant --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="kp-page" rel="next" aria-label="Suivant"><i class="fas fa-chevron-right"></i></a>
        @else
            <span class="kp-page disabled" aria-disabled="true"><i class="fas fa-chevron-right"></i></span>
        @endif
    </nav>
@endif
