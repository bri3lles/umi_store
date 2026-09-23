(function () {
    'use strict';

    const CART_KEY = 'umiCart';
    const ADDRESS_KEY = 'umiAddress';
    const ORDER_KEY = 'umiOrders';
    const CHECKOUT_KEY = 'umiCheckout';

    const fallbackAddress = {
        name: 'Dimas Satria',
        phone: '+62 812-3456-7890',
        address: 'Jl. Dharmahusada Indah Timur No. 42, Mulyorejo, Kota Surabaya, Jawa Timur 60115',
        note: 'Titipkan di pos satpam bila rumah kosong'
    };

    let cart = [];
    let address = loadAddress();
    let shippingType = 'delivery';
    let shippingCost = 18000;

    const money = value => 'Rp ' + Number(value || 0).toLocaleString('id-ID');

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>'"]/g, char => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
        }[char]));
    }

    function loadAddress() {
        try {
            const saved = JSON.parse(localStorage.getItem(ADDRESS_KEY));
            return saved && saved.name && saved.address ? saved : fallbackAddress;
        } catch {
            return fallbackAddress;
        }
    }

    function saveAddress() {
        localStorage.setItem(ADDRESS_KEY, JSON.stringify(address));
    }

    function loadCart() {
        try {
            const saved = JSON.parse(localStorage.getItem(CART_KEY));
            return Array.isArray(saved) ? saved : [];
        } catch {
            return [];
        }
    }

    function normalizeCart(items) {
        return items.map(item => ({
            id: item.id || item.productId || 'product-' + Math.random().toString(36).slice(2),
            name: item.name || item.product_name || 'Produk Umi Store',
            price: Number(item.price || item.harga || 0),
            qty: Math.max(1, Number(item.qty || item.quantity || 1)),
            size: item.size || item.ukuran || '-',
            color: item.color || item.warna || '-',
            image: item.image || item.img || item.image_url || '',
            stock: Number(item.stock || 999)
        }));
    }

    function getCart() {
        cart = normalizeCart(loadCart());
        return cart;
    }

    function subtotal() {
        return getCart().reduce((sum, item) => sum + item.price * item.qty, 0);
    }

    function renderAddress() {
        const recipient = document.getElementById('displayRecipient');
        const addressText = document.getElementById('displayAddressText');
        const noteBox = document.getElementById('displayNoteBox');
        const noteText = document.getElementById('displayNoteText');

        if (recipient) recipient.textContent = `${address.name} (${address.phone})`;
        if (addressText) addressText.textContent = address.address;
        if (noteBox) noteBox.style.display = address.note ? 'flex' : 'none';
        if (noteText) noteText.textContent = address.note ? `Catatan Pengiriman: "${address.note}"` : '';
    }

    function renderItems() {
        const container = document.getElementById('summaryItemsContainer');
        const empty = document.getElementById('summaryEmptyState');
        const badge = document.getElementById('summaryItemCountBadge');
        if (!container) return;

        const items = getCart();
        const count = items.reduce((sum, item) => sum + item.qty, 0);

        if (badge) badge.textContent = `${count} Produk`;
        if (empty) empty.style.display = items.length ? 'none' : 'block';

        container.querySelectorAll('.summary-item-card').forEach(el => el.remove());

        items.forEach(item => {
            const card = document.createElement('div');
            card.className = 'summary-item-card';
            card.innerHTML = `
                <img src="${escapeHtml(item.image || '/images/placeholder-product.png')}" alt="${escapeHtml(item.name)}" class="summary-item-img" onerror="this.style.visibility='hidden'">
                <div class="summary-item-details" style="flex:1;">
                    <h4>${escapeHtml(item.name)}</h4>
                    <p>${escapeHtml(item.color)} • Size ${escapeHtml(item.size)} • ${item.qty}x</p>
                    <div class="summary-item-price">${money(item.price * item.qty)}</div>
                </div>
            `;
            container.insertBefore(card, empty || null);
        });
    }

    function renderTotals() {
        const sub = subtotal();
        const discount = 0;
        const total = Math.max(0, sub - discount + shippingCost);

        const subtotalEl = document.getElementById('subtotalDisplay');
        const discountRow = document.getElementById('discountRow');
        const discountEl = document.getElementById('discountDisplay');
        const shippingEl = document.getElementById('shippingFeeDisplay');
        const grandEl = document.getElementById('grandTotalDisplay');

        if (subtotalEl) subtotalEl.textContent = money(sub);
        if (discountRow) discountRow.style.display = discount ? 'flex' : 'none';
        if (discountEl) discountEl.textContent = '-' + money(discount);
        if (shippingEl) shippingEl.textContent = shippingCost ? money(shippingCost) : 'GRATIS';
        if (grandEl) grandEl.textContent = money(total);

        return { subtotal: sub, discount, shipping: shippingCost, total };
    }

    window.selectShipping = function (card, cost, type) {
        document.querySelectorAll('.shipping-option-card').forEach(item => {
            item.classList.remove('selected');
            const radio = item.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });

        card.classList.add('selected');
        const radio = card.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;

        shippingType = type || card.dataset.shippingType || 'delivery';
        shippingCost = Number(cost || 0);

        const pickupInfo = document.getElementById('storePickupInfo');
        if (pickupInfo) pickupInfo.style.display = shippingType === 'pickup' ? 'block' : 'none';

        renderTotals();
    };

    function openAddressModal() {
        const modal = document.getElementById('modalUbahAlamat');
        if (!modal) return;
        document.getElementById('editName').value = address.name;
        document.getElementById('editPhone').value = address.phone;
        document.getElementById('editStreet').value = address.address;
        document.getElementById('editNote').value = address.note || '';
        modal.style.display = 'flex';
    }

    function closeAddressModal() {
        const modal = document.getElementById('modalUbahAlamat');
        if (modal) modal.style.display = 'none';
    }

    function saveEditedAddress() {
        const name = document.getElementById('editName')?.value.trim();
        const phone = document.getElementById('editPhone')?.value.trim();
        const street = document.getElementById('editStreet')?.value.trim();
        const note = document.getElementById('editNote')?.value.trim() || '';

        if (!name || !phone || !street) {
            showToast('Nama, nomor handphone, dan alamat wajib diisi.', 'error');
            return;
        }

        address = { name, phone, address: street, note };
        saveAddress();
        renderAddress();
        closeAddressModal();
        showToast('Alamat pengiriman diperbarui.');
    }

    function showToast(message, type = 'success') {
        let toast = document.getElementById('umiCheckoutToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'umiCheckoutToast';
            toast.style.cssText = 'position:fixed;right:24px;bottom:24px;z-index:9999;padding:13px 17px;border-radius:10px;background:#002D72;color:#fff;font:600 14px Inter,sans-serif;box-shadow:0 10px 30px rgba(0,0,0,.15);transition:.2s;';
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.style.background = type === 'error' ? '#b42318' : '#002D72';
        clearTimeout(window.__umiToastTimer);
        window.__umiToastTimer = setTimeout(() => toast.remove(), 2800);
    }

    function saveCheckoutSnapshot() {
        const totals = renderTotals();
        const snapshot = {
            items: getCart(),
            address,
            shippingType,
            shippingCost,
            totals,
            pickupTime: document.getElementById('pickupTime')?.value || null,
            createdAt: new Date().toISOString()
        };
        localStorage.setItem(CHECKOUT_KEY, JSON.stringify(snapshot));
        return snapshot;
    }

    async function startPayment() {
        if (!getCart().length) {
            showToast('Keranjang masih kosong.', 'error');
            return;
        }

        if (shippingType === 'delivery' && (!address.name || !address.phone || !address.address)) {
            showToast('Lengkapi alamat pengiriman terlebih dahulu.', 'error');
            return;
        }

        const snapshot = saveCheckoutSnapshot();
        const button = document.getElementById('btnLanjutBayar');
        if (button) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyiapkan pembayaran...';
        }

        try {
            const response = await fetch(window.umiCheckoutConfig.routes.paymentToken, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.umiCheckoutConfig.csrfToken
                },
                body: JSON.stringify({
                    gross_amount: snapshot.totals.total,
                    items: snapshot.items,
                    shipping_type: snapshot.shippingType
                })
            });

            const data = await response.json();
            if (!response.ok || !data.snap_token) {
                throw new Error(data.message || 'Token pembayaran tidak tersedia.');
            }

            if (!window.snap) throw new Error('Midtrans Snap belum termuat.');

            window.snap.pay(data.snap_token, {
                onSuccess: function (result) {
                    finalizeOrder('success', result);
                },
                onPending: function (result) {
                    finalizeOrder('pending', result);
                },
                onError: function (result) {
                    showToast('Pembayaran gagal. Silakan coba lagi.', 'error');
                },
                onClose: function () {
                    showToast('Pembayaran belum diselesaikan.');
                }
            });
        } catch (error) {
            console.error(error);
            showToast(error.message || 'Gagal menyiapkan pembayaran.', 'error');
        } finally {
            if (button) {
                button.disabled = false;
                button.innerHTML = button.dataset.originalText || 'Lanjutkan ke Pembayaran';
            }
        }
    }

    function finalizeOrder(status, paymentResult) {
        const snapshot = JSON.parse(localStorage.getItem(CHECKOUT_KEY) || '{}');
        const orderId = paymentResult?.order_id || ('UMI-' + Date.now());
        const orders = JSON.parse(localStorage.getItem(ORDER_KEY) || '[]');

        orders.unshift({
            id: orderId,
            status: status === 'success' ? 'Dibayar' : 'Menunggu Pembayaran',
            paymentStatus: status,
            createdAt: new Date().toISOString(),
            receivedAt: null,
            items: snapshot.items || [],
            address: snapshot.address || address,
            shippingType: snapshot.shippingType || shippingType,
            shippingCost: snapshot.shippingCost || shippingCost,
            subtotal: snapshot.totals?.subtotal || 0,
            total: snapshot.totals?.total || 0,
            returnStatus: null
        });

        localStorage.setItem(ORDER_KEY, JSON.stringify(orders));

        if (status === 'success') {
            localStorage.removeItem(CART_KEY);
            localStorage.removeItem(CHECKOUT_KEY);
            window.location.href = window.umiCheckoutConfig.routes.profile + '#pesanan';
        } else {
            window.location.href = window.umiCheckoutConfig.routes.profile + '#pesanan';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        getCart();
        renderAddress();
        renderItems();
        renderTotals();

        document.getElementById('btnOpenUbahAlamat')?.addEventListener('click', openAddressModal);
        document.getElementById('closeUbahModal')?.addEventListener('click', closeAddressModal);
        document.getElementById('btnSaveEditAddress')?.addEventListener('click', saveEditedAddress);
        document.getElementById('btnLanjutBayar')?.addEventListener('click', startPayment);

        document.getElementById('modalUbahAlamat')?.addEventListener('click', function (event) {
            if (event.target === this) closeAddressModal();
        });

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') closeAddressModal();
        });
    });
})();
