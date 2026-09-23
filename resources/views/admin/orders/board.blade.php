@extends('admin.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
    @php
        $url = fn (array $over) => route('admin.orders.index', array_filter(array_merge(request()->query(), ['page' => null], $over), fn ($v) => $v !== null && $v !== ''));
    @endphp

    <div class="page-head">
        <div>
            <h1 class="page-title">Manajemen Pesanan Pelanggan</h1>
            <p class="page-subtitle">Pantau seluruh alur pesanan dari pembayaran terverifikasi, pengemasan, pengiriman kurir, hingga pesanan diterima pelanggan dengan akurat.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert--danger" role="alert">{{ $errors->first() }}</div>
    @endif

    @if ($counts['new'] > 0)
        <div class="notice">
            <span class="notice__icon"><x-admin.icon name="bell" :size="22" /></span>
            <div class="notice__text">
                <h2>{{ $counts['new'] }} Pesanan Baru Menunggu Konfirmasi</h2>
                <p>Pesanan ini sudah terbayar tapi belum diproses. Terima untuk memulai pengemasan, atau tolak jika stok habis / alamat tidak valid.</p>
            </div>
            <a href="{{ route('admin.orders.index', ['tab' => 'new']) }}" class="btn btn--glass">Lihat Pesanan Baru</a>
        </div>
    @endif

    <div class="card card--clip">
        <div class="tab-bar">
            <nav class="tabs tabs--pill" aria-label="Status pesanan">
                @foreach ($tabs as $key => $label)
                    <a href="{{ $url(['tab' => $key === 'all' ? null : $key]) }}" class="{{ $tab === $key ? 'is-active' : '' }}" @if ($tab === $key) aria-current="page" @endif>
                        {{ $label }} <span class="count">{{ $counts[$key] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <form method="GET" action="{{ route('admin.orders.index') }}" class="toolbar toolbar--fill">
            @if ($tab !== 'all')<input type="hidden" name="tab" value="{{ $tab }}">@endif
            <label class="search-field">
                <x-admin.icon name="search" :size="18" />
                <input type="search" name="q" class="input" value="{{ request('q') }}" placeholder="Cari No. Pesanan, Nama, Resi..." aria-label="Cari pesanan">
            </label>
            <select name="courier" class="select" aria-label="Filter ekspedisi" data-autosubmit>
                <option value="">Semua Ekspedisi</option>
                @foreach ($couriers as $key => $name)
                    <option value="{{ $key }}" @selected(request('courier') === $key)>{{ $name }}</option>
                @endforeach
            </select>
            <label class="select-wrap">
                <x-admin.icon name="calendar" :size="16" />
                <select name="date" class="select" aria-label="Filter tanggal" data-autosubmit>
                    <option value="">Semua Tanggal</option>
                    @foreach ($dates as $key => $name)
                        <option value="{{ $key }}" @selected(request('date') === $key)>{{ $name }}</option>
                    @endforeach
                </select>
            </label>
            <a href="{{ route('admin.orders.index', array_filter(['tab' => $tab === 'all' ? null : $tab])) }}" class="btn btn--soft btn--icon" title="Reset filter" aria-label="Reset filter"><x-admin.icon name="sliders" :size="18" /></a>
        </form>

        <div class="table-wrap">
            <table class="table table--soft order-table">
                <thead>
                    <tr>
                        <th>No. Pesanan &amp; Tanggal</th>
                        <th>Pembeli &amp; Alamat</th>
                        <th>Produk Dipesan</th>
                        <th>Total Bayar &amp; Metode</th>
                        <th>Ekspedisi &amp; Resi</th>
                        <th>Status</th>
                        <th class="text-right">Aksi Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $o)
                        <tr data-order="{{ json_encode($o) }}">
                            <td>
                                <b class="order-no order-no--link">{{ $o['no'] }}</b>
                                <small class="cell-sub"><x-admin.icon name="clock" :size="12" class="inline-ico" /> {{ $o['ago'] }}</small>
                            </td>
                            <td>
                                <b class="pay-customer">{{ $o['buyer'] }}</b>
                                <small class="cell-sub loc"><x-admin.icon name="map-pin" :size="12" class="inline-ico" /> {{ $o['area'] }}</small>
                            </td>
                            <td>
                                <div class="prod-mini">
                                    <x-admin.product-thumb :color="$o['color']" :size="48" />
                                    <div>
                                        <b title="{{ $o['first'] }}">{{ $o['first'] }}</b>
                                        <small class="cell-sub">Varian: {{ $o['first_variant'] }} • {{ $o['qty'] }} Barang{{ $o['more'] ? ' (+' . $o['more'] . ' produk)' : '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <b class="price">{{ $o['total_label'] }}</b>
                                <span class="method-chip">{{ $o['method'] }} @if ($o['verified'])<x-admin.icon name="check-circle" :size="13" class="verified" />@endif</span>
                            </td>
                            <td>
                                <b class="courier">{{ $o['courier'] }}</b>
                                @if ($o['resi'])
                                    <span class="resi-no">{{ $o['resi'] }}</span>
                                @elseif ($o['status'] === 'ready')
                                    <span class="resi-chip">Belum Cetak Resi</span>
                                @endif
                            </td>
                            <td><span class="status status--{{ $o['status_tone'] }}">{{ $o['status_label'] }}</span></td>
                            <td>
                                <div class="order-actions">
                                    @switch($o['status'])
                                        @case('new')
                                            <button type="button" class="btn btn--success btn--sm" data-order-action="accept"><x-admin.icon name="check-circle" :size="16" /> Terima</button>
                                            <button type="button" class="btn btn--danger-soft btn--sm" data-order-action="reject"><x-admin.icon name="x-circle" :size="16" /> Tolak</button>
                                            @break
                                        @case('to_pack')
                                            <button type="button" class="btn btn--primary btn--sm" data-order-action="ship">Atur Pengiriman</button>
                                            @break
                                        @case('ready')
                                            <button type="button" class="btn btn--soft btn--sm" data-order-action="print"><x-admin.icon name="printer" :size="16" /> Cetak Resi</button>
                                            @break
                                        @case('shipping')
                                            <button type="button" class="btn btn--soft btn--sm" data-order-action="detail"><x-admin.icon name="send" :size="16" /> Lacak Paket</button>
                                            @break
                                        @default
                                            <button type="button" class="btn btn--soft btn--sm" data-order-action="detail">Detail Pesanan</button>
                                    @endswitch
                                    @if (in_array($o['status'], ['new', 'to_pack', 'ready'], true))
                                        <button type="button" class="icon-btn icon-btn--soft" data-order-action="detail" title="Lihat detail" aria-label="Lihat detail {{ $o['no'] }}"><x-admin.icon name="eye" :size="18" /></button>
                                    @endif
                                    @if ($o['status'] !== 'new')
                                        <button type="button" class="icon-btn icon-btn--soft" data-order-action="status" title="Ubah status pesanan" aria-label="Ubah status {{ $o['no'] }}"><x-admin.icon name="pencil" :size="18" /></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="empty">Tidak ada pesanan yang cocok. Ubah kata kunci atau filter pencarian.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-admin.pagination :paginator="$orders" />
    </div>

    {{-- Modal atur pengiriman --}}
    <div class="modal" data-modal="ship" role="dialog" aria-modal="true" aria-labelledby="ship-title">
        <div class="modal__dialog">
            <h2 class="modal__title" id="ship-title">Atur Pengiriman</h2>
            <p class="modal__text">Pesanan <strong data-sh-order></strong> untuk <strong data-sh-buyer></strong> akan ditandai <strong>Siap Dikirim</strong>.</p>
            <form method="POST" action="#" class="form-fill" data-sh-form>
                @csrf
                <div class="field adj-note">
                    <label class="field__label" for="sh-courier">Ekspedisi <i>*</i></label>
                    <select id="sh-courier" name="courier" class="select" required>
                        @foreach ($couriers as $key => $name)<option value="{{ $key }}">{{ $name }}</option>@endforeach
                    </select>
                </div>
                <div class="field adj-note">
                    <label class="field__label" for="sh-resi">Nomor resi <small class="text-muted">(opsional)</small></label>
                    <input type="text" id="sh-resi" name="resi" class="input" maxlength="40" placeholder="Bisa diisi setelah kurir menjemput paket">
                </div>
                <div class="modal__actions">
                    <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn--primary">Simpan &amp; Siap Dikirim</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal terima pesanan --}}
    <div class="modal" data-modal="accept" role="dialog" aria-modal="true" aria-labelledby="ac-title">
        <div class="modal__dialog">
            <div class="modal__icon modal__icon--ok"><x-admin.icon name="check-circle" :size="24" /></div>
            <h2 class="modal__title" id="ac-title">Terima pesanan?</h2>
            <p class="modal__text">Pesanan <strong data-ac-order></strong> dari <strong data-ac-buyer></strong> akan diterima dan dipindahkan ke status <strong>Perlu Dikemas</strong>.</p>
            <div class="modal__actions">
                <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                <form method="POST" action="#" data-ac-form>@csrf<button type="submit" class="btn btn--success">Ya, Terima Pesanan</button></form>
            </div>
        </div>
    </div>

    {{-- Modal tolak pesanan --}}
    <div class="modal" data-modal="reject" role="dialog" aria-modal="true" aria-labelledby="rj-title">
        <div class="modal__dialog">
            <div class="modal__icon"><x-admin.icon name="x-circle" :size="24" /></div>
            <h2 class="modal__title" id="rj-title">Tolak pesanan?</h2>
            <p class="modal__text">Pesanan <strong data-rj-order></strong> dari <strong data-rj-buyer></strong> akan dibatalkan. Pastikan dana dikembalikan ke pembeli secara manual.</p>
            <form method="POST" action="#" class="form-fill" data-rj-form>
                @csrf
                <div class="field adj-note">
                    <label class="field__label" for="rj-reason">Alasan penolakan <i>*</i></label>
                    <select id="rj-reason" name="reason" class="select" required>
                        @foreach ($rejectReasons as $value => $label)<option value="{{ $value }}">{{ $label }}</option>@endforeach
                    </select>
                </div>
                <div class="field adj-note">
                    <label class="field__label" for="rj-note">Catatan untuk pembeli <small class="text-muted">(opsional)</small></label>
                    <textarea id="rj-note" name="note" rows="2" maxlength="255" class="input textarea" placeholder="Contoh: stok habis, dana akan dikembalikan"></textarea>
                </div>
                <div class="modal__actions">
                    <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn--danger">Tolak Pesanan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal ubah status manual --}}
    <div class="modal" data-modal="status" role="dialog" aria-modal="true" aria-labelledby="st-title">
        <div class="modal__dialog">
            <h2 class="modal__title" id="st-title">Ubah Status Pesanan</h2>
            <p class="modal__text">Ubah status pesanan <strong data-st-order></strong> untuk <strong data-st-buyer></strong> secara manual. Gunakan ini untuk mengoreksi status, bukan alur normal sehari-hari.</p>
            <form method="POST" action="#" class="form-fill" data-st-form>
                @csrf
                <div class="field adj-note">
                    <label class="field__label" for="st-status">Status pesanan <i>*</i></label>
                    <select id="st-status" name="status" class="select" required>
                        @foreach ($statusOptions as $key => $label)<option value="{{ $key }}">{{ $label }}</option>@endforeach
                    </select>
                </div>
                <div class="modal__actions">
                    <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn--primary">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal detail pesanan --}}
    <div class="modal" data-modal="detail" role="dialog" aria-modal="true" aria-labelledby="od-title">
        <div class="modal__dialog modal__dialog--xl">
            <div class="od-head">
                <h2 class="modal__title" id="od-title">Detail Pesanan <span data-od-no></span></h2>
                <span class="status" data-od-status></span>
            </div>
            <div class="od-grid" data-od-body></div>
            <div class="modal__actions"><button type="button" class="btn btn--secondary" data-modal-close>Tutup</button></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/orders.js') }}" defer></script>
@endpush