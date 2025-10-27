{{-- pagination.blade.php --}}
<div class="jws-pagination-number">
    <ul class='page-numbers'>
        @if ($movies->onFirstPage())
            {{-- nothing for prev --}}
        @else
            <li><a href="{{ $movies->appends(request()->query())->previousPageUrl() }}"> &lt; </a></li>
        @endif

        @php
            $start = max(1, $movies->currentPage() - 2);
            $end = min($movies->lastPage(), $movies->currentPage() + 2);
        @endphp

        @if ($start > 1)
            <li><a href="{{ $movies->appends(request()->query())->url(1) }}">1</a></li>
            @if ($start > 2)
                <li><span style="color: #fff">...</span></li>
            @endif
        @endif

        @for ($page = $start; $page <= $end; $page++)
            @if ($movies->currentPage() == $page)
                <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
            @else
                <li><a class="page-numbers" href="{{ $movies->appends(request()->query())->url($page) }}">{{ $page }}</a></li>
            @endif
        @endfor

        @if ($end < $movies->lastPage())
            @if ($end < $movies->lastPage() - 1)
                <li><span style="color: #fff">...</span></li>
            @endif
            <li><a href="{{ $movies->appends(request()->query())->url($movies->lastPage()) }}">{{ $movies->lastPage() }}</a></li>
        @endif

        @if ($movies->hasMorePages())
            <li><a href="{{ $movies->appends(request()->query())->nextPageUrl() }}"> &gt; </a></li>
        @endif
    </ul>
</div>
