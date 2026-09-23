@extends('admin.layouts.app')

@section('title', 'Manajemen Retur')

@section('content')
    @php
        $url = fn (array $over) => route('admin.returns.index', array_filter(array_merge(request()->query(), $over), fn ($v) => $v !== null && $v !== ''));
    @endphp

    <div class="page-head">
        <div>
            <h1 class="page-title">Manajemen Retur &amp; Komplain</h1>
            <p class="page-subtitle">Tinjau pengajuan pengembalian barang, bukti foto/video dari pembeli, klaim garansi produk rusak atau salah ukuran.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert--danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="card returns-top" data-returns-config="{{ json_encode($config) }}">
        <nav class="tabs tabs--pill" aria-label="Status retur">
            @foreach ($tabs as $key => $label)
                <a href="{{ $url(['tab' => $key]) }}" class="{{ $tab === $key ? 'is-active' : '' }}" @if ($tab === $key) aria-current="page" @endif>
                    {{ $label }} <span class="count">{{ $counts[$key] }}</span>
                </a>
            @endforeach
        </nav>
        <form method="GET" action="{{ route('admin.returns.index') }}" class="returns-filter toolbar--fill-inline">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <label class="search-field">
                <x-admin.icon name="search" :size="18" />
                <input type="search" name="q" class="input" value="{{ request('q') }}" placeholder="No. retur / pesanan..." aria-label="Cari retur">
            </label>
            <select name="reason" class="select" aria-label="Filter alasan" data-autosubmit>
                <option value="">Semua Alasan</option>
                @foreach ($reasons as $key => $label)
                    <option value="{{ $key }}" @selected(request('reason') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>

    @forelse ($cases as $r)
        <article class="case" data-return="{{ json_encode($r) }}">
            <header class="case__head">
                <span class="dot dot--{{ $r['tone'] }}"></span>
                <b class="case__no">{{ $r['no'] }}</b>
                <span class="rchip rchip--{{ $r['tone'] }}">{{ $r['status_label'] }}</span>
                <span class="case__link">• Tautan Order: <a href="{{ Route::has('admin.orders.index') ? route('admin.orders.index', ['q' => $r['order']]) : '#' }}">{{ $r['order'] }}</a></span>
                <span class="case__time">{{ $r['submitted'] }}</span>
            </header>
            @if ($r['arrived'] || $r['shipped'])
                <p class="case__sub">{{ $r['arrived'] ?? $r['shipped'] }}</p>
            @endif

            <div class="case__body">
                <div>
                    <div class="who">
                        <x-admin.avatar :name="$r['customer']" :size="40" />
                        <div><b>{{ $r['customer'] }}</b><small class="cell-sub">{{ $r['phone'] }} • {{ $r['area'] }}</small></div>
                    </div>
                    <div class="case__prod">
                        <x-admin.product-thumb :color="$r['color']" :size="48" />
                        <div>
                            <b>{{ $r['product'] }}</b>
                            <small class="cell-sub">{{ $r['variant_line'] }}</small>
                            <small class="reason">Alasan: {{ $r['reason'] }}</small>
                        </div>
                    </div>
                </div>

                <div>
                    @if ($r['status'] === 'review')
                        <h3 class="side-title">Bukti Media Unboxing ({{ count($r['media']) }} File)</h3>
                        <div class="media-row">
                            @foreach ($r['media'] as $i => $m)
                                <button type="button" class="media" style="--tone: {{ $m['color'] }}" data-media="{{ $i }}" aria-label="Lihat {{ $m['label'] }}">
                                    <x-admin.icon :name="$m['type'] === 'video' ? 'play' : 'image'" :size="28" />
                                    <span class="media__cap">{{ $m['label'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    @elseif (in_array($r['status'], ['awaiting', 'ready'], true))
                        <h3 class="side-title">Logistik Pengembalian</h3>
                        <dl class="logi">
                            <div><dt>Ekspedisi:</dt><dd>{{ $r['courier'] }}</dd></div>
                            <div><dt>No. Resi Balik:</dt><dd class="resi-blue">{{ $r['resi_back'] }}</dd></div>
                            <div><dt>{{ $r['resolution'] === 'exchange' ? 'Biaya Tukar:' : 'Ongkir Balik:' }}</dt><dd><span class="rchip rchip--{{ $r['cost'] === 'buyer' ? 'green' : 'amber' }}">{{ $r['cost_label'] }}</span></dd></div>
                        </dl>
                    @else
                        <h3 class="side-title">{{ $r['status'] === 'done' ? 'Hasil Penyelesaian' : 'Alasan Penolakan' }}</h3>
                        <div class="logi logi--text">{{ $r['decision'] }}</div>
                    @endif
                </div>
            </div>

            @if ($r['status'] === 'review' && $r['note'])
                <div class="buyer-note"><b>Catatan Pembeli:</b><p>“{{ $r['note'] }}”</p></div>
            @elseif ($r['status'] === 'ready')
                <div class="info-box"><x-admin.icon name="package" :size="20" /><span><b>Status Fisik:</b> {{ $r['qc'] }}</span></div>
            @elseif ($r['status'] === 'awaiting')
                <div class="info-box"><x-admin.icon name="package" :size="20" /><span>Menunggu paket tiba di toko. Setelah tiba, cek kondisi fisik barang (QC) lalu tandai barang sudah diterima.</span></div>
            @endif

            <footer class="case__actions">
                @switch($r['status'])
                    @case('review')
                        <button type="button" class="btn btn--danger-soft" data-return-action="reject"><x-admin.icon name="x" :size="16" /> Tolak Pengajuan</button>
                        <button type="button" class="btn btn--soft" data-return-action="offer"><x-admin.icon name="gift" :size="17" /> Tawarkan Diskon / Voucher</button>
                        <button type="button" class="btn btn--primary" data-return-action="approve"><x-admin.icon name="check-circle" :size="17" /> Setujui Retur &amp; Kirim Alamat Balik</button>
                        @break
                    @case('awaiting')
                        <button type="button" class="btn btn--soft" data-return-action="detail">Lihat Detail</button>
                        <button type="button" class="btn btn--primary" data-return-action="arrive"><x-admin.icon name="package" :size="17" /> Tandai Barang Tiba</button>
                        @break
                    @case('ready')
                        @if ($r['resolution'] === 'exchange')
                            <button type="button" class="btn btn--soft" data-return-action="print"><x-admin.icon name="printer" :size="17" /> Cetak Label Pengganti</button>
                            <button type="button" class="btn btn--primary" data-return-action="complete"><x-admin.icon name="send" :size="17" /> Kirim Produk Pengganti{{ $r['exchange_to'] ? ' (' . $r['exchange_to'] . ')' : '' }}</button>
                        @else
                            <button type="button" class="btn btn--primary" data-return-action="complete"><x-admin.icon name="check-circle" :size="17" /> Proses Refund {{ $r['price_label'] }}</button>
                        @endif
                        @break
                    @default
                        <button type="button" class="btn btn--soft" data-return-action="detail">Lihat Detail</button>
                @endswitch
            </footer>
        </article>
    @empty
        <div class="card"><div class="empty">Tidak ada pengajuan pada tab ini.</div></div>
    @endforelse

    {{-- Modal aksi (isi form diatur oleh JS sesuai aksi) --}}
    <div class="modal" data-modal="act" role="dialog" aria-modal="true" aria-labelledby="act-title">
        <div class="modal__dialog">
            <h2 class="modal__title" id="act-title" data-act-title></h2>
            <p class="modal__text" data-act-text></p>
            <form method="POST" action="#" class="form-fill" data-act-form>
                @csrf
                <div data-act-fields></div>
                <div class="modal__actions">
                    <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn--primary" data-act-submit>Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal detail --}}
    <div class="modal" data-modal="detail" role="dialog" aria-modal="true" aria-labelledby="rd-title">
        <div class="modal__dialog modal__dialog--xl">
            <div class="od-head">
                <h2 class="modal__title" id="rd-title">Detail Retur <span data-rd-no></span></h2>
                <span class="rchip" data-rd-status></span>
            </div>
            <div class="od-grid" data-rd-body></div>
            <div class="modal__actions"><button type="button" class="btn btn--secondary" data-modal-close>Tutup</button></div>
        </div>
    </div>

    {{-- Modal pratinjau media --}}
    <div class="modal" data-modal="media" role="dialog" aria-modal="true" aria-label="Pratinjau bukti">
        <div class="modal__dialog modal__dialog--xl">
            <div class="media media--lg" data-media-view></div>
            <div class="modal__actions"><button type="button" class="btn btn--secondary" data-modal-close>Tutup</button></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/returns.js') }}" defer></script>
@endpush