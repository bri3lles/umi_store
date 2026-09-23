@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Edit Produk</h1>
            <p class="page-subtitle">Perbarui informasi, foto, varian, harga, dan stok untuk {{ $product->name }}.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn--secondary"><x-admin.icon name="arrow-left" :size="18" /> Kembali</a>
    </div>

    @include('admin.products._form')
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/products.js') }}" defer></script>
@endpush