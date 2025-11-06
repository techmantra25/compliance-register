<style>
    .bg-theme {
        background-color: #438a7a !important;
        border-color: #438a7a !important;
    }

    .text-theme {
        color: #438a7a !important;
    }

    .border-theme {
        border-color: #438a7a !important;
    }

    .pagination {
        font-size: 0.85rem; /* Smaller text */
    }

    .pagination .page-link {
        border-radius: 50px !important; /* pill-shaped */
        margin: 0 2px;
        padding: 4px 10px; /* compact padding */
        line-height: 1.2;
        transition: all 0.2s ease;
        border: 1px solid #dcdcdc;
    }

    .pagination .page-link:hover {
        background-color: #438a7a !important;
        color: #fff !important;
    }

    .pagination .page-item.active .page-link {
        background-color: #438a7a !important;
        border-color: #438a7a !important;
        color: #fff !important;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #f8f9fa !important;
        color: #adb5bd !important;
        border-color: #dee2e6 !important;
    }
</style>

@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <button wire:click="previousPage" wire:loading.attr="disabled" class="page-link text-white bg-theme">
                        &laquo;
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link text-white bg-theme border-theme">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <button wire:click="gotoPage({{ $page }})" class="page-link text-theme border-theme">
                                    {{ $page }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button wire:click="nextPage" wire:loading.attr="disabled" class="page-link text-white bg-theme">
                        &raquo;
                    </button>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
