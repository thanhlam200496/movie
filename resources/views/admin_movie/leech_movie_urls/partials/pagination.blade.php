<span class="paginator__pages">
    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} item of {{ $categories->total() }} results
</span>
<ul class="paginator__paginator">
    <li>
        @if (!$categories->onFirstPage())
            <a href="{{ $categories->previousPageUrl() }}">
                <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.75 5.36475L13.1992 5.36475" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M5.771 10.1271L0.749878 5.36496L5.771 0.602051" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        @endif
    </li>
    @for ($page = 1; $page <= $categories->lastPage(); $page++)
        <li class="{{ $categories->currentPage() == $page ? 'active' : '' }}">
            <a href="{{ $categories->url($page) }}">{{ $page }}</a>
        </li>
    @endfor
    <li>
        @if ($categories->hasMorePages())
            <a href="{{ $categories->nextPageUrl() }}">
                <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.1992 5.3645L0.75 5.3645" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M8.17822 0.602051L13.1993 5.36417L8.17822 10.1271" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
        @endif
    </li>
</ul>
