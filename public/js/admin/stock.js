(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => [...c.querySelectorAll(s)];
    const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    const adjModal = $('[data-modal="adjust"]');
    const histModal = $('[data-modal="history"]');
    if (!adjModal) return;

    /* ---------- Update cepat: stepper + tombol ---------- */
    const rowQty = (row) => Math.max(0, parseInt($('[data-qty]', row).value, 10) || 0);

    function refreshButton(row) {
        const btn = $('[data-save]', row), cur = Number(row.dataset.current), qty = rowQty(row);
        let state = 'dirty', label = 'Simpan';
        if (qty === cur) { state = cur === 0 ? 'restock' : 'idle'; label = cur === 0 ? 'Restock' : 'Simpan'; }
        btn.dataset.state = state;
        btn.setAttribute('aria-disabled', String(state === 'idle'));
        $('[data-label]', btn).textContent = label;
        $('[data-ico="save"]', btn).hidden = state === 'restock';
        $('[data-ico="restock"]', btn).hidden = state !== 'restock';
    }

    $$('[data-stock-row]').forEach((row) => {
        const input = $('[data-qty]', row);
        $$('[data-step]', row).forEach((b) =>
            b.addEventListener('click', () => {
                input.value = Math.max(0, rowQty(row) + Number(b.dataset.step));
                refreshButton(row);
            })
        );
        input.addEventListener('input', () => refreshButton(row));
        $('[data-save]', row).addEventListener('click', () => {
            const state = $('[data-save]', row).dataset.state;
            if (state === 'idle') return;
            openAdjust(row, state === 'restock' ? '' : rowQty(row));
        });
        $('[data-history-open]', row).addEventListener('click', () => openHistory(row));
        refreshButton(row);
    });

    /* ---------- Modal ubah stok ---------- */
    const form = $('[data-adj-form]', adjModal);
    const qtyField = $('[data-adj-qty]', adjModal);
    const diffEl = $('[data-adj-diff]', adjModal);
    const submit = $('[data-adj-submit]', adjModal);
    const reason = $('[name="reason"]', adjModal);
    let current = 0;

    function updateDiff() {
        if (qtyField.value === '') { diffEl.textContent = ''; diffEl.className = 'diff'; submit.disabled = true; return; }
        const d = Number(qtyField.value) - current;
        diffEl.textContent = d === 0 ? 'Tidak ada perubahan stok.' : `Perubahan: ${d > 0 ? '+' : ''}${d} pcs`;
        diffEl.className = 'diff' + (d > 0 ? ' diff--in' : d < 0 ? ' diff--out' : '');
        submit.disabled = d === 0;
    }

    function openAdjust(row, qty) {
        current = Number(row.dataset.current);
        form.action = row.dataset.action;
        $('[data-adj-name]', adjModal).textContent = row.dataset.name;
        $('[data-adj-variant]', adjModal).textContent = row.dataset.variant;
        $('[data-adj-current]', adjModal).value = `${current} pcs`;
        qtyField.value = qty;
        reason.value = qty === '' || Number(qty) > current ? 'restock' : 'correction';
        $('[name="note"]', adjModal).value = '';
        updateDiff();
        adjModal.classList.add('is-open');
        qtyField.focus();
    }
    qtyField.addEventListener('input', () => {
        updateDiff();
        if (qtyField.value !== '') reason.value = Number(qtyField.value) > current ? 'restock' : reason.value === 'restock' ? 'correction' : reason.value;
    });

    /* ---------- Modal riwayat ---------- */
    function openHistory(row) {
        const entries = JSON.parse(row.dataset.history || '[]');
        $('[data-hist-name]', histModal).textContent = row.dataset.name;
        $('[data-hist-variant]', histModal).textContent = row.dataset.variant;
        $('[data-hist-body]', histModal).innerHTML = entries.length
            ? entries.map((e) => `<tr>
                <td class="nowrap">${esc(e.date)}</td>
                <td><b class="delta--${e.qty > 0 ? 'in' : 'out'}">${e.qty > 0 ? '+' : ''}${e.qty}</b></td>
                <td>${e.after} pcs</td><td>${esc(e.reason)}</td><td class="text-muted">${esc(e.by)}</td></tr>`).join('')
            : '<tr><td colspan="5"><div class="empty">Belum ada riwayat.</div></td></tr>';
        histModal.classList.add('is-open');
    }
})();