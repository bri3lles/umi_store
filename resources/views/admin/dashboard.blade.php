@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php $link = fn ($name) => Route::has($name) ? route($name) : '#'; @endphp

    <div class="page-head">
        <div>
            <h1 class="page-title">Beranda &amp; Ringkasan Toko</h1>
            <p class="page-subtitle">Selamat datang kembali, {{ $adminName }}! Berikut rangkuman aktivitas dan tindakan penting toko hari ini.</p>
        </div>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="stat-grid">
        @foreach ($stats as $stat)
            <a href="{{ $link($stat['route']) }}" class="stat">
                <div class="stat__head">
                    <span class="stat__label">{{ $stat['label'] }}</span>
                    <span class="stat__icon tone--{{ $stat['tone'] }}"><x-admin.icon :name="$stat['icon']" :size="20" /></span>
                </div>
                <div class="stat__value">{{ $stat['value'] }} <small>{{ $stat['unit'] }}</small></div>
                <span class="mini-pill tone--{{ $stat['tone'] }}">{{ $stat['note'] }}</span>
            </a>
        @endforeach
    </div>

    <div class="dash-grid">
        {{-- Tren penjualan --}}
        <section class="card card--pad chart-card" data-chart="{{ json_encode($chart) }}">
            <div class="chart-card__head">
                <div>
                    <span class="muted-label">Tren Penjualan Toko</span>
                    <div class="chart-card__total">
                        <strong data-chart-total>Rp {{ number_format($weekTotal, 0, ',', '.') }}</strong>
                        <span class="growth" data-chart-growth>{{ $chart['week']['growth'] }}</span>
                    </div>
                </div>
                <div class="seg-tabs" role="tablist" aria-label="Periode">
                    <button type="button" class="is-active" role="tab" aria-selected="true" data-chart-tab="week">Minggu Ini</button>
                    <button type="button" role="tab" aria-selected="false" data-chart-tab="month">Bulan Ini</button>
                </div>
            </div>
            <div class="chart">
                <div class="chart__plot" data-chart-plot></div>
                <div class="chart__labels" data-chart-labels></div>
            </div>
        </section>

        {{-- Stok menipis --}}
        <section class="card card--pad low-card">
            <div class="low-card__head">
                <h2><x-admin.icon name="alert" :size="22" /> Stok Menipis</h2>
                <a href="{{ $link('admin.stock.index') }}" class="link-sm">Lihat Semua Stok</a>
            </div>
            <p class="low-card__hint">Perlu pengadaan ulang agar pesanan pelanggan tidak tertahan.</p>
            <div class="low-list">
                @foreach ($lowStock as $item)
                    <div class="low-item">
                        <x-admin.product-thumb :color="$item['color']" :size="48" />
                        <div class="low-item__body">
                            <b>{{ $item['name'] }}</b>
                            <small>Varian: {{ $item['variant'] }} • SKU: {{ $item['sku'] }}</small>
                            <span class="pill pill--{{ $item['stock'] === 0 ? 'out' : 'low' }}">{{ $item['stock'] === 0 ? 'Habis (0 pcs)' : 'Tersisa ' . $item['stock'] . ' pcs' }}</span>
                        </div>
                        <a href="{{ $link('admin.stock.index') }}" class="btn btn--primary btn--sm"><x-admin.icon name="plus" :size="15" /> Stok</a>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    {{-- Pesanan terbaru --}}
    <section class="card card--clip">
        <div class="section-head">
            <div>
                <h2>Pesanan Terbaru Hari Ini</h2>
                <p>Daftar transaksi masuk real-time yang siap diverifikasi dan dikirimkan.</p>
            </div>
            <a href="{{ $link('admin.orders.index') }}" class="btn btn--soft btn--sm">Semua Pesanan <x-admin.icon name="arrow-right" :size="16" /></a>
        </div>
        <div class="table-wrap">
            <table class="table table--soft">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Nama Pembeli</th>
                        <th>Produk &amp; Jumlah</th>
                        <th class="text-right">Total Bayar</th>
                        <th>Status Pembayaran / Pesanan</th>
                        <th>Waktu</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td><b class="order-no">{{ $order['no'] }}</b></td>
                            <td>
                                <div class="user-cell">
                                    <x-admin.avatar :name="$order['buyer']" :size="34" />
                                    <div><b>{{ $order['buyer'] }}</b><small class="cell-sub">{{ $order['city'] }}</small></div>
                                </div>
                            </td>
                            <td><span class="prod-cell">{{ $order['product'] }}<em class="qty">x{{ $order['qty'] }}</em></span></td>
                            <td class="text-right price">Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                            <td><span class="status status--{{ $order['status'] }}">{{ $order['status_label'] }}</span></td>
                            <td class="text-muted">{{ $order['time'] }}</td>
                            <td>
                                @switch($order['action'])
                                    @case('check')
                                        <a href="{{ $link('admin.payments.index') }}" class="btn btn--primary btn--sm"><x-admin.icon name="badge-check" :size="16" /> Periksa Bukti</a>
                                        @break
                                    @case('ship')
                                        <a href="{{ $link('admin.orders.index') }}" class="btn btn--primary btn--sm"><x-admin.icon name="truck" :size="16" /> Proses Kirim</a>
                                        @break
                                    @case('track')
                                        <a href="{{ $link('admin.orders.index') }}" class="btn btn--soft btn--sm"><x-admin.icon name="locate" :size="16" /> Lacak Resi</a>
                                        @break
                                    @default
                                        <a href="{{ $link('admin.orders.index') }}" class="btn btn--soft btn--sm {{ $order['action'] === 'detail-dim' ? 'is-dim' : '' }}"><x-admin.icon name="eye" :size="16" /> Detail</a>
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/dashboard.js') }}" defer></script>
@endpush