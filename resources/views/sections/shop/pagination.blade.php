@if ($paginator->hasPages())
    <div class="row">
        <div class="col-lg-12">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li><a href="#"> &lt; </a></li>
                @else
                    <li><a href="{{ $paginator->previousPageUrl() }}"> &lt; </a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><a class="is_active" href="#">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li><a href="{{ $paginator->nextPageUrl() }}"> &gt; </a></li>
                @else
                    <li><a href="#"> &gt; </a></li>
                @endif
            </ul>
        </div>
    </div>
@endif