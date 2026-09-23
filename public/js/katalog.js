document.addEventListener('DOMContentLoaded', function () {
    const grid = document.getElementById('katalogGrid');
    if (!grid) return;

    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const pagination = document.querySelector('.pagination-wrapper');
    const pills = document.querySelectorAll('.pill-btn');
    const wishlistKey = 'umiWishlist';
    const pageSize = 8;
    let category = 'all';
    let page = 1;
    let cards = Array.from(grid.querySelectorAll('.product-card'));

    const money = value => 'Rp ' + Number(value || 0).toLocaleString('id-ID');

    function getPrice(card) {
        return Number((card.querySelector('.product-price')?.textContent || '').replace(/[^0-9]/g, '')) || 0;
    }

    function getProduct(card) {
        return {
            id: card.dataset.productId || slug(card.querySelector('.product-title')?.textContent || 'produk'),
            name: card.querySelector('.product-title')?.textContent.trim() || 'Produk Umi Store',
            price: getPrice(card),
            image: card.querySelector('.product-image')?.src || '',
            category: card.dataset.category || 'all'
        };
    }

    function slug(value) {
        return value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    }

    function readWishlist() {
        try { return JSON.parse(localStorage.getItem(wishlistKey) || '[]'); } catch { return []; }
    }

    function writeWishlist(list) { localStorage.setItem(wishlistKey, JSON.stringify(list)); }

    function toast(message) {
        let el = document.getElementById('umiCatalogToast');
        if (!el) {
            el = document.createElement('div');
            el.id = 'umiCatalogToast';
            el.style.cssText = 'position:fixed;right:24px;bottom:24px;z-index:9999;background:#002D72;color:#fff;padding:12px 16px;border-radius:10px;font:600 14px Inter,sans-serif;box-shadow:0 10px 25px rgba(0,0,0,.15)';
            document.body.appendChild(el);
        }
        el.textContent = message;
        clearTimeout(window.__catalogToast);
        window.__catalogToast = setTimeout(() => el.remove(), 2200);
    }

    function syncWishlistButtons() {
        const ids = new Set(readWishlist().map(item => item.id));
        cards.forEach(card => {
            const btn = card.querySelector('.btn-wishlist');
            const icon = btn?.querySelector('i');
            if (!btn || !icon) return;
            const active = ids.has(getProduct(card).id);
            btn.classList.toggle('active', active);
            icon.classList.toggle('fa-solid', active);
            icon.classList.toggle('fa-regular', !active);
            btn.setAttribute('aria-label', active ? 'Hapus dari Wishlist' : 'Tambah Wishlist');
        });
    }

    function filtered() {
        const query = (searchInput?.value || '').toLowerCase().trim();
        return cards.filter(card => {
            const title = card.querySelector('.product-title')?.textContent.toLowerCase() || '';
            const subtitle = card.querySelector('.product-subtitle')?.textContent.toLowerCase() || '';
            return (category === 'all' || card.dataset.category === category) && (title.includes(query) || subtitle.includes(query));
        });
    }

    function sortCards() {
        const value = sortSelect?.value || 'featured';
        cards.sort((a, b) => {
            if (value === 'lowest') return getPrice(a) - getPrice(b);
            if (value === 'highest') return getPrice(b) - getPrice(a);
            return Number(a.dataset.newest || cards.indexOf(a)) - Number(b.dataset.newest || cards.indexOf(b));
        });
        cards.forEach(card => grid.appendChild(card));
    }

    function render() {
        const list = filtered();
        const totalPages = Math.max(1, Math.ceil(list.length / pageSize));
        page = Math.min(page, totalPages);
        const start = (page - 1) * pageSize;

        cards.forEach(card => card.style.display = 'none');
        list.slice(start, start + pageSize).forEach(card => card.style.display = 'block');

        if (pagination) {
            pagination.style.display = list.length > pageSize ? 'flex' : 'none';
            pagination.querySelectorAll('.page-btn').forEach(btn => {
                const number = Number(btn.textContent.trim());
                if (!Number.isNaN(number)) {
                    btn.classList.toggle('active', number === page);
                    btn.disabled = number > totalPages;
                }
            });
        }

        let empty = document.getElementById('katalogEmptyState');
        if (!empty) {
            empty = document.createElement('div');
            empty.id = 'katalogEmptyState';
            empty.style.cssText = 'grid-column:1/-1;text-align:center;padding:60px 20px;color:#64748b';
            empty.innerHTML = '<i class="fa-solid fa-box-open" style="font-size:34px;margin-bottom:12px"></i><h3 style="margin-bottom:6px;color:#002D72">Produk tidak ditemukan</h3><p>Coba ubah kata kunci atau kategori pencarian.</p>';
            grid.appendChild(empty);
        }
        empty.style.display = list.length ? 'none' : 'block';
        syncWishlistButtons();
    }

    pills.forEach(pill => pill.addEventListener('click', () => {
        pills.forEach(item => item.classList.remove('active'));
        pill.classList.add('active');
        category = pill.dataset.category || 'all';
        page = 1;
        render();
    }));

    searchInput?.addEventListener('input', () => { page = 1; render(); });
    sortSelect?.addEventListener('change', () => { sortCards(); page = 1; render(); });

    grid.addEventListener('click', event => {
        const btn = event.target.closest('.btn-wishlist');
        if (!btn) return;
        const card = btn.closest('.product-card');
        const product = getProduct(card);
        let list = readWishlist();
        const exists = list.some(item => item.id === product.id);
        list = exists ? list.filter(item => item.id !== product.id) : [...list, product];
        writeWishlist(list);
        syncWishlistButtons();
        toast(exists ? 'Produk dihapus dari wishlist.' : 'Produk ditambahkan ke wishlist.');
    });

    pagination?.addEventListener('click', event => {
        const btn = event.target.closest('.page-btn');
        if (!btn || btn.disabled) return;
        if (btn.classList.contains('page-arrow')) {
            page += btn.textContent.includes('›') ? 1 : -1;
        } else {
            const number = Number(btn.textContent.trim());
            if (number) page = number;
        }
        page = Math.max(1, page);
        render();
        document.querySelector('.katalog-main-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    cards.forEach((card, index) => { if (!card.dataset.newest) card.dataset.newest = index; });
    sortCards();
    render();
});
