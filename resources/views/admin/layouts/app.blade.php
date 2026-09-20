<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Umi Store Admin</title>
    @csrf
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <div class="admin-layout">

        {{-- Sidebar (file terpisah) --}}
        @include('admin.partials.sidebar')

        <div class="admin-main">

            {{-- Topbar --}}
            <header class="admin-topbar">
                <div class="topbar-search">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                    <input type="text" placeholder="Cari pesanan, produk, atau pelanggan...">
                </div>

                <div class="topbar-user">
                    <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}" alt="Avatar">
                    <div class="topbar-user-info">
                        <strong>{{ auth()->user()->name ?? 'Admin' }} (Owner)</strong>
                        <span>Administrator</span>
                    </div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </div>
            </header>

            {{-- Konten halaman --}}
            <main class="admin-content">
                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')
</body>
</html>