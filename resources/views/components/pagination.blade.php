@if ($paginator->total() > 0)
    @php
        $prevIcon = app()->isLocale('ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left';
        $nextIcon = app()->isLocale('ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right';
    @endphp

    <a href="{{ $paginator->onFirstPage() ? $paginator->url($paginator->currentPage()) : $paginator->previousPageUrl() }}">
        <i class="{{ $prevIcon }}"></i>
    </a>

    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <a href="{{ $paginator->url($i) }}" @class(['active' => $paginator->currentPage() === $i])>{{ $i }}</a>
    @endfor

    <a href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : $paginator->url($paginator->currentPage()) }}">
        <i class="{{ $nextIcon }}"></i>
    </a>
@endif
