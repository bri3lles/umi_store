(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const shipModal = $('[data-modal="ship"]'), detailModal = $('[data-modal="detail"]');
    const acceptModal = $('[data-modal="accept"]'), rejectModal = $('[data-modal="reject"]'), statusModal = $('[data-modal="status"]');
    if (!shipModal) return;

    const STORE_ADDRESS = 'Jl. Riau No. 88, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115';

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-order-action]');
        const row = btn?.closest('[data-order]');
        if (!row) return;
        const o = JSON.parse(row.dataset.order);

        switch (btn.dataset.orderAction) {
            case 'ship':
                $('[data-sh-order]', shipModal).textContent = o.no;
                $('[data-sh-buyer]', shipModal).textContent = o.buyer;
                $('[data-sh-form]', shipModal).action = o.ship_url;
                $('[name="courier"]', shipModal).value = o.courier_key;
                $('[name="resi"]', shipModal).value = '';
                shipModal.classList.add('is-open');
                break;
            case 'detail':
                fillDetail(o);
                detailModal.classList.add('is-open');
                break;
            case 'print':
                printLabel(o);
                break;
            case 'accept':
                $('[data-ac-order]', acceptModal).textContent = o.no;
                $('[data-ac-buyer]', acceptModal).textContent = o.buyer;
                $('[data-ac-form]', acceptModal).action = o.accept_url;
                acceptModal.classList.add('is-open');
                break;
            case 'reject':
                $('[data-rj-order]', rejectModal).textContent = o.no;
                $('[data-rj-buyer]', rejectModal).textContent = o.buyer;
                $('[data-rj-form]', rejectModal).action = o.reject_url;
                $('[data-rj-form]', rejectModal).reset();
                rejectModal.classList.add('is-open');
                break;
            case 'status':
                $('[data-st-order]', statusModal).textContent = o.no;
                $('[data-st-buyer]', statusModal).textContent = o.buyer;
                $('[data-st-form]', statusModal).action = o.status_url;
                $('[name="status"]', statusModal).value = o.status;
                statusModal.classList.add('is-open');
                break;
        }
    });

    function fillDetail(o) {
        $('[data-od-no]', detailModal).textContent = o.no;
        const st = $('[data-od-status]', detailModal);
        st.className = `status status--${o.status_tone}`;
        st.textContent = o.status_label;

        const cancelled = o.status === 'cancelled';
        $('[data-od-body]', detailModal).innerHTML = `
            <div>
                <section class="od-section"><h3>Pembeli &amp; alamat</h3>
                    <p><b>${esc(o.buyer)}</b> • ${esc(o.phone)}<br>${esc(o.address)}</p></section>
                <section class="od-section"><h3>Pengiriman</h3>
                    <p><b>${esc(o.courier)}</b><br>${o.resi ? 'No. resi: ' + esc(o.resi) : 'Nomor resi belum tersedia'}</p></section>
                <section class="od-section"><h3>Riwayat pesanan</h3>
                    <ul class="timeline">${o.timeline.map((t, i) => `<li class="${cancelled && i === o.timeline.length - 1 ? 'is-cancel' : ''}"><b>${esc(t.label)}</b><small>${esc(t.time)}</small></li>`).join('')}</ul></section>
            </div>
            <div>
                <section class="od-section"><h3>Produk dipesan</h3>
                    <div class="od-items">${o.items.map((i) => `<div class="od-item"><div><b>${esc(i.name)}</b><small>Varian: ${esc(i.variant)} • ${i.qty} pcs</small></div><b>${esc(i.price_label)}</b></div>`).join('')}</div>
                    <div class="od-sum">
                        <div><span>Subtotal</span><span>${esc(o.subtotal_label)}</span></div>
                        <div><span>Ongkos kirim</span><span>${esc(o.shipping_label)}</span></div>
                        <div class="od-total"><span>Total bayar</span><span>${esc(o.total_label)}</span></div>
                    </div></section>
                <section class="od-section"><h3>Pembayaran</h3>
                    <p>${esc(o.method)} ${o.verified ? '• <b style="color:#05603A">Terverifikasi</b>' : '• Belum dibayar'}</p></section>
            </div>`;
    }

    function printLabel(o) {
        const w = window.open('', '_blank', 'width=440,height=620');
        if (!w) return;
        w.document.write(`<!doctype html><meta charset="utf-8"><title>Resi ${esc(o.no)}</title>
            <style>body{font-family:Inter,Arial,sans-serif;padding:24px;color:#101828}h2{margin:0 0 4px}hr{border:0;border-top:1px dashed #98A2B3;margin:14px 0}p{margin:0;line-height:1.5}.resi{font-size:22px;font-weight:700;letter-spacing:.05em}</style>
            <h2>${esc(o.courier)}</h2><p class="resi">${esc(o.resi || '-')}</p><hr>
            <p><b>Penerima</b><br>${esc(o.buyer)} • ${esc(o.phone)}<br>${esc(o.address)}</p><hr>
            <p><b>Pengirim</b><br>Umi Store Busana Muslim &amp; Hijab<br>${esc(STORE_ADDRESS)}</p><hr>
            <p>Pesanan ${esc(o.no)} • ${o.qty} barang</p>`);
        w.document.close();
        w.focus();
        w.print();
    }
})();