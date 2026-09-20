// ==========================================
// FITUR LIKE / WISHLIST
// ==========================================

document.addEventListener('click', function (e) {

    const btnWishlist = e.target.closest('.btn-wishlist');

    if (!btnWishlist) {
        return;
    }

    const icon = btnWishlist.querySelector('i');

    if (!icon) {
        return;
    }

    // Ubah icon solid <-> regular
    icon.classList.toggle('fa-solid');
    icon.classList.toggle('fa-regular');

    // Jika aktif, warna merah
    if (icon.classList.contains('fa-solid')) {

        icon.style.color = '#e11d48';

        btnWishlist.classList.add('active');

    } else {

        icon.style.color = '';

        btnWishlist.classList.remove('active');

    }

});