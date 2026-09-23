(function () {
    'use strict';

    const ORDER_KEY = 'umiOrders';
    const RETURN_KEY = 'umiReturns';
    const params = new URLSearchParams(window.location.search);
    const requestedOrder = params.get('order');

    const productCard = document.querySelector('.return-product');
    const subtotalEl = document.getElementById('summary-subtotal');
    const totalRefundEl = document.getElementById('summary-total-refund');
    const miniListEl = document.getElementById('selected-items-mini');
    const agreement = document.getElementById('agreement');
    const submitButton = document.getElementById('btn-submit-return');
    const description = document.getElementById('return-description');
    const descriptionCount = document.getElementById('description-count');
    const imageInput = document.getElementById('return-images');
    const uploadPreview = document.getElementById('upload-preview');
    const reason = document.getElementById('return-reason');

    const money = value => 'Rp ' + Number(value || 0).toLocaleString('id-ID');

    function showToast(message, type = 'success') {
        let toast = document.getElementById('umiReturnToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'umiReturnToast';
            toast.style.cssText = 'position:fixed;right:24px;bottom:24px;z-index:9999;padding:13px 17px;border-radius:10px;background:#002D72;color:#fff;font:600 14px Inter,sans-serif;box-shadow:0 10px 30px rgba(0,0,0,.15)';
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.style.background = type === 'error' ? '#b42318' : '#002D72';
        clearTimeout(window.__returnToast);
        window.__returnToast = setTimeout(() => toast.remove(), 3000);
    }

    function getOrders() {
        try {
            const data = JSON.parse(localStorage.getItem(ORDER_KEY) || '[]');
            return Array.isArray(data) ? data : [];
        } catch { return []; }
    }

    function getSelectedOrder() {
        const orders = getOrders();
        if (requestedOrder) {
            const exact = orders.find(order => order.id === requestedOrder);
            if (exact) return exact;
        }
        return orders.find(order => order.status === 'Selesai' || order.status === 'Diterima' || order.paymentStatus === 'success') || null;
    }

    function getFallbackProduct() {
        return {
            id: 'demo-return-product',
            name: productCard?.dataset.name || 'Gamis Rayon Viscose Bohemia Olive',
            price: Number(productCard?.dataset.price || 420000),
            qty: 1,
            size: 'XL',
            color: 'Olive Forest',
            image: productCard?.querySelector('img')?.src || ''
        };
    }

    function selectedProduct(order) {
        return order?.items?.[0] || getFallbackProduct();
    }

    function renderOrder(order) {
        const product = selectedProduct(order);
        const orderIdEl = document.querySelector('.return-order-info strong');
        const productName = document.querySelector('.return-product h3');
        const productVariant = document.querySelector('.return-product-info p');
        const productPrice = document.querySelector('.return-product-bottom strong');
        const productQty = document.querySelector('.return-product-bottom span');
        const image = document.querySelector('.return-product img');

        if (orderIdEl) orderIdEl.textContent = '#' + (order?.id || 'ORDER');
        if (productCard) {
            productCard.dataset.price = Number(product.price || 0);
            productCard.dataset.name = product.name || 'Produk Umi Store';
        }
        if (productName) productName.textContent = product.name || 'Produk Umi Store';
        if (productVariant) productVariant.textContent = `Varian: ${product.size || '-'} · Warna: ${product.color || '-'}`;
        if (productPrice) productPrice.textContent = money(Number(product.price || 0) * Number(product.qty || 1));
        if (productQty) productQty.textContent = `Jumlah: ${product.qty || 1}x`;
        if (image && product.image) image.src = product.image;

        const total = Number(product.price || 0) * Number(product.qty || 1);
        if (subtotalEl) subtotalEl.textContent = money(total);
        if (totalRefundEl) totalRefundEl.textContent = money(total);
        if (miniListEl) miniListEl.innerHTML = `<div class="summary-item"><span title="${product.name}">${product.name}</span><strong>${money(total)}</strong></div>`;
    }

    function validateDeadline(order) {
        if (!order) return true;
        const received = order.receivedAt || order.completedAt || order.createdAt;
        if (!received) return true;
        const diff = Date.now() - new Date(received).getTime();
        return diff <= 3 * 24 * 60 * 60 * 1000;
    }

    function updateSubmitButton() {
        if (!submitButton) return;
        const order = getSelectedOrder();
        const productValid = Boolean(productCard);
        const reasonValid = Boolean(reason?.value);
        const descriptionValid = Boolean(description?.value.trim());
        const photoValid = Boolean(imageInput?.files?.length);
        const agreementValid = Boolean(agreement?.checked);
        const deadlineValid = validateDeadline(order);
        const valid = productValid && reasonValid && descriptionValid && photoValid && agreementValid && deadlineValid;

        submitButton.disabled = !valid;
        submitButton.classList.toggle('enabled', valid);

        if (!deadlineValid) {
            submitButton.title = 'Batas pengajuan retur 3 hari setelah pesanan diterima telah lewat.';
        } else {
            submitButton.title = '';
        }
    }

    function renderPreviews(files) {
        if (!uploadPreview) return;
        uploadPreview.querySelectorAll('.return-upload-preview').forEach(el => el.remove());

        Array.from(files).slice(0, 5).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = event => {
                const wrapper = document.createElement('div');
                wrapper.className = 'return-upload-preview';
                wrapper.innerHTML = `<img src="${event.target.result}" alt="Bukti foto retur"><button type="button" aria-label="Hapus foto"><i class="fa-solid fa-xmark"></i></button>`;
                wrapper.querySelector('button').addEventListener('click', () => wrapper.remove());
                uploadPreview.insertBefore(wrapper, uploadPreview.querySelector('.upload-box'));
            };
            reader.readAsDataURL(file);
        });
    }

    function submitReturn() {
        const order = getSelectedOrder();
        if (!validateDeadline(order)) {
            showToast('Pengajuan retur sudah melewati batas 3 hari setelah pesanan diterima.', 'error');
            return;
        }
        if (!imageInput?.files?.length) {
            showToast('Foto bukti produk wajib diunggah.', 'error');
            return;
        }

        const product = selectedProduct(order);
        const returns = JSON.parse(localStorage.getItem(RETURN_KEY) || '[]');
        returns.unshift({
            id: 'RET-' + Date.now(),
            orderId: order?.id || requestedOrder || 'ORDER',
            status: 'Diajukan',
            createdAt: new Date().toISOString(),
            reason: reason.value,
            description: description.value.trim(),
            product: { ...product },
            refundEstimate: Number(product.price || 0) * Number(product.qty || 1),
            photoCount: imageInput.files.length,
            shippingMethod: document.querySelector('input[name="shipping_method"]:checked')?.value || 'pickup'
        });
        localStorage.setItem(RETURN_KEY, JSON.stringify(returns));

        showToast('Pengajuan retur berhasil.');
        submitButton.disabled = true;
        setTimeout(() => {
            window.location.href = document.querySelector('.btn-cancel')?.getAttribute('href') || '/profile/pesanan';
        }, 700);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const order = getSelectedOrder();
        renderOrder(order);

        description?.addEventListener('input', () => {
            if (descriptionCount) descriptionCount.textContent = `${description.value.length} / 500`;
            updateSubmitButton();
        });
        reason?.addEventListener('change', updateSubmitButton);
        agreement?.addEventListener('change', updateSubmitButton);
        imageInput?.addEventListener('change', () => {
            renderPreviews(imageInput.files);
            updateSubmitButton();
        });
        document.querySelectorAll('input[name="shipping_method"]').forEach(input => {
            input.addEventListener('change', () => {
                document.querySelectorAll('.shipping-option').forEach(option => option.classList.remove('active'));
                input.closest('.shipping-option')?.classList.add('active');
            });
        });
        submitButton?.addEventListener('click', submitReturn);
        updateSubmitButton();
    });
})();
