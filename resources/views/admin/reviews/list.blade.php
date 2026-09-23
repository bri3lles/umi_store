@extends('admin.layouts.app')

@section('title', 'Kelola Rating & Ulasan')

@section('content')
    @php $url = fn (array $over) => route('admin.reviews.index', array_filter(array_merge(request()->query(), ['page' => null], $over), fn ($v) => $v !== null && $v !== '')); @endphp

    <div class="page-head">
        <div>
            <h1 class="page-title">Kelola Rating &amp; Ulasan</h1>
            <p class="page-subtitle">Pantau penilaian pembeli, balas ulasan, dan tindak lanjuti komentar yang dilaporkan.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert--danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="review-summary">
        <div class="card card--pad score-card">
            <span class="score-card__num">{{ number_format($summary['avg'], 1) }}</span>
            <x-admin.stars :rating="round($summary['avg'])" :size="18" />
            <span class="score-card__total">Dari {{ $summary['total'] }} ulasan</span>
        </div>
        <div class="card card--pad bars-card">
            @foreach ($summary['stars'] as $row)
                @php $pct = $summary['total'] ? round($row['count'] / $summary['total'] * 100) : 0; @endphp
                <a href="{{ $url(['rating' => request('rating') == $row['star'] ? null : $row['star']]) }}" class="star-row {{ (string) request('rating') === (string) $row['star'] ? 'is-active' : '' }}">
                    <span class="star-row__label">{{ $row['star'] }} <x-admin.icon name="star-fill" :size="12" /></span>
                    <span class="bar"><span style="width: {{ $pct }}%"></span></span>
                    <span class="star-row__count">{{ $row['count'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="card card--clip">
        <div class="tab-bar">
            <nav class="tabs" aria-label="Filter ulasan">
                @foreach ($tabs as $key => $label)
                    <a href="{{ $url(['tab' => $key === 'all' ? null : $key]) }}" class="{{ $tab === $key ? 'is-active' : '' }}" @if ($tab === $key) aria-current="page" @endif>
                        {{ $label }} <span class="count">{{ $counts[$key] }}</span>
                    </a>
                @endforeach
            </nav>
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="tab-bar__tools">
                @if ($tab !== 'all')<input type="hidden" name="tab" value="{{ $tab }}">@endif
                @if (request('rating'))<input type="hidden" name="rating" value="{{ request('rating') }}">@endif
                <label class="search-field">
                    <x-admin.icon name="search" :size="18" />
                    <input type="search" name="q" class="input" value="{{ request('q') }}" placeholder="Cari produk, pembeli, atau komentar..." aria-label="Cari ulasan">
                </label>
            </form>
        </div>

        @forelse ($paged as $r)
            <article class="review {{ $r['hidden'] ? 'is-hidden-review' : '' }}" data-review="{{ json_encode($r) }}">
                <div class="review__prod">
                    <x-admin.product-thumb :color="$r['color']" :size="48" />
                    <div>
                        <b>{{ $r['product'] }}</b>
                        <small class="cell-sub">Varian: {{ $r['variant'] }} • {{ $r['order'] }}</small>
                    </div>
                    <div class="review__badges">
                        @if ($r['reported'])<span class="rchip rchip--red"><x-admin.icon name="flag" :size="12" class="inline-ico" /> Dilaporkan</span>@endif
                        @if ($r['hidden'])<span class="rchip rchip--gray"><x-admin.icon name="eye-off" :size="12" class="inline-ico" /> Disembunyikan</span>@endif
                    </div>
                </div>

                <div class="review__body">
                    <div class="who">
                        <x-admin.avatar :name="$r['customer']" :size="36" />
                        <div>
                            <b>{{ $r['customer'] }}</b>
                            <div class="review__meta"><x-admin.stars :rating="$r['rating']" :size="13" /> <span class="cell-sub">{{ $r['time'] }}</span></div>
                        </div>
                    </div>
                    <p class="review__comment">{{ $r['comment'] }}</p>
                    @if ($r['photos'])
                        <div class="review__photos">
                            @for ($i = 0; $i < $r['photos']; $i++)
                                <span class="review__photo" style="--tone: {{ $r['color'] }}"><x-admin.icon name="image" :size="18" /></span>
                            @endfor
                        </div>
                    @endif

                    @if ($r['reply'])
                        <div class="reply-box">
                            <b><x-admin.icon name="store" :size="14" class="inline-ico" /> Balasan Umi Store</b>
                            <p>{{ $r['reply'] }}</p>
                        </div>
                    @endif
                </div>

                <footer class="review__actions">
                    <button type="button" class="btn btn--soft btn--sm" data-review-action="reply"><x-admin.icon name="reply" :size="15" /> {{ $r['reply'] ? 'Edit Balasan' : 'Balas Ulasan' }}</button>
                    <button type="button" class="btn btn--soft btn--sm" data-review-action="visibility"><x-admin.icon :name="$r['hidden'] ? 'eye' : 'eye-off'" :size="15" /> {{ $r['hidden'] ? 'Tampilkan' : 'Sembunyikan' }}</button>
                    <button type="button" class="icon-btn icon-btn--del" data-review-action="delete" title="Hapus ulasan" aria-label="Hapus ulasan {{ $r['customer'] }}"><x-admin.icon name="trash" :size="17" /></button>
                </footer>
            </article>
        @empty
            <div class="empty">Tidak ada ulasan yang cocok. Ubah kata kunci atau filter.</div>
        @endforelse

        <x-admin.pagination :paginator="$paged" />
    </div>

    {{-- Modal balas ulasan --}}
    <div class="modal" data-modal="reply" role="dialog" aria-modal="true" aria-labelledby="rp-title">
        <div class="modal__dialog">
            <h2 class="modal__title" id="rp-title">Balas ulasan</h2>
            <p class="modal__text"><strong data-rp-customer></strong> — <span data-rp-product></span></p>
            <blockquote class="quote" data-rp-comment></blockquote>
            <form method="POST" action="#" class="form-fill" data-rp-form>
                @csrf
                <div class="field adj-note">
                    <label class="field__label" for="rp-message">Balasan Anda <i>*</i></label>
                    <textarea id="rp-message" name="message" rows="3" maxlength="500" class="input textarea" required placeholder="Terima kasih atas ulasannya..."></textarea>
                </div>
                <div class="modal__actions">
                    <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn--primary">Kirim Balasan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal sembunyikan/tampilkan --}}
    <div class="modal" data-modal="visibility" role="dialog" aria-modal="true" aria-labelledby="vs-title">
        <div class="modal__dialog">
            <h2 class="modal__title" id="vs-title" data-vs-title></h2>
            <p class="modal__text" data-vs-text></p>
            <form method="POST" action="#" data-vs-form>
                @csrf
                <div class="modal__actions">
                    <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn--primary">Ya, Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal hapus --}}
    <div class="modal" data-modal="delete" role="dialog" aria-modal="true" aria-labelledby="del-title">
        <div class="modal__dialog">
            <div class="modal__icon"><x-admin.icon name="alert" :size="22" /></div>
            <h2 class="modal__title" id="del-title">Hapus ulasan?</h2>
            <p class="modal__text">Ulasan dari <strong data-del-customer></strong> untuk <strong data-del-product></strong> akan dihapus permanen dan tidak dapat dikembalikan.</p>
            <div class="modal__actions">
                <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                <form method="POST" action="#" data-del-form>@csrf @method('DELETE')<button type="submit" class="btn btn--danger">Hapus</button></form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/reviews.js') }}" defer></script>
@endpush