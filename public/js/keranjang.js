document.addEventListener('DOMContentLoaded', function () {
    const CART_KEY = 'umiCart';
    const cartCards = Array.from(document.querySelectorAll('.cart-item-card'));
    cartCards.forEach((card, index) => { if (!card.dataset.productId) card.dataset.productId = `static-${index}`; });
    const selectAll = document.getElementById('selectAll');
    const selectAllCount = document.getElementById('selectAllCount');
    const summaryBadge = document.querySelector('.summary-card .summary-item-badge');
    const subtotalEl = document.querySelector('.summary-card .price-row span:last-child');
    const totalEl = document.querySelector('.summary-card .total-price');
    const modal = document.getElementById('shippingModal');
    let emptyState = document.getElementById('cartEmptyState');
    if (!emptyState) {
        emptyState = document.createElement('div');
        emptyState.id = 'cartEmptyState';
        emptyState.style.cssText = 'display:none;text-align:center;padding:64px 20px;color:#64748b';
        emptyState.innerHTML = '<i class="fa-solid fa-bag-shopping" style="font-size:40px;color:#002D72;margin-bottom:14px"></i><h3 style="color:#002D72;margin-bottom:7px">Keranjang masih kosong</h3><p>Tambahkan produk dari katalog untuk mulai berbelanja.</p><a href="'+window.location.origin+'/katalog" style="display:inline-flex;margin-top:18px;padding:11px 18px;border-radius:10px;background:#002D72;color:#fff;text-decoration:none;font-weight:600">Lihat Katalog</a>';
        document.querySelector('.cart-items-section')?.appendChild(emptyState);
    }

    const money = value => 'Rp ' + Number(value || 0).toLocaleString('id-ID');

    function seedCart() {
        try {
            const saved = JSON.parse(localStorage.getItem(CART_KEY) || 'null');
            if (Array.isArray(saved)) return saved;
        } catch {}
        return cartCards.filter(card => !card.classList.contains('out-of-stock')).map((card, index) => ({
            id: card.dataset.productId || `static-${index}`,
            name: card.querySelector('.cart-item-title')?.textContent.trim() || 'Produk Umi Store',
            price: Number((card.querySelector('.cart-item-unit-price')?.textContent || '').replace(/[^0-9]/g, '')) || 0,
            qty: Number(card.querySelector('.qty-number')?.textContent || 1),
            size: card.querySelector('.meta-badge')?.textContent.replace(/Ukuran:\s*/i, '').trim() || '-',
            color: card.querySelector('.meta-color')?.textContent.trim() || '-',
            image: card.querySelector('img')?.src || '',
            stock: 5,
            selected: card.querySelector('.item-checkbox')?.checked !== false
        }));
    }

    let cart = seedCart();
    localStorage.setItem(CART_KEY, JSON.stringify(cart));

    function save() { localStorage.setItem(CART_KEY, JSON.stringify(cart)); }

    function render() {
        cartCards.forEach(card => {
            const id = card.dataset.productId;
            if (!id) return;
            const item = cart.find(x => x.id === id);
            if (!item) card.remove();
        });

        let checkedCount = 0;
        let subtotal = 0;
        document.querySelectorAll('.cart-item-card:not(.out-of-stock)').forEach(card => {
            const item = cart.find(x => x.id === card.dataset.productId);
            const checkbox = card.querySelector('.item-checkbox');
            const qty = card.querySelector('.qty-number');
            const total = card.querySelector('.cart-item-total-price');
            if (!item) return;
            if (checkbox) checkbox.checked = item.selected !== false;
            if (qty) qty.textContent = item.qty;
            if (total) total.textContent = money(item.price * item.qty);
            if (item.selected !== false) {
                checkedCount += item.qty;
                subtotal += item.price * item.qty;
            }
        });
        if (selectAllCount) selectAllCount.textContent = checkedCount;
        if (summaryBadge) summaryBadge.textContent = `${checkedCount} Item`;
        if (subtotalEl) subtotalEl.textContent = money(subtotal);
        if (totalEl) totalEl.textContent = money(subtotal);
        if (selectAll) selectAll.checked = cart.length > 0 && cart.every(item => item.selected !== false);
        if (emptyState) emptyState.style.display = cart.length ? 'none' : 'block';
    }

    function toast(message) {
        let el = document.getElementById('umiCartToast');
        if (!el) { el = document.createElement('div'); el.id = 'umiCartToast'; el.style.cssText = 'position:fixed;right:24px;bottom:24px;z-index:9999;background:#002D72;color:#fff;padding:12px 16px;border-radius:10px;font:600 14px Inter,sans-serif'; document.body.appendChild(el); }
        el.textContent = message; clearTimeout(window.__cartToast); window.__cartToast = setTimeout(() => el.remove(), 2200);
    }

    function openShipping() {
        const selected = cart.filter(item => item.selected !== false);
        if (!selected.length) { toast('Pilih minimal satu produk.'); return; }
        localStorage.setItem(CART_KEY, JSON.stringify(selected));
        window.location.href = window.routeDiantar;
    }

    document.addEventListener('click', function (event) {
        const card = event.target.closest('.cart-item-card:not(.out-of-stock)');
        if (!card) return;
        const item = cart.find(x => x.id === card.dataset.productId);
        const index = cart.findIndex(x => x.id === card.dataset.productId);
        if (!item) return;
        if (event.target.closest('.qty-btn')) {
            const plus = event.target.closest('.qty-btn') === card.querySelector('.qty-btn:last-child');
            if (plus && item.qty >= item.stock) { toast('Stok tidak mencukupi.'); return; }
            item.qty = Math.max(1, item.qty + (plus ? 1 : -1)); save(); render();
        }
        if (event.target.closest('.btn-delete')) {
            cart.splice(index, 1); save(); render(); toast('Produk dihapus dari keranjang.');
        }
    });

    document.addEventListener('change', function (event) {
        if (event.target.matches('.item-checkbox')) {
            const item = cart.find(x => x.id === event.target.closest('.cart-item-card')?.dataset.productId);
            if (item) item.selected = event.target.checked;
            save(); render();
        }
    });

    selectAll?.addEventListener('change', function () { cart.forEach(item => item.selected = selectAll.checked); save(); render(); });
    document.querySelector('.btn-next')?.addEventListener('click', openShipping);
    document.getElementById('btnOpenPopup')?.addEventListener('click', () => { if (modal) modal.style.display = 'flex'; });
    document.getElementById('btnCloseModal')?.addEventListener('click', () => { if (modal) modal.style.display = 'none'; });
    document.getElementById('btnSubmitShipping')?.addEventListener('click', openShipping);
    document.getElementById('btnDeleteSelected')?.addEventListener('click', () => { cart = cart.filter(item => item.selected === false); save(); render(); });
    document.querySelector('.btn-delete-selected')?.addEventListener('click', () => { cart = cart.filter(item => item.selected === false); save(); render(); });

    render();
});
