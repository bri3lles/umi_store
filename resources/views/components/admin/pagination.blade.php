@props(['paginator'])
@if ($paginator->total())
<div class="table-footer">
    <p class="table-footer__info">Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data</p>
    @if ($paginator->hasPages())
    <nav class="pager" aria-label="Halaman">
        @if ($paginator->onFirstPage())
            <span class="pager__link is-disabled"><x-admin.icon name="chevron-left" :size="16" /></span>
        @else
            <a class="pager__link" href="{{ $paginator->previousPageUrl() }}" aria-label="Sebelumnya"><x-admin.icon name="chevron-left" :size="16" /></a>
        @endif

        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <a class="pager__link {{ $page == $paginator->currentPage() ? 'is-active' : '' }}" href="{{ $url }}" @if ($page == $paginator->currentPage()) aria-current="page" @endif>{{ $page }}</a>
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="pager__link" href="{{ $paginator->nextPageUrl() }}" aria-label="Berikutnya"><x-admin.icon name="chevron-right" :size="16" /></a>
        @else
            <span class="pager__link is-disabled"><x-admin.icon name="chevron-right" :size="16" /></span>
        @endif
    </nav>
    @endif
</div>
@endif