@extends('admin.layouts.app')

@section('title', 'Manajemen Stok')

@section('content')
    @php
        $status = request('status');
        $tabs = ['' => ['Semua', $counts['all']], 'low' => ['Stok Menipis', $counts['low']], 'out' => ['Stok Habis', $counts['out']]];
    @endphp

    <div class="page-head">
        <div>
            <h1 class="page-title">Manajemen &amp; Pembaruan Stok</h1>
            <p class="page-subtitle">Pantau stok persediaan barang dan ubah jumlah stok dengan cepat tanpa ribet.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert--danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="card toolbar toolbar--fill stock-toolbar">
        <form method="GET" action="{{ route('admin.stock.index') }}" class="search-field">
            <x-admin.icon name="search" :size="18" />
            <input type="search" name="q" class="input" value="{{ request('q') }}" placeholder="Cari produk atau variasi ukuran (S, M, L, XL)..." aria-label="Cari produk">
            @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
        </form>
        <div class="filter-status">
            <span>Filter Status:</span>
            <nav class="seg-tabs" aria-label="Filter status stok">
                @foreach ($tabs as $key => [$label, $count])
                    <a href="{{ route('admin.stock.index', array_filter(['status' => $key, 'q' => request('q')])) }}"
                       class="{{ (string) $status === (string) $key ? 'is-active' : '' }}">{{ $label }} ({{ $count }})</a>
                @endforeach
            </nav>
        </div>
    </div>

    <div class="card card--clip">
        <div class="table-wrap">
            <table class="table table--soft stock-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Produk &amp; Variasi</th>
                        <th>Kategori</th>
                        <th>Stok Saat Ini</th>
                        <th>Status Indikator</th>
                        <th>Update Cepat Stok</th>
                        <th>Terakhir Diperbarui</th>
                        <th>Riwayat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr data-stock-row data-current="{{ $item->stock }}" data-name="{{ $item->name }}" data-variant="{{ $item->variant }}"
                            data-action="{{ route('admin.stock.adjust', $item->id) }}" data-history="{{ json_encode($item->history) }}">
                            <td><x-admin.product-thumb :color="$item->color" :size="48" /></td>
                            <td>
                                <b class="product-name">{{ $item->name }}</b>
                                <small class="cell-sub">{{ $item->variant }}</small>
                            </td>
                            <td><span class="chip">{{ $item->category }}</span></td>
                            <td><span class="stock-num stock-num--{{ $item->level }}">{{ $item->stock }}</span> <small class="text-muted">pcs</small></td>
                            <td><span class="ind ind--{{ $item->level }}">{{ ['ok' => 'Aman', 'low' => 'Menipis', 'out' => 'Habis'][$item->level] }}</span></td>
                            <td>
                                <div class="quick">
                                    <div class="stepper">
                                        <button type="button" data-step="-1" aria-label="Kurangi stok"><x-admin.icon name="minus" :size="16" /></button>
                                        <input type="number" min="0" value="{{ $item->stock }}" data-qty aria-label="Jumlah stok {{ $item->name }}">
                                        <button type="button" data-step="1" aria-label="Tambah stok"><x-admin.icon name="plus" :size="16" /></button>
                                    </div>
                                    <button type="button" class="btn btn--sm" data-save>
                                        <span data-ico="save"><x-admin.icon name="check" :size="15" /></span>
                                        <span data-ico="restock" hidden><x-admin.icon name="package-plus" :size="15" /></span>
                                        <span data-label>Simpan</span>
                                    </button>
                                </div>
                            </td>
                            <td class="text-muted nowrap"><x-admin.icon name="clock" :size="14" class="inline-ico" /> {{ $item->updated }}</td>
                            <td><button type="button" class="link-btn" data-history-open>Riwayat Stok</button></td>
                        </tr>
                    @empty
                        <tr><td colspan="8"><div class="empty">Tidak ada stok yang cocok. Ubah kata kunci atau filter status.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-admin.pagination :paginator="$items" />
    </div>

    {{-- Modal ubah stok --}}
    <div class="modal" data-modal="adjust" role="dialog" aria-modal="true" aria-labelledby="adj-title">
        <div class="modal__dialog">
            <h2 class="modal__title" id="adj-title">Ubah Stok</h2>
            <p class="modal__text"><strong data-adj-name></strong><br><span data-adj-variant></span></p>
            <form method="POST" action="#" class="form-fill" data-adj-form>
                @csrf
                <div class="adj-grid">
                    <div class="field">
                        <label class="field__label" for="adj-current">Stok saat ini</label>
                        <input type="text" id="adj-current" class="input" readonly data-adj-current>
                    </div>
                    <div class="field">
                        <label class="field__label" for="adj-qty">Stok baru <i>*</i></label>
                        <input type="number" id="adj-qty" name="quantity" min="0" class="input" required data-adj-qty>
                    </div>
                </div>
                <p class="diff" data-adj-diff></p>
                <div class="field">
                    <label class="field__label" for="adj-reason">Alasan perubahan <i>*</i></label>
                    <select id="adj-reason" name="reason" class="select" required>
                        @foreach ($reasons as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field adj-note">
                    <label class="field__label" for="adj-note">Catatan <small class="text-muted">(opsional)</small></label>
                    <textarea id="adj-note" name="note" rows="2" maxlength="255" class="input textarea" placeholder="Contoh: barang datang dari konveksi Bu Sari"></textarea>
                </div>
                <div class="modal__actions">
                    <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn--primary" data-adj-submit disabled>Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal riwayat stok --}}
    <div class="modal" data-modal="history" role="dialog" aria-modal="true" aria-labelledby="hist-title">
        <div class="modal__dialog modal__dialog--wide">
            <h2 class="modal__title" id="hist-title">Riwayat Stok</h2>
            <p class="modal__text"><strong data-hist-name></strong><br><span data-hist-variant></span></p>
            <div class="table-wrap history-wrap">
                <table class="table history-table">
                    <thead><tr><th>Tanggal</th><th>Perubahan</th><th>Stok Akhir</th><th>Keterangan</th><th>Oleh</th></tr></thead>
                    <tbody data-hist-body></tbody>
                </table>
            </div>
            <div class="modal__actions"><button type="button" class="btn btn--secondary" data-modal-close>Tutup</button></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/stock.js') }}" defer></script>
@endpush