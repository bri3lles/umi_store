@extends('admin.layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Manajemen Produk</h1>
            <p class="page-subtitle">Kelola katalog pakaian, foto, kategori, dan harga produk toko Anda.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn--primary"><x-admin.icon name="plus" :size="18" /> Tambah Produk Baru</a>
    </div>

    <form method="GET" action="{{ route('admin.products.index') }}" class="card toolbar toolbar--fill">
        <label class="search-field">
            <x-admin.icon name="search" :size="18" />
            <input type="search" name="q" class="input" value="{{ request('q') }}" placeholder="Cari nama produk, SKU, atau kategori..." aria-label="Cari produk">
        </label>
        <select name="category" class="select" aria-label="Filter kategori" data-autosubmit>
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
            @endforeach
        </select>
        <select name="status" class="select" aria-label="Filter status" data-autosubmit>
            <option value="">Status Produk</option>
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select name="sort" class="select" aria-label="Urutkan" data-autosubmit>
            @foreach ($sorts as $value => $label)
                <option value="{{ $value }}" @selected(request('sort', 'newest') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <a href="{{ route('admin.products.index') }}" class="btn btn--soft"><x-admin.icon name="sliders" :size="18" /> Reset Filter</a>
    </form>

    <div class="card card--clip">
        <div class="table-wrap">
            <table class="table table--soft">
                <thead>
                    <tr>
                        <th class="col-check"><input type="checkbox" data-check-all aria-label="Pilih semua produk"></th>
                        <th class="col-photo">Foto</th>
                        <th>Nama Produk &amp; SKU</th>
                        <th>Kategori</th>
                        <th class="text-right">Harga Jual</th>
                        <th>Stok Fisik</th>
                        <th>Status</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="{{ $product->status_key === 'off' ? 'is-muted' : '' }}">
                            <td><input type="checkbox" data-check-row aria-label="Pilih {{ $product->name }}"></td>
                            <td><a href="{{ route('admin.products.show', $product->id) }}" tabindex="-1" aria-hidden="true"><x-admin.product-thumb :color="$product->color" :size="56" /></a></td>
                            <td>
                                <a class="product-name" href="{{ route('admin.products.show', $product->id) }}">{{ $product->name }}</a>
                                <span class="product-sku"><x-admin.icon name="qr-code" :size="13" /> SKU: {{ $product->sku }}</span>
                            </td>
                            <td><span class="chip">{{ $product->category }}</span></td>
                            <td class="text-right price">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td><span class="pill pill--{{ $product->stock_level }}">{{ $product->stock_label }}</span></td>
                            <td><span class="badge badge--{{ $product->status_key }}">{{ $statuses[$product->status_key] }}</span></td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="icon-btn" title="Detail" aria-label="Detail {{ $product->name }}"><x-admin.icon name="eye" :size="18" /></a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="icon-btn icon-btn--edit" title="Edit" aria-label="Edit {{ $product->name }}"><x-admin.icon name="pencil" :size="17" /></a>
                                    <button type="button" class="icon-btn icon-btn--del" title="Hapus" aria-label="Hapus {{ $product->name }}"
                                            data-modal-open="delete" data-action="{{ route('admin.products.destroy', $product->id) }}" data-name="{{ $product->name }}">
                                        <x-admin.icon name="trash" :size="17" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8"><div class="empty">Tidak ada produk yang cocok. Ubah kata kunci atau filter pencarian.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-admin.pagination :paginator="$products" />
    </div>

    @include('admin.products._delete-confirm')
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/products.js') }}" defer></script>
@endpush