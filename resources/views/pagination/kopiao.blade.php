@if ($paginator->hasPages())
    <nav class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
        {{-- Texte d'information (français) --}}
        <p class="small text-muted mb-0">
            @if ($paginator->firstItem())
                Affichage de <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                à <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                sur <span class="fw-semibold">{{ $paginator->total() }}</span> résultats
            @else
                <span class="fw-semibold">{{ $paginator->total() }}</span> résultat(s)
            @endif
        </p>

        <ul class="pagination mb-0">
            {{-- Précédent --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link" aria-hidden="true">‹</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Précédent">‹</a></li>
            @endif

            {{-- Numéros de page --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Suivant --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Suivant">›</a></li>
            @else
                <li class="page-item disabled"><span class="page-link" aria-hidden="true">›</span></li>
            @endif
        </ul>
    </nav>
@endif
