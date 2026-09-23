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
      <div class="language-wrapper">
    <button type="button"
            class="language-btn"
            id="languageBtn"
            aria-label="Pilih bahasa">
      <i class="fa-solid fa-globe"></i>
    </button>

    <!-- Popup Bahasa -->
    <div class="language-popup" id="languagePopup">
      <div class="language-popup-title">
        Pilih Bahasa
      </div>

      <a href="{{ route('lang.switch', ['locale' => 'id']) }}" class="language-option active">
        <span class="language-left">
          <span>Bahasa Indonesia</span>
        </span>

        <i class="fa-solid fa-check"></i>
      </a>

      <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="language-option">
        <span class="language-left">
          <span>English</span>
        </span>
      </a>
    </div>
  </div>
      <a href="{{ route('keranjang') }}"><img src="{{ asset('images/kranjang.png') }}" alt="Keranjang" class="nav-icon-img"></a>
      <a href="{{ auth()->check() ? route('profile.pengaturan') : route('login') }}"><img src="{{ asset('images/user.png') }}" alt="Akun" class="nav-icon-img"></a>
    </div>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const languageBtn = document.getElementById('languageBtn');
    const languagePopup = document.getElementById('languagePopup');

    // Buka / tutup popup
    languageBtn.addEventListener('click', function (event) {
        event.stopPropagation();

        languagePopup.classList.toggle('show');
    });

    // Jangan tutup ketika klik isi popup
    languagePopup.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    // Klik di luar popup → tutup
    document.addEventListener('click', function () {
        languagePopup.classList.remove('show');
    });

});
</script>