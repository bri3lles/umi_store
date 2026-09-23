@php
    // Route yang belum dibuat otomatis mengarah ke "#" agar aside tetap bisa dirender.
    $menu = [
        ['Dashboard',              'admin.dashboard',        'dashboard',    'admin.dashboard'],
        ['Kelola User',            'admin.users.index',      'users',        'admin.users.*'],
        ['Manajemen Produk',       'admin.products.index',   'shirt',        'admin.products.*'],
        ['Manajemen Stok',         'admin.stock.index',      'archive',      'admin.stock.*'],
        ['Manajemen Pesanan',      'admin.orders.index',     'truck',        'admin.orders.*'],
        ['Manajemen Retur',        'admin.returns.index',    'return',       'admin.returns.*'],
        ['Kelola Rating & Ulasan', 'admin.reviews.index',    'star',         'admin.reviews.*'],
        ['Rekap Penjualan',        'admin.reports.index',    'chart',        'admin.reports.*'],
        ['Pengaturan Akun',        'admin.settings.index',   'sliders',      'admin.settings.*'],
    ];
    $storeOpen = $storeOpen ?? true; // nanti diambil dari database
@endphp

<aside class="admin-aside" id="admin-aside" aria-label="Menu admin">
    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" class="admin-aside__brand">
        <span class="admin-aside__brand-group">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Umi Store" class="admin-aside__logo">
            <span>Umi Store</span>
        </span>
        <button type="button" class="admin-aside__close" data-aside-toggle aria-label="Tutup menu"><x-admin.icon name="x" /></button>
    </a>

    <div class="admin-aside__status">
        <span>Status Operasional</span>
        <span class="admin-aside__pill {{ $storeOpen ? '' : 'is-closed' }}">{{ $storeOpen ? 'Buka' : 'Tutup' }}</span>
    </div>

    <nav class="admin-aside__nav">
        @foreach ($menu as [$label, $route, $icon, $pattern])
            <a href="{{ Route::has($route) ? route($route) : '#' }}"
               class="admin-aside__link {{ request()->routeIs($pattern) ? 'is-active' : '' }}"
               @if (request()->routeIs($pattern)) aria-current="page" @endif>
                <x-admin.icon :name="$icon" />
                <span>{{ $label }}</span>
            </a>
        @endforeach
    </nav>

    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="admin-aside__logout">
        @csrf
        <button type="submit"><x-admin.icon name="log-out" /> Keluar / Logout</button>
    </form>
</aside>