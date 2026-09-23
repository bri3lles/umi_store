@extends('admin.layouts.app')

@section('title', 'Detail Produk')

@section('content')
    @php $statusKey = $product->status_key; @endphp

    <div class="page-head">
        <div>
            <h1 class="page-title">Detail Produk</h1>
            <p class="page-subtitle">Informasi lengkap produk seperti yang tampil di katalog.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.products.index') }}" class="btn btn--secondary"><x-admin.icon name="arrow-left" :size="18" /> Kembali</a>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn--primary"><x-admin.icon name="pencil" :size="18" /> Edit</a>
            <button type="button" class="btn btn--danger" data-modal-open="delete" data-action="{{ route('admin.products.destroy', $product->id) }}" data-name="{{ $product->name }}">
                <x-admin.icon name="trash" :size="18" /> Hapus
            </button>
        </div>
    </div>

    <div class="product-detail">
        <div class="card card--pad">
            <x-admin.product-thumb class="gallery-main" :color="$product->color" :size="120" />
            <div class="gallery-thumbs">
                @foreach ($product->photos as $photo)
                    <div class="gallery-thumbs__item" title="{{ $photo['label'] }}"><x-admin.product-thumb :color="$photo['color']" :size="56" /></div>
                @endforeach
            </div>
        </div>

        <div class="stack-24">
            <div class="card card--pad">
                <div class="tags">
                    <span class="chip">{{ $product->category }}</span>
                    <span class="badge badge--{{ $statusKey }}">{{ $statuses[$statusKey] }}</span>
                    <span class="chip">{{ $product->readiness === 'po' ? 'Pre-Order (PO)' : 'Ready Stock' }}</span>
                    @if ($product->featured)<span class="chip">Rekomendasi Beranda</span>@endif
                </div>
                <h2 class="detail-title">{{ $product->name }}</h2>
                <span class="product-sku"><x-admin.icon name="qr-code" :size="14" /> SKU: {{ $product->sku }}</span>

                <div class="price-box">
                    <div>
                        <span class="price-box__label">Harga jual</span>
                        <div class="price-box__main">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                    @if ($product->promo_price)
                        <div><span class="price-box__label">Harga coret</span><div><s>Rp {{ number_format($product->promo_price, 0, ',', '.') }}</s></div></div>
                    @endif
                    <div><span class="price-box__label">Harga modal</span><div>Rp {{ number_format($product->cost_price, 0, ',', '.') }}</div></div>
                    <div><span class="price-box__label">Estimasi laba</span><div>Rp {{ number_format($product->price - $product->cost_price, 0, ',', '.') }}</div></div>
                </div>

                <dl class="info-grid" style="margin-top: 24px">
                    <div><dt>Bahan / material</dt><dd>{{ $product->material }}</dd></div>
                    <div><dt>Label / koleksi</dt><dd>{{ $product->label }}</dd></div>
                    <div><dt>Total stok</dt><dd><span class="pill pill--{{ $product->stock_level }}">{{ $product->stock_label }}</span></dd></div>
                    <div><dt>Batas stok menipis</dt><dd>{{ $product->stock_alert }} pcs</dd></div>
                    <div><dt>Berat paket</dt><dd>{{ $product->weight }} gram</dd></div>
                    <div><dt>Dimensi paket</dt><dd>{{ $product->length }} × {{ $product->width }} × {{ $product->height }} cm</dd></div>
                    <div><dt>Ekspedisi aktif</dt><dd>{{ collect($product->couriers)->map(fn ($c) => $couriers[$c][0])->implode(', ') }}</dd></div>
                    <div><dt>Ditambahkan</dt><dd>{{ $product->created_at->locale('id')->translatedFormat('d F Y') }}</dd></div>
                </dl>
            </div>

            <div class="card card--pad">
                <h2 class="info-title">Deskripsi</h2>
                <p class="desc">{{ $product->description }}</p>
            </div>

            <div class="card card--clip">
                <h2 class="info-title" style="padding: 24px 24px 0">Varian Produk</h2>
                <div class="table-wrap">
                    <table class="table table--soft" style="min-width: 640px">
                        <thead><tr><th>Varian</th><th>SKU Varian</th><th class="text-right">Harga Tambahan</th><th>Stok</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach ($product->variants as $variant)
                                @php $hex = collect($product->colors)->firstWhere('name', $variant['color'])['hex'] ?? '#94A3B8'; @endphp
                                <tr>
                                    <td><span class="variant-name"><i style="background: {{ $hex }}"></i>{{ $variant['color'] }} - {{ $variant['size'] }}</span></td>
                                    <td class="text-muted">{{ $variant['sku'] }}</td>
                                    <td class="text-right">+Rp {{ number_format($variant['extra'], 0, ',', '.') }}</td>
                                    <td>{{ $variant['stock'] }} pcs</td>
                                    <td><span class="badge {{ $variant['stock'] > 0 ? 'badge--active' : 'badge--out' }}">{{ $variant['stock'] > 0 ? 'Tersedia' : 'Habis' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.products._delete-confirm')
@endsection