@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex justify-content-center">
        <ul class="pagination" style="display: flex; justify-content: center; align-items: center; margin: 0; padding: 0; list-style: none; gap: 8px;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" style="position: relative; display: flex; align-items: center; justify-content: center; color: #cbd5e1; text-decoration: none; background-color: #f7fafc; border: 2px solid #e2e8f0; padding: 8px 12px; min-width: 40px; height: 40px; border-radius: 8px; font-weight: 600;">‹ Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="position: relative; display: flex; align-items: center; justify-content: center; color: #667eea; text-decoration: none; background-color: #fff; border: 2px solid #E2E8F0; padding: 8px 12px; min-width: 40px; height: 40px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; this.style.color='white'; this.style.borderColor='#667eea'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)';" onmouseout="this.style.background='#fff'; this.style.color='#667eea'; this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">‹ Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="position: relative; display: flex; align-items: center; justify-content: center; color: #cbd5e1; text-decoration: none; background-color: #f7fafc; border: 2px solid #e2e8f0; padding: 8px 12px; min-width: 40px; height: 40px; border-radius: 8px; font-weight: 600;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link" style="position: relative; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border: 2px solid #667eea; padding: 8px 12px; min-width: 40px; height: 40px; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}" style="position: relative; display: flex; align-items: center; justify-content: center; color: #667eea; text-decoration: none; background-color: #fff; border: 2px solid #E2E8F0; padding: 8px 12px; min-width: 40px; height: 40px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; this.style.color='white'; this.style.borderColor='#667eea'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)';" onmouseout="this.style.background='#fff'; this.style.color='#667eea'; this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="position: relative; display: flex; align-items: center; justify-content: center; color: #667eea; text-decoration: none; background-color: #fff; border: 2px solid #E2E8F0; padding: 8px 12px; min-width: 40px; height: 40px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; this.style.color='white'; this.style.borderColor='#667eea'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)';" onmouseout="this.style.background='#fff'; this.style.color='#667eea'; this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">Next ›</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" style="position: relative; display: flex; align-items: center; justify-content: center; color: #cbd5e1; text-decoration: none; background-color: #f7fafc; border: 2px solid #e2e8f0; padding: 8px 12px; min-width: 40px; height: 40px; border-radius: 8px; font-weight: 600;">Next ›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
