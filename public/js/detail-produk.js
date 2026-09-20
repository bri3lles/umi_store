// KLIK TOMBOL WARNA DI KANAN -> UBAH GAMBAR BESAR & THUMBNAIL KIRI
function selectColor(element) {
    const colorId = element.getAttribute('data-color-id');
    const colorName = element.getAttribute('data-color-name');

    // 1. Ubah teks nama warna
    document.getElementById('colorName').textContent = colorName;

    // 2. Set status aktif tombol warna
    document.querySelectorAll('.chip-btn[data-color-id]').forEach(btn => {
        btn.classList.remove('active');
    });
    element.classList.add('active');

    // 3. Cari thumbnail kiri yang punya data-color-id sama
    const targetThumb = document.querySelector(`.thumb-card[data-color-id="${colorId}"]`);

    if (targetThumb) {
        // Ganti gambar utama dengan sumber gambar dari thumbnail yang cocok
        document.getElementById('mainImage').src = targetThumb.src;

        // Set status aktif pada thumbnail kiri
        document.querySelectorAll('.thumb-card').forEach(thumb => {
            thumb.classList.remove('active');
        });
        targetThumb.classList.add('active');
    }
}

// KLIK THUMBNAIL KECIL DI KIRI -> UBAH GAMBAR BESAR & TOMBOL WARNA KANAN
function switchImage(element) {
    const colorId = element.getAttribute('data-color-id');
    const colorName = element.getAttribute('data-color-name');

    // 1. Ubah Gambar Utama
    document.getElementById('mainImage').src = element.src;

    // 2. Set status aktif thumbnail yang diklik
    document.querySelectorAll('.thumb-card').forEach(thumb => {
        thumb.classList.remove('active');
    });
    element.classList.add('active');

    // 3. Cari tombol warna kanan yang cocok lalu aktifkan
    if (colorId) {
        const targetBtn = document.querySelector(`.chip-btn[data-color-id="${colorId}"]`);
        if (targetBtn) {
            document.querySelectorAll('.chip-btn[data-color-id]').forEach(btn => {
                btn.classList.remove('active');
            });
            targetBtn.classList.add('active');
            document.getElementById('colorName').textContent = colorName;
        }
    }
}

function selectSize(element) {
    document.querySelectorAll('.variant-box:nth-child(2) .chip-btn').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
    document.getElementById('sizeName').textContent = element.textContent.trim();
}

// Quantity Counter
function adjustQty(amount) {
    const input = document.getElementById('quantity');
    let current = parseInt(input.value) || 1;
    if (current + amount >= 1) {
        input.value = current + amount;
    }
}

// Buka/Tutup Size Chart Modal
function toggleModal(show) {
    const modal = document.getElementById('sizeModal');
    if (show) modal.classList.add('is-open');
    else modal.classList.remove('is-open');
}

// Expand Semua Ulasan
function expandReviews() {
    document.querySelectorAll('.extra-review').forEach(card => card.classList.remove('is-hidden'));
    document.getElementById('btnExpandReviews').style.display = 'none';
}

function toggleReadMore() {
    const wrapper = document.getElementById('descWrapper');
    const btn = document.getElementById('btnReadMore');
    const isExpanded = wrapper.classList.contains('expanded');

    if (isExpanded) {
        wrapper.classList.remove('expanded');
        btn.classList.remove('active');
        btn.innerHTML = 'Baca Selengkapnya <i class="fa-solid fa-chevron-down"></i>';
    } else {
        wrapper.classList.add('expanded');
        btn.classList.add('active');
        btn.innerHTML = 'Sembunyikan <i class="fa-solid fa-chevron-down"></i>';
    }
}

function toggleReviews() {
    const btn = document.getElementById('btnToggleReviews');
    const hiddenReviews = document.querySelectorAll('.review-post.is-hidden');
    const label = btn.querySelector('span');

    if (!btn) return;

    // Toggle class active untuk putar panah CSS
    btn.classList.toggle('active');
    const isExpanded = btn.classList.contains('active');

    // Tampilkan / Sembunyikan ulasan ekstra
    hiddenReviews.forEach(review => {
        if (isExpanded) {
            review.style.display = 'flex';
        } else {
            review.style.display = 'none';
        }
    });

    // Ubah teks tombol
    if (label) {
        label.textContent = isExpanded ? 'Sembunyikan Ulasan' : 'Lihat Semua Ulasan';
    }
}

function selectSize(selectedBtn) {
    // 1. Abaikan jika tombol dalam keadaan disabled (stok habis)
    if (selectedBtn.classList.contains('disabled') || selectedBtn.disabled) {
        return;
    }

    // 2. Ambil semua tombol ukuran di dalam grup
    const sizeButtons = document.querySelectorAll('.size-chip-group .chip-btn');

    // 3. Hapus class 'active' dari SEMUA tombol ukuran
    sizeButtons.forEach(btn => {
        btn.classList.remove('active');
    });

    // 4. Tambahkan class 'active' HANYA ke tombol yang diklik
    selectedBtn.classList.add('active');

    // 5. Update teks label "Ukuran: S" sesuai ukuran yang dipilih
    const selectedSize = selectedBtn.getAttribute('data-size') || selectedBtn.innerText;
    const sizeLabel = document.getElementById('selectedSizeLabel');
    if (sizeLabel) {
        sizeLabel.textContent = selectedSize;
    }
}

function selectColor(selectedBtn) {
    if (selectedBtn.classList.contains('disabled') || selectedBtn.disabled) return;

    // Ambil semua tombol warna
    const colorButtons = document.querySelectorAll('.color-chip-group .chip-btn');
    
    // Nonaktifkan semua, aktifkan yang diklik
    colorButtons.forEach(btn => btn.classList.remove('active'));
    selectedBtn.classList.add('active');

    // Update label warna
    const selectedColor = selectedBtn.getAttribute('data-color') || selectedBtn.innerText.trim();
    const colorLabel = document.getElementById('selectedColorLabel');
    if (colorLabel) {
        colorLabel.textContent = selectedColor;
    }
}

// Tambahkan fungsi ini di bagian script JS Anda
function openSizeModal() {
    toggleModal(true);
}