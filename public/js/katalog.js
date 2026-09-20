document.addEventListener('DOMContentLoaded', function () {
  const pills = document.querySelectorAll('.pill-btn');
  const katalogGrid = document.getElementById('katalogGrid');
  const cards = Array.from(document.querySelectorAll('#katalogGrid .product-card'));
  const searchInput = document.getElementById('searchInput');
  const sortSelect = document.getElementById('sortSelect');
  const paginationWrapper = document.querySelector('.pagination-wrapper');

  let currentCategory = 'all';

  // Fungsi Pembantu: Mengambil Angka Harga dari Teks "Rp 479.000"
  function getProductPrice(card) {
    const priceText = card.querySelector('.product-price')?.textContent || '0';
    return parseInt(priceText.replace(/[^0-9]/g, ''), 10) || 0;
  }

  // 1. FITUR FILTER, SEARCH & KONTROL PAGINATION (Hanya tampil jika > 8 produk)
  function updateProductView() {
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    let visibleCount = 0;

    cards.forEach(card => {
      const category = card.getAttribute('data-category');
      const title = card.querySelector('.product-title')?.textContent.toLowerCase() || '';
      const subtitle = card.querySelector('.product-subtitle')?.textContent.toLowerCase() || '';

      const matchCategory = (currentCategory === 'all' || category === currentCategory);
      const matchSearch = (title.includes(query) || subtitle.includes(query));

      if (matchCategory && matchSearch) {
        card.style.display = 'block';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    // Kontrol Pagination: Sembunyikan jika <= 8, munculkan jika > 8
    if (paginationWrapper) {
      if (visibleCount <= 8) {
        paginationWrapper.style.display = 'none';
      } else {
        paginationWrapper.style.display = 'flex';
      }
    }
  }

  // Event Listener Klik Kategori
  pills.forEach(pill => {
    pill.addEventListener('click', function () {
      pills.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      currentCategory = this.getAttribute('data-category');
      updateProductView();
    });
  });

  // Event Listener Live Search Input
  if (searchInput) {
    searchInput.addEventListener('input', updateProductView);
  }

  // 2. FITUR SORTING (URUTKAN HARGA & NAMA)
  if (sortSelect && katalogGrid) {
    sortSelect.addEventListener('change', function () {
      const value = this.value;

      cards.sort((a, b) => {
        const priceA = getProductPrice(a);
        const priceB = getProductPrice(b);

        if (value === 'lowest') {
          return priceA - priceB; // Terendah ke Tertinggi
        } else if (value === 'highest') {
          return priceB - priceA; // Tertinggi ke Terendah
        } else if (value === 'newest') {
          return 0.5 - Math.random(); // Acak/Simulasi Terbaru
        }
        return 0; // Default (Unggulan)
      });

      // Render ulang urutan elemen di DOM
      cards.forEach(card => katalogGrid.appendChild(card));
    });
  }

  // 3. FITUR LIKE / WISHLIST
  document.addEventListener('click', function (e) {
    const btnWishlist = e.target.closest('.btn-wishlist');
    if (btnWishlist) {
      const icon = btnWishlist.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-regular');
        icon.classList.toggle('fa-solid');
        icon.style.color = icon.classList.contains('fa-solid') ? '#e11d48' : '';
      }
    }
  });

  // 4. FITUR KLIK PAGINATION
  if (paginationWrapper) {
    const pageBtns = paginationWrapper.querySelectorAll('.page-btn');
    pageBtns.forEach(btn => {
      btn.addEventListener('click', function () {
        if (this.disabled || this.classList.contains('page-arrow')) return;

        pageBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        document.querySelector('.katalog-main-section')?.scrollIntoView({ behavior: 'smooth' });
      });
    });
  }

  // Jalankan pengecekan pertama saat halaman dimuat
  updateProductView();
});