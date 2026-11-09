@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="portal-pagination-wrapper" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; padding: 1rem 0; width: 100%;">
        
        <!-- Results Counter Text -->
        <div class="pagination-info" style="font-size: 0.88rem; color: #64748b; font-weight: 600;">
            <span>Showing</span>
            @if ($paginator->firstItem())
                <strong style="color: #0f172a; font-weight: 700;">{{ $paginator->firstItem() }}</strong>
                <span>to</span>
                <strong style="color: #0f172a; font-weight: 700;">{{ $paginator->lastItem() }}</strong>
            @else
                <strong style="color: #0f172a; font-weight: 700;">{{ $paginator->count() }}</strong>
            @endif
            <span>of</span>
            <strong style="color: #0f172a; font-weight: 700;">{{ $paginator->total() }}</strong>
            <span>results</span>
        </div>

        <!-- Pagination Action Links & Page Pills -->
        <div class="pagination-controls" style="display: inline-flex; align-items: center; gap: 6px; flex-wrap: wrap;">
            
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; color: #94a3b8; cursor: not-allowed; font-size: 0.88rem;">
                    <svg style="width: 16px !important; height: 16px !important; max-width: 16px !important; max-height: 16px !important; display: block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-btn" aria-label="{{ __('pagination.previous') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #0f172a; text-decoration: none; font-size: 0.88rem; transition: all 0.2s ease;">
                    <svg style="width: 16px !important; height: 16px !important; max-width: 16px !important; max-height: 16px !important; display: block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif

            {{-- Numbered Page Links --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-dots" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 34px; color: #94a3b8; font-weight: 700;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-page active" aria-current="page" style="display: inline-flex; align-items: center; justify-content: center; min-width: 34px; height: 34px; padding: 0 10px; border-radius: 8px; background: #05B396; color: #ffffff; font-weight: 800; font-size: 0.88rem; box-shadow: 0 2px 8px rgba(5, 179, 150, 0.35);">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="pagination-page" style="display: inline-flex; align-items: center; justify-content: center; min-width: 34px; height: 34px; padding: 0 10px; border-radius: 8px; border: 1px solid #e2e8f0; background: #ffffff; color: #334155; text-decoration: none; font-weight: 600; font-size: 0.88rem; transition: all 0.15s ease;">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-btn" aria-label="{{ __('pagination.next') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #0f172a; text-decoration: none; font-size: 0.88rem; transition: all 0.2s ease;">
                    <svg style="width: 16px !important; height: 16px !important; max-width: 16px !important; max-height: 16px !important; display: block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <span class="pagination-btn disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; color: #94a3b8; cursor: not-allowed; font-size: 0.88rem;">
                    <svg style="width: 16px !important; height: 16px !important; max-width: 16px !important; max-height: 16px !important; display: block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif

        </div>
    </nav>
@endif

