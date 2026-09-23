@extends('admin.layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Tambah Produk Baru</h1>
            <p class="page-subtitle">Lengkapi informasi detail busana untuk ditampilkan di katalog pelanggan.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn--secondary"><x-admin.icon name="arrow-left" :size="18" /> Kembali</a>
    </div>

    @include('admin.products._form')
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/products.js') }}" defer></script>
@endpush