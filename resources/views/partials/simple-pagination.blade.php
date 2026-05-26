@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="simple-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled" aria-disabled="true">
                <span>&laquo;</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-item" rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-item disabled" aria-disabled="true"><span>{{ $element }}</span></span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-item active" aria-current="page"><span>{{ $page }}</span></span>
                    @else
                        <a href="{{ $url }}" class="page-item" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-item" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
        @else
            <span class="page-item disabled" aria-disabled="true">
                <span>&raquo;</span>
            </span>
        @endif
    </nav>
@endif

<style>
    .simple-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 24px;
        font-family: 'Poppins', sans-serif;
    }

    .page-item {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 12px;
        background: white;
        border: 1.5px solid rgba(216, 84, 123, 0.15);
        color: #8a6070;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .page-item:hover:not(.disabled):not(.active) {
        border-color: #d8547b;
        color: #d8547b;
        background: #fdf2f8;
        transform: translateY(-2px);
    }

    .page-item.active {
        background: #d8547b;
        color: white;
        border-color: #d8547b;
        box-shadow: 0 4px 12px rgba(216, 84, 123, 0.25);
    }

    .page-item.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background: rgba(255, 255, 255, 0.5);
    }
</style>
