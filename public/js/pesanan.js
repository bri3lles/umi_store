document.addEventListener('DOMContentLoaded', function () {

    initOrderFilter();
    initOrderSearch();
    initOrderSort();
    initReviewMediaUpload();
    initReturnMediaUpload();
    initModalOutsideClick();

});


/* =========================================================
   DATA PESANAN
========================================================= */

const orderData = {

    'ORD-98305': {
        product: 'Silk Satin Floral Tunic Navy',
        price: 389000,
        date: '24 Okt 2024, 09:15 WIB'
    },

    'ORD-97812': {
        product: 'Premium Pleated Hijab Pashmina Dusty Pink',
        price: 198000,
        date: '23 Okt 2024, 14:20 WIB'
    },

    'ORD-96420': {
        product: 'Linen Oversized Blazer Khaki',
        price: 549000,
        date: '22 Okt 2024, 11:05 WIB'
    },

    'ORD-95110': {
        product: 'Gamis Rayon Viscose Bohemian Olive',
        price: 420000,
        date: '18 Okt 2024, 16:40 WIB'
    },

    'ORD-94200': {
        product: 'Basic Knit Cardigan Ivory',
        price: 275000,
        date: '10 Okt 2024, 13:10 WIB'
    },

    'ORD-93041': {
        product: 'Midi Dress Katun Embroidery Terracotta',
        price: 315000,
        date: '05 Okt 2024, 10:00 WIB'
    }

};


/* =========================================================
   MODAL DASAR
========================================================= */

const modalIds = [
    'orderDetailModal',
    'cancelModal',
    'paymentModal',
    'reviewModal',
    'viewReviewModal',
    'returnModal',
    'returnDetailModal'
];


function closeAllModals() {

    modalIds.forEach(function (id) {

        const modal = document.getElementById(id);

        if (modal) {
            modal.classList.remove('show');
        }

    });

    document.body.classList.remove('modal-open');

}


function openModal(id) {

    closeAllModals();

    const modal = document.getElementById(id);

    if (!modal) return;

    modal.classList.add('show');

    document.body.classList.add('modal-open');

}


/* =========================================================
   DETAIL PESANAN
========================================================= */

function openOrderDetailModal(orderId) {

    const order = orderData[orderId];

    if (!order) return;

    const title = document.getElementById('detailModalTitle');
    const subtitle = document.getElementById('detailModalSubtitle');
    const product = document.getElementById('detailProductName');
    const price = document.getElementById('detailProductPrice');
    const subtotal = document.getElementById('detailSubtotal');
    const total = document.getElementById('detailTotal');

    if (title) {
        title.textContent = 'Detail Pesanan #' + orderId;
    }

    if (subtitle) {
        subtitle.textContent =
            'Waktu transaksi: ' + order.date;
    }

    if (product) {
        product.textContent = order.product;
    }

    if (price) {
        price.textContent = formatRupiah(order.price);
    }

    if (subtotal) {
        subtotal.textContent = formatRupiah(order.price);
    }

    if (total) {
        total.textContent = formatRupiah(order.price);
    }

    openModal('orderDetailModal');

}


/* =========================================================
   BATALKAN PESANAN
========================================================= */

let selectedCancelOrder = null;


function openCancelModal(orderId) {

    selectedCancelOrder = orderId;

    const target =
        document.getElementById('cancelOrderTarget');

    if (target) {
        target.textContent = '#' + orderId;
    }

    openModal('cancelModal');

}


function submitCancelModal() {

    if (!selectedCancelOrder) return;

    const reason =
        document.querySelector(
            'input[name="cancel_reason"]:checked'
        );

    const reasonText =
        reason ? reason.value : 'lainnya';

    alert(
        'Pembatalan pesanan #' +
        selectedCancelOrder +
        ' berhasil diajukan.\nAlasan: ' +
        reasonText
    );

    closeAllModals();

}


/* =========================================================
   PEMBAYARAN
========================================================= */

let selectedPaymentOrder = null;


function openPaymentModal(orderId) {

    selectedPaymentOrder = orderId;

    const order = orderData[orderId];

    if (!order) return;

    const target =
        document.getElementById('paymentOrderTarget');

    const total =
        document.getElementById('paymentTotal');

    if (target) {
        target.textContent = '#' + orderId;
    }

    if (total) {
        total.textContent =
            formatRupiah(order.price);
    }

    openModal('paymentModal');

}


function submitPaymentModal() {

    if (!selectedPaymentOrder) return;

    alert(
        'Kamu akan diarahkan ke proses pembayaran untuk pesanan #' +
        selectedPaymentOrder + '.'
    );

    closeAllModals();

}


/* =========================================================
   REVIEW
========================================================= */

let selectedReviewOrder = null;
let selectedRating = 5;


function openReviewModal(orderId) {

    selectedReviewOrder = orderId;

    setStarRating(5);

    const reviewText =
        document.getElementById('reviewText');

    const mediaInput =
        document.getElementById('reviewMedia');

    const preview =
        document.getElementById('reviewMediaPreview');

    if (reviewText) {
        reviewText.value = '';
    }

    if (mediaInput) {
        mediaInput.value = '';
    }

    if (preview) {
        preview.innerHTML = '';
    }

    openModal('reviewModal');

}


function setStarRating(rating) {

    selectedRating = rating;

    const stars =
        document.querySelectorAll(
            '#ratingStarContainer button'
        );

    stars.forEach(function (star) {

        const value =
            Number(star.dataset.rating);

        if (value <= rating) {
            star.style.opacity = '1';
        } else {
            star.style.opacity = '.25';
        }

    });


    const labels = [
        '1 Bintang · Sangat Kurang',
        '2 Bintang · Kurang Memuaskan',
        '3 Bintang · Cukup Baik',
        '4 Bintang · Memuaskan',
        '5 Bintang · Sangat Memuaskan'
    ];

    const text =
        document.getElementById('starRatingText');

    if (text) {
        text.textContent =
            labels[rating - 1];
    }

}


/* =========================================================
   UPLOAD FOTO / VIDEO ULASAN
========================================================= */

function initReviewMediaUpload() {

    const input =
        document.getElementById('reviewMedia');

    if (!input) return;

    input.addEventListener('change', function () {

        renderReviewMedia(this.files);

    });

}


function renderReviewMedia(files) {

    const preview =
        document.getElementById('reviewMediaPreview');

    if (!preview) return;

    preview.innerHTML = '';

    let imageCount = 0;
    let videoCount = 0;

    Array.from(files).forEach(function (file) {

        const isImage =
            file.type.startsWith('image/');

        const isVideo =
            file.type.startsWith('video/');

        if (isImage && imageCount >= 5) {
            return;
        }

        if (isVideo && videoCount >= 1) {
            return;
        }

        if (!isImage && !isVideo) {
            return;
        }


        if (isImage) imageCount++;
        if (isVideo) videoCount++;


        const item =
            document.createElement('div');

        item.className =
            'media-preview-item';


        const removeButton =
            document.createElement('button');

        removeButton.type = 'button';
        removeButton.className = 'media-remove';
        removeButton.textContent = '×';


        if (isImage) {

            const img =
                document.createElement('img');

            img.src =
                URL.createObjectURL(file);

            img.alt =
                'Preview foto';

            item.appendChild(img);

        }


        if (isVideo) {

            const video =
                document.createElement('video');

            video.src =
                URL.createObjectURL(file);

            video.controls = true;

            item.appendChild(video);

        }


        removeButton.addEventListener(
            'click',
            function () {
                item.remove();
            }
        );


        item.appendChild(removeButton);

        preview.appendChild(item);

    });

}


/* =========================================================
   KIRIM ULASAN
========================================================= */

function submitReviewModal() {

    const text =
        document.getElementById('reviewText');

    if (!selectedRating) {
        alert('Silakan pilih rating terlebih dahulu.');
        return;
    }

    if (!text || !text.value.trim()) {

        alert(
            'Silakan tulis ulasan terlebih dahulu.'
        );

        return;
    }


    alert(
        'Ulasan berhasil dikirim!\n' +
        'Rating: ' +
        selectedRating +
        ' bintang.'
    );

    closeAllModals();

}


/* =========================================================
   LIHAT ULASAN
========================================================= */

function openViewReviewModal(orderId) {

    openModal('viewReviewModal');

}


/* =========================================================
   PENGEMBALIAN
========================================================= */

let selectedReturnOrder = null;


function openReturnModal(orderId) {

    selectedReturnOrder = orderId;

    openModal('returnModal');

}


/* =========================================================
   DETAIL RETUR
========================================================= */

function openReturnDetailModal(orderId) {

    const subtitle =
        document.getElementById('returnDetailSubtitle');

    if (subtitle) {
        subtitle.textContent =
            '#' + orderId + ' · Pengembalian';
    }

    openModal('returnDetailModal');
}


function initReturnMediaUpload() {

    const input =
        document.getElementById('returnMedia');

    if (!input) return;

    input.addEventListener('change', function () {

        const preview =
            document.getElementById(
                'returnMediaPreview'
            );

        if (!preview) return;

        preview.innerHTML = '';

        const file = this.files[0];

        if (!file) return;

        const item =
            document.createElement('div');

        item.className =
            'media-preview-item';


        const img =
            document.createElement('img');

        img.src =
            URL.createObjectURL(file);

        img.alt =
            'Bukti pengembalian';

        item.appendChild(img);

        preview.appendChild(item);

    });

}


function submitReturnModal() {

    alert(
        'Pengajuan pengembalian berhasil dikirim.\n' +
        'Tim Umi Store akan memeriksa pengajuan kamu.'
    );

    closeAllModals();

}


// ===============================
// FILTER STATUS PESANAN
// ===============================
const filterPills = document.querySelectorAll('.filter-pill');
const orderCards = document.querySelectorAll('.order-card');
const emptyOrders = document.getElementById('emptyOrders');
const searchInput = document.getElementById('orderSearch');
const sortSelect = document.getElementById('orderSort');

let activeFilter = 'all';
let searchKeyword = '';

filterPills.forEach(pill => {
    pill.addEventListener('click', function () {

        // Hapus status aktif dari semua tombol
        filterPills.forEach(item => {
            item.classList.remove('active');
        });

        // Aktifkan tombol yang dipilih
        this.classList.add('active');

        // Ambil filter
        activeFilter = this.dataset.filter || 'all';

        // Jalankan filter
        applyOrderFilter();
    });
});


// ===============================
// SEARCH PESANAN
// ===============================
if (searchInput) {
    searchInput.addEventListener('input', function () {
        searchKeyword = this.value.toLowerCase().trim();
        applyOrderFilter();
    });
}


// ===============================
// FUNGSI FILTER UTAMA
// ===============================
function applyOrderFilter() {
    let visibleCount = 0;

    orderCards.forEach(card => {

        // Ambil status dari data-status
        const cardStatus = (card.dataset.status || '').toLowerCase();

        // Ambil teks card untuk pencarian
        const cardText = card.textContent.toLowerCase();

        // Cek status
        const statusMatch =
            activeFilter === 'all' ||
            cardStatus === activeFilter;

        // Cek pencarian
        const searchMatch =
            searchKeyword === '' ||
            cardText.includes(searchKeyword);

        // Tampilkan / sembunyikan
        if (statusMatch && searchMatch) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Empty state
    if (emptyOrders) {
        emptyOrders.style.display =
            visibleCount === 0 ? 'flex' : 'none';
    }
}


// Jalankan pertama kali
applyOrderFilter();


/* =========================================================
   SEARCH
========================================================= */

function initOrderSearch() {

    const input =
        document.getElementById('orderSearch');

    if (!input) return;

    input.addEventListener(
        'input',
        filterOrders
    );

}


/* =========================================================
   SORT
========================================================= */

function initOrderSort() {

    const select =
        document.getElementById('orderSort');

    const grid =
        document.getElementById('ordersGrid');

    if (!select || !grid) return;


    select.addEventListener(
        'change',
        function () {

            const cards =
                Array.from(
                    grid.querySelectorAll('.order-card')
                );


            cards.sort(function (a, b) {

                const dateA =
                    new Date(a.dataset.date);

                const dateB =
                    new Date(b.dataset.date);

                const totalA =
                    Number(a.dataset.total);

                const totalB =
                    Number(b.dataset.total);


                switch (select.value) {

                    case 'oldest':
                        return dateA - dateB;

                    case 'highest':
                        return totalB - totalA;

                    case 'lowest':
                        return totalA - totalB;

                    case 'newest':
                    default:
                        return dateB - dateA;

                }

            });


            cards.forEach(function (card) {

                grid.appendChild(card);

            });


            filterOrders();

        }
    );

}


/* =========================================================
   KLIK AREA LUAR MODAL
========================================================= */

function initModalOutsideClick() {

    document.querySelectorAll(
        '.profile-modal-overlay'
    ).forEach(function (overlay) {

        overlay.addEventListener(
            'click',
            function (event) {

                if (event.target === overlay) {
                    closeAllModals();
                }

            }
        );

    });

}


/* =========================================================
   ESC
========================================================= */

document.addEventListener(
    'keydown',
    function (event) {

        if (event.key === 'Escape') {
            closeAllModals();
        }

    }
);


/* =========================================================
   RUPIAH
========================================================= */

function formatRupiah(number) {

    return 'Rp ' +
        Number(number).toLocaleString(
            'id-ID'
        );

}