@if ($paginator->hasPages())

  <nav aria-label="Page navigation">
    <ul class="pagination pagination-lg justify-content-center mt-3 mb-0" >

      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
      @else
        <li class="page-item">
          <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
        </li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li class="page-item active" aria-current="page"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @else
              <li><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
        </li>
        @else
        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Next</span>
        </a>
        </li>
      @endif
    </ul>
  </nav>

@endif