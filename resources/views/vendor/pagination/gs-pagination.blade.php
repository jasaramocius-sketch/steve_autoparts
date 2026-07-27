<div class="item-pagination-container px-1">
@if ($paginator->hasPages())
    <div class="small text-muted">
        {!! __('Showing') !!}
        <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
        {!! __('to') !!}
        <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
        {!! __('of') !!}
        <span class="fw-semibold">{{ $paginator->total() }}</span>
        {!! __('results') !!}
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <ul class="gs-pagination mb-0">
            {{-- First Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="First page">
                    <span>&laquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->url(1) }}" aria-label="First page">&laquo;</a>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span>&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
    $window = 5;
    $half = floor($window / 2);

    if ($last <= $window) {
        $start = 1; $end = $last;
    } elseif ($current <= $half + 1) {
        $start = 1; $end = $window;
    } elseif ($current >= $last - $half) {
        $start = $last - $window + 1; $end = $last;
    } else {
        $start = $current - $half; $end = $current + $half;
    }
@endphp

@for ($page = $start; $page <= $end; $page++)
    <li class="{{ $page == $current ? 'active' : '' }}">
        @if ($page == $current)
            <span>{{ $page }}</span>
        @else
            <a href="{{ $paginator->url($page) }}">{{ $page }}</a>
        @endif
    </li>
@endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span>&rsaquo;</span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->url($last) }}" aria-label="Last page">&raquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="Last page">
                    <span>&raquo;</span>
                </li>
            @endif
        </ul>
    </div>
@endif
</div>