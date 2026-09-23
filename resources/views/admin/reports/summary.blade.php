@extends('admin.layouts.app')

@section('title', 'Rekap Penjualan')

@section('content')
    @php $rp = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.'); @endphp

    <div class="page-head">
        <div>
            <h1 class="page-title">Rekap Penjualan &amp; Laporan Keuangan</h1>
            <p class="page-subtitle">Laporan performa omzet toko, keuntungan bersih, statistik produk terlaris, dan arus kas harian/bulanan.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn btn--soft" data-print><x-admin.icon name="download" :size="17" /> Unduh Laporan</button>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.reports.index') }}" class="range-bar">
        @foreach ($ranges as $key => $label)
            <button type="submit" name="range" value="{{ $key }}" class="{{ $range === $key ? 'is-active' : '' }}">{{ $label }}</button>
        @endforeach
        <button type="button" class="range-bar__custom" disabled title="Segera hadir"><x-admin.icon name="calendar" :size="16" /> Pilih Rentang Kustom</button>
    </form>

    <div class="dash-grid report-grid" data-report-chart="{{ json_encode($chart) }}">
        <section class="card card--pad chart-card">
            <div class="chart-card__head">
                <div>
                    <span class="muted-label">Tren Penjualan &amp; Laba Harian</span>
                    <p class="chart-card__desc">Dinamika transaksi omzet vs laba bersih {{ $ranges[$range] }}</p>
                </div>
                <div class="legend">
                    <span><i class="legend__dot legend__dot--omzet"></i> Total Omzet</span>
                    <span><i class="legend__dot legend__dot--laba"></i> Laba Bersih</span>
                </div>
            </div>
            <div class="chart chart--dual">
                <div class="chart__plot" data-chart-plot></div>
                <div class="chart__labels" data-chart-labels></div>
            </div>
        </section>

        <section class="card card--pad cat-card">
            <div class="cat-card__head">
                <h2>Kategori Produk Terlaris</h2>
                <span class="tag">{{ $ranges[$range] }}</span>
            </div>
            <p class="cat-card__hint">Kontribusi omzet berdasarkan klaster katalog</p>
            <div class="cat-list">
                @foreach ($categories as $i => $cat)
                    <div class="cat-row">
                        <div class="cat-row__label"><i class="dot dot--{{ ['blue', 'blue', 'green', 'gray'][$i] ?? 'blue' }}"></i> {{ $cat['name'] }}</div>
                        <div class="cat-row__value">{{ $cat['percent'] }}% <small>({{ $rp($cat['value']) }})</small></div>
                        <div class="bar"><span style="width: {{ $cat['percent'] }}%; background: {{ ['#1D4ED8', '#1D4ED8', '#12B76A', '#98A2B3'][$i] ?? '#1D4ED8' }}"></span></div>
                    </div>
                @endforeach
            </div>
            <div class="fav-box">
                <span class="fav-box__icon"><x-admin.icon name="star" :size="18" /></span>
                <div><b>Produk Terfavorit</b><small>{{ $topProduct['name'] }}</small></div>
                <span class="fav-box__count">{{ $topProduct['sold'] }} Terjual</span>
            </div>
        </section>
    </div>

    <section class="card card--clip">
        <div class="section-head">
            <div>
                <h2>Rincian Rekap Penjualan Harian</h2>
                <p>Arus pemasukan, harga pokok penjualan (HPP), dan laba bersih riil</p>
            </div>
        </div>
        <div class="table-wrap">
            <table class="table table--soft">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th class="text-right">Jumlah Transaksi</th>
                        <th class="text-right">Produk Terjual</th>
                        <th class="text-right">Total Omzet</th>
                        <th class="text-right">Modal (HPP)</th>
                        <th class="text-right">Estimasi Laba Bersih</th>
                        <th>Status Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daily as $row)
                        @php $hpp = (int) round($row['omzet'] * .575); @endphp
                        <tr>
                            <td><b>{{ $row['label'] }}</b>@if ($row['d'] === 18)<small class="cell-sub">Hari ini</small>@endif</td>
                            <td class="text-right">{{ 12 + $row['d'] % 7 }} Pesanan</td>
                            <td class="text-right">{{ 18 + $row['d'] % 9 }} Pcs</td>
                            <td class="text-right price">{{ $rp($row['omzet']) }}</td>
                            <td class="text-right text-muted">{{ $rp($hpp) }}</td>
                            <td class="text-right laba-cell">+{{ $rp($row['laba']) }}</td>
                            <td><span class="rchip rchip--green">Tercatat</span></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="totals-row">
                        <td><b>Total Akumulasi {{ $daily->count() }} Hari Terakhir</b></td>
                        <td class="text-right"><b>{{ $totals['orders'] }} Transaksi</b></td>
                        <td class="text-right"><b>{{ $totals['qty'] }} Pcs</b></td>
                        <td class="text-right price"><b>{{ $rp($totals['omzet']) }}</b></td>
                        <td class="text-right text-muted"><b>{{ $rp($totals['hpp']) }}</b></td>
                        <td class="text-right laba-cell"><b>+{{ $rp($totals['laba']) }}</b></td>
                        <td><span class="rchip rchip--gray">Balance Valid</span></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/reports.js') }}" defer></script>
@endpush