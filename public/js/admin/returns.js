(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => [...c.querySelectorAll(s)];
    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const cfgEl = $('[data-returns-config]');
    if (!cfgEl) return;
    const cfg = JSON.parse(cfgEl.dataset.returnsConfig);

    const actModal = $('[data-modal="act"]'), detailModal = $('[data-modal="detail"]'), mediaModal = $('[data-modal="media"]');
    const form = $('[data-act-form]', actModal), fields = $('[data-act-fields]', actModal), submit = $('[data-act-submit]', actModal);

    /* ---------- Pembuat field form ---------- */
    const select = (name, label, options, value) =>
        `<div class="field adj-note"><label class="field__label" for="f-${name}">${label}</label>
         <select id="f-${name}" name="${name}" class="select" required>${Object.entries(options).map(([k, v]) => `<option value="${esc(k)}"${k === value ? ' selected' : ''}>${esc(v)}</option>`).join('')}</select></div>`;
    const input = (name, label, attrs = '') =>
        `<div class="field adj-note"><label class="field__label" for="f-${name}">${label}</label><input id="f-${name}" name="${name}" class="input" ${attrs}></div>`;
    const note = (label = 'Catatan <small class="text-muted">(opsional)</small>') =>
        `<div class="field adj-note"><label class="field__label" for="f-note">${label}</label><textarea id="f-note" name="note" rows="2" maxlength="255" class="input textarea"></textarea></div>`;

    /* ---------- Definisi tiap aksi ---------- */
    const ACTIONS = {
        reject: (o) => ({
            title: 'Tolak pengajuan retur?', btn: 'Tolak Pengajuan', danger: true,
            text: `Pengajuan <b>${esc(o.no)}</b> dari <b>${esc(o.customer)}</b> akan ditolak dan alasan dikirim ke pembeli.`,
            fields: select('reason', 'Alasan penolakan <i>*</i>', cfg.reject_reasons) + note('Pesan untuk pembeli <small class="text-muted">(opsional)</small>'),
        }),
        offer: (o) => ({
            title: 'Tawarkan diskon / voucher', btn: 'Kirim Penawaran',
            text: `Tawarkan kompensasi kepada <b>${esc(o.customer)}</b> sebagai alternatif retur. Jika pembeli setuju, pengajuan ditutup tanpa pengembalian barang.`,
            fields: select('type', 'Jenis penawaran <i>*</i>', cfg.offer_types) + input('value', 'Nilai <i>*</i>', 'type="number" min="1" required placeholder="Contoh: 15 atau 25000"') + note(),
        }),
        approve: (o) => ({
            title: 'Setujui retur?', btn: 'Setujui & Kirim Alamat',
            text: `Pembeli akan menerima alamat pengembalian:<br><b>${esc(cfg.store_address)}</b>`,
            fields: select('resolution', 'Penyelesaian <i>*</i>', cfg.resolutions, o.resolution) +
                select('cost', 'Biaya kirim balik <i>*</i>', cfg.costs, o.reason_key === 'size' ? 'buyer' : 'shop') + note(),
        }),
        arrive: (o) => ({
            title: 'Tandai barang sudah tiba?', btn: 'Tandai Sudah Tiba',
            text: `Barang retur <b>${esc(o.no)}</b> dari <b>${esc(o.customer)}</b> sudah diterima di toko. Cek kondisi fisiknya (QC).`,
            fields: select('qc', 'Hasil pengecekan fisik <i>*</i>', cfg.qc) + note(),
        }),
        complete: (o) => {
            const ex = o.resolution === 'exchange';
            return {
                title: ex ? 'Kirim produk pengganti' : 'Proses refund', btn: 'Tandai Selesai',
                text: ex ? `Produk pengganti${o.exchange_to ? ' (' + esc(o.exchange_to) + ')' : ''} dikirim ke <b>${esc(o.customer)}</b>.`
                         : `Refund <b>${esc(o.price_label)}</b> ke <b>${esc(o.customer)}</b>.`,
                fields: input('reference', ex ? 'Nomor resi pengganti <small class="text-muted">(opsional)</small>' : 'Referensi transfer refund <small class="text-muted">(opsional)</small>', 'maxlength="60"'),
            };
        },
    };

    document.addEventListener('click', (e) => {
        const media = e.target.closest('[data-media]');
        const btn = e.target.closest('[data-return-action]');
        const card = (media || btn)?.closest('[data-return]');
        if (!card) return;
        const o = JSON.parse(card.dataset.return);

        if (media) return openMedia(o.media[Number(media.dataset.media)]);
        const action = btn.dataset.returnAction;

        if (action === 'detail') { fillDetail(o); return detailModal.classList.add('is-open'); }
        if (action === 'print') return printLabel(o);

        const def = ACTIONS[action](o);
        $('[data-act-title]', actModal).textContent = def.title;
        $('[data-act-text]', actModal).innerHTML = def.text;
        fields.innerHTML = def.fields;
        form.action = `${o.act_url}/${action}`;
        submit.textContent = def.btn;
        submit.className = 'btn ' + (def.danger ? 'btn--danger' : 'btn--primary');
        actModal.classList.add('is-open');
        $('select, input', fields)?.focus();
    });

    function openMedia(m) {
        const view = $('[data-media-view]', mediaModal);
        view.style.setProperty('--tone', m.color);
        view.innerHTML = `<svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${m.type === 'video'
            ? '<polygon points="6 3 20 12 6 21 6 3"/>'
            : '<rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>'}</svg><span class="media__cap">${esc(m.label)}</span>`;
        mediaModal.classList.add('is-open');
    }

    function fillDetail(o) {
        $('[data-rd-no]', detailModal).textContent = o.no;
        const chip = $('[data-rd-status]', detailModal);
        chip.className = `rchip rchip--${o.tone}`;
        chip.textContent = o.status_label;
        const rows = [
            ['Pelanggan', `${esc(o.customer)} • ${esc(o.phone)}<br>${esc(o.address)}`],
            ['Pesanan asal', esc(o.order)],
            ['Produk', `${esc(o.product)}<br>${esc(o.variant_line)}`],
            ['Alasan', esc(o.reason)],
            ['Penyelesaian diminta', esc(o.resolution_label)],
        ];
        if (o.courier) rows.push(['Pengembalian', `${esc(o.courier)} • Resi ${esc(o.resi_back)}<br>${esc(o.cost_label)}`]);
        if (o.decision) rows.push(['Keputusan', esc(o.decision)]);
        const rejected = o.status === 'rejected';
        $('[data-rd-body]', detailModal).innerHTML = `
            <dl class="info-grid info-grid--one">${rows.map(([k, v]) => `<div><dt>${k}</dt><dd>${v}</dd></div>`).join('')}</dl>
            <section class="od-section"><h3>Riwayat retur</h3>
                <ul class="timeline">${o.timeline.map((t, i) => `<li class="${rejected && i === o.timeline.length - 1 ? 'is-cancel' : ''}"><b>${esc(t.label)}</b><small>${esc(t.time)}</small></li>`).join('')}</ul></section>`;
    }

    function printLabel(o) {
        const w = window.open('', '_blank', 'width=440,height=620');
        if (!w) return;
        w.document.write(`<!doctype html><meta charset="utf-8"><title>Label pengganti ${esc(o.no)}</title>
            <style>body{font-family:Inter,Arial,sans-serif;padding:24px;color:#101828}h2{margin:0 0 4px}hr{border:0;border-top:1px dashed #98A2B3;margin:14px 0}p{margin:0;line-height:1.5}</style>
            <h2>Label Pengiriman Pengganti</h2><p>Retur ${esc(o.no)} • Pesanan ${esc(o.order)}</p><hr>
            <p><b>Penerima</b><br>${esc(o.customer)} • ${esc(o.phone)}<br>${esc(o.address)}</p><hr>
            <p><b>Pengirim</b><br>Umi Store Busana Muslim &amp; Hijab<br>${esc(cfg.store_address)}</p><hr>
            <p><b>Isi paket</b><br>${esc(o.product)}${o.exchange_to ? ' — ' + esc(o.exchange_to) : ''}</p>`);
        w.document.close();
        w.focus();
        w.print();
    }
})();