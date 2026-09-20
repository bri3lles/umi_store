@extends('admin.layouts.app')

@section('title', 'Beranda & Ringkasan Toko')

@section('content')

    <div class="page-heading">
        <h1>Beranda &amp; Ringkasan Toko</h1>
        <p>Selamat datang kembali, {{ auth()->user()->name ?? 'Ibu Rahma' }}! Berikut rangkuman aktivitas dan tindakan penting toko hari ini.</p>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-card-head">
                <span>Pesanan Baru</span>
                <span class="summary-icon icon-blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                        <path d="M3 6h18"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                </span>
            </div>
            <div class="summary-value">{{ $summary['pesananBaru'] ?? 14 }} <small>Pesanan</small></div>
            <span class="summary-tag tag-blue">{{ $summary['pesananPerluDiproses'] ?? 8 }} perlu diproses</span>
        </div>

        <div class="summary-card">
            <div class="summary-card-head">
                <span>Verifikasi Bayar</span>
                <span class="summary-icon icon-orange">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path d="M8 8h8M8 12h8M8 16h5"/>
                    </svg>
                </span>
            </div>
            <div class="summary-value">{{ $summary['verifikasiBayar'] ?? 5 }} <small>Bukti Transfer</small></div>
            <span class="summary-tag tag-orange">Perlu Konfirmasi</span>
        </div>

        <div class="summary-card">
            <div class="summary-card-head">
                <span>Stok Menipis</span>
                <span class="summary-icon icon-red">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="4" rx="1"/>
                        <path d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8"/>
                    </svg>
                </span>
            </div>
            <div class="summary-value">{{ $summary['stokMenipis'] ?? 3 }} <small>Produk</small></div>
            <span class="summary-tag tag-red">Segera Restock</span>
        </div>

        <div class="summary-card">
            <div class="summary-card-head">
                <span>Pengajuan Retur</span>
                <span class="summary-icon icon-purple">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12a9 9 0 1 0 3-6.7"/>
                        <path d="M3 4v5h5"/>
                    </svg>
                </span>
            </div>
            <div class="summary-value">{{ $summary['pengajuanRetur'] ?? 2 }} <small>Pengajuan</small></div>
            <span class="summary-tag tag-purple">Cek Bukti</span>
        </div>
    </div>

    {{-- Grafik & Stok menipis --}}
    <div class="content-grid">

        <div class="chart-card">
            <div class="chart-head">
                <div>
                    <span class="chart-label">Tren Penjualan Toko</span>
                    <div class="chart-total">
                        Rp {{ number_format($chart['total'] ?? 24600000, 0, ',', '.') }}
                        <span class="chart-growth">+{{ $chart['growthPercent'] ?? '18.5' }}% mingguan</span>
                    </div>
                </div>
                <div class="chart-toggle">
                    <button type="button" class="active">Minggu Ini</button>
                    <button type="button">Bulan Ini</button>
                </div>
            </div>

            @php
                $chartLabels = $chart['labels'] ?? ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
                $chartValues = $chart['values'] ?? [2.1, 1.9, 3.2, 3.9, 4.1, 3.6, 3.8]; // dalam juta
                $max = max($chartValues);
                $min = min($chartValues);
                $w = 900; $h = 260; $padX = 20; $padY = 30;
                $stepX = ($w - 2 * $padX) / (count($chartValues) - 1);
                $points = [];
                foreach ($chartValues as $i => $v) {
                    $x = $padX + $i * $stepX;
                    $y = $h - $padY - (($v - $min) / max(($max - $min), 0.01)) * ($h - 2 * $padY);
                    $points[] = [$x, $y];
                }
                $polyline = implode(' ', array_map(fn($p) => $p[0] . ',' . $p[1], $points));
                $areaPath = 'M' . $padX . ',' . $h . ' L' . $polyline . ' L' . ($w - $padX) . ',' . $h . ' Z';
            @endphp

            <div class="chart-svg-wrap">
                <svg viewBox="0 0 {{ $w }} {{ $h }}" preserveAspectRatio="none" class="sales-chart">
                    <path d="{{ $areaPath }}" class="chart-area"></path>
                    <polyline points="{{ $polyline }}" class="chart-line"></polyline>
                    @foreach ($points as $p)
                        <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="4" class="chart-dot"></circle>
                    @endforeach
                </svg>
            </div>

            <div class="chart-x-labels">
                @foreach ($chartLabels as $i => $label)
                    <div class="chart-x-label {{ $i === count($chartLabels) - 1 ? 'is-current' : '' }}">
                        <span>{{ $label }}</span>
                        <small>{{ number_format($chartValues[$i], 1) }}jt</small>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lowstock-card">
            <div class="lowstock-head">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                        <path d="M12 9v4M12 17h.01"/>
                    </svg>
                    Stok Menipis
                </h3>
                <a href="{{ route('admin.stock.index') }}">Lihat Semua Stok</a>
            </div>
            <p class="lowstock-desc">Perlu pengadaan ulang agar pesanan pelanggan tidak tertahan.</p>

            <div class="lowstock-list">
                @forelse ($lowStock ?? [] as $item)
                    <div class="lowstock-item">
                        <img src="{{ $item['image'] ?? asset('images/placeholder-product.png') }}" alt="{{ $item['name'] }}">
                        <div class="lowstock-info">
                            <strong>{{ $item['name'] }}</strong>
                            <span>Varian: {{ $item['variant'] }} &bull; SKU: {{ $item['sku'] }}</span>
                            <span class="stock-badge {{ ($item['qty'] ?? 0) == 0 ? 'stock-out' : 'stock-low' }}">
                                {{ ($item['qty'] ?? 0) == 0 ? 'Habis (0 pcs)' : 'Tersisa ' . $item['qty'] . ' pcs' }}
                            </span>
                        </div>
                        <a href="{{ route('admin.stock.edit', $item['id']) }}" class="btn-stock">+ Stok</a>
                    </div>
                @empty
                    {{-- Data contoh selama belum terhubung ke database --}}
                    <div class="lowstock-item">
                        <img src="{{ asset('images/placeholder-product.png') }}" alt="Gamis Rayon Premium">
                        <div class="lowstock-info">
                            <strong>Gamis Rayon Premium</strong>
                            <span>Varian: Size L &bull; SKU: GMS-NV-L</span>
                            <span class="stock-badge stock-low">Tersisa 2 pcs</span>
                        </div>
                        <a href="{{ route('admin.stock.index') }}" class="btn-stock">+ Stok</a>
                    </div>
                    <div class="lowstock-item">
                        <img src="{{ asset('images/placeholder-product.png') }}" alt="Hijab Segiempat">
                        <div class="lowstock-info">
                            <strong>Hijab Segiempat</strong>
                            <span>Varian: All Size &bull; SKU: HJB-VO-OL</span>
                            <span class="stock-badge stock-out">Habis (0 pcs)</span>
                        </div>
                        <a href="{{ route('admin.stock.index') }}" class="btn-stock">+ Stok</a>
                    </div>
                    <div class="lowstock-item">
                        <img src="{{ asset('images/placeholder-product.png') }}" alt="Kulot Linen Pants">
                        <div class="lowstock-info">
                            <strong>Kulot Linen Pants</strong>
                            <span>Varian: Size XL &bull; SKU: KLT-LN-SD</span>
                            <span class="stock-badge stock-low">Tersisa 3 pcs</span>
                        </div>
                        <a href="{{ route('admin.stock.index') }}" class="btn-stock">+ Stok</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Tabel pesanan terbaru --}}
    <div class="orders-card">
        <div class="orders-head">
            <div>
                <h3>Pesanan Terbaru Hari Ini</h3>
                <p>Daftar transaksi masuk real-time yang siap diverifikasi dan dikirimkan.</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn-outline">Semua Pesanan &rarr;</a>
        </div>

        <div class="orders-table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Nama Pembeli</th>
                        <th>Produk &amp; Jumlah</th>
                        <th>Total Bayar</th>
                        <th>Status Pembayaran / Pesanan</th>
                        <th>Waktu</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($recentOrders ?? [] as $order)
                    <tr>
                        <td><strong>{{ $order['no'] }}</strong></td>
                        <td>
                            <div class="buyer-cell">
                                <span class="buyer-avatar">{{ $order['initials'] }}</span>
                                <div>
                                    <strong>{{ $order['name'] }}</strong>
                                    <span>{{ $order['city'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order['product'] }} <span class="qty-badge">x{{ $order['qty'] }}</span></td>
                        <td>Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                        <td><span class="status-badge status-{{ $order['statusClass'] }}">{{ $order['statusLabel'] }}</span></td>
                        <td>{{ $order['time'] }}</td>
                        <td>
                            <a href="{{ $order['actionUrl'] }}" class="action-btn action-{{ $order['actionVariant'] }}">
                                {{ $order['actionLabel'] }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">Belum ada pesanan hari ini.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection