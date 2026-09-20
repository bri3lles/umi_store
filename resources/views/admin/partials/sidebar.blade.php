<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <span>Umi Store</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                <rect x="14" y="14" width="7" height="7" rx="1.5"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 7 12 3 4 7v10l8 4 8-4V7Z"/>
                <path d="M4 7l8 4 8-4"/>
                <path d="M12 11v10"/>
            </svg>
            <span>Manajemen Produk</span>
        </a>

        <a href="{{ route('admin.stock.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="4" rx="1"/>
                <path d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8"/>
                <path d="M10 12h4"/>
            </svg>
            <span>Manajemen Stok</span>
        </a>

        <a href="{{ route('admin.payments.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4.5 8-11V5l-8-3-8 3v6c0 6.5 8 11 8 11Z"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
            <span>Verifikasi Pembayaran</span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="7" width="14" height="10" rx="1.5"/>
                <path d="M17 10h3l1 3v4h-4"/>
                <circle cx="7.5" cy="18.5" r="1.5"/>
                <circle cx="17.5" cy="18.5" r="1.5"/>
            </svg>
            <span>Manajemen Pesanan</span>
        </a>

        <a href="{{ route('admin.returns.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="16" rx="2"/>
                <path d="M9 4v16"/>
                <path d="m6 12-2 0 2-2"/>
                <path d="M4 12h6"/>
            </svg>
            <span>Manajemen Retur</span>
        </a>

        <a href="{{ route('admin.sales.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 3v18h18"/>
                <path d="m7 15 4-5 3 3 5-7"/>
            </svg>
            <span>Rekap Penjualan</span>
        </a>

        <a href="{{ route('admin.account.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.account.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 21v-2a6 6 0 0 1 6-6h1"/>
                <circle cx="9.5" cy="7" r="4"/>
                <path d="M15 14h6M18 11v6"/>
            </svg>
            <span>Pengaturan Akun</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="status-row">
            <span>Status Operasional</span>
            <form action="{{ route('admin.status.toggle') }}" method="POST" class="status-toggle-form">
                @csrf
                <button type="submit" class="status-toggle {{ ($tokoBuka ?? true) ? 'is-open' : 'is-closed' }}">
                    <span class="status-dot"></span>
                    {{ ($tokoBuka ?? true) ? 'Buka' : 'Tutup' }}
                </button>
            </form>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-link logout-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <path d="M16 17l5-5-5-5"/>
                    <path d="M21 12H9"/>
                </svg>
                <span>Keluar / Logout</span>
            </button>
        </form>
    </div>
</aside>