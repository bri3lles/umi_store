<nav class="navbar">
  <div class="container">
    <!-- Logo menuju ke Beranda -->
    <a href="{{ route('beranda') }}" class="brand-logo">
      <img src="{{ asset('images/logo.png') }}" alt="UMI STORE Logo" class="brand-logo-img">
    </a>
    
    <!-- Link Navigasi -->
    <div class="nav-links">
      <a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">
        Beranda
      </a>
      <a href="{{ route('katalog') }}" class="nav-link {{ request()->routeIs('katalog') ? 'active' : '' }}">
        Katalog
      </a>
      <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
        Tentang
      </a>
    </div>

    <!-- Icon Navigasi -->
    <div class="nav-icons">
      <a href="keranjang"><img src="{{ asset('images/kranjang.png') }}" alt="Keranjang" class="nav-icon-img"></a>
      <a href="#"><img src="{{ asset('images/user.png') }}" alt="Akun" class="nav-icon-img"></a>
    </div>
  </div>
</nav>