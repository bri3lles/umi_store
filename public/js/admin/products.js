(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => [...c.querySelectorAll(s)];
    const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const digits = (v) => Number(String(v || '').replace(/\D/g, '')) || 0;
    const rupiah = (n) => 'Rp ' + Number(n || 0).toLocaleString('id-ID');
    const SHIRT = '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>';
    const TRASH = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>';

    /* ---------- Daftar: pilih semua ---------- */
    const checkAll = $('[data-check-all]');
    checkAll?.addEventListener('change', () => $$('[data-check-row]').forEach((c) => (c.checked = checkAll.checked)));

    const form = $('[data-product-form]');
    if (!form) return;
    const field = (name) => $(`[name="${name}"]`, form);

    /* ---------- 1. Informasi dasar ---------- */
    const nameInput = field('name');
    const nameCount = $('[data-name-count]', form);
    const updateCount = () => (nameCount.textContent = `${nameInput.value.length} / 100 karakter`);
    nameInput.addEventListener('input', updateCount);
    updateCount();

    $$('[data-material]', form).forEach((b) => b.addEventListener('click', () => (field('material').value = b.dataset.material)));

    $('[data-sku-auto]', form)?.addEventListener('click', () => {
        const cat = (field('category').value || 'PRD').replace(/[^A-Za-z]/g, '').slice(0, 3).toUpperCase();
        const ini = (nameInput.value.trim().split(/\s+/).slice(0, 3).map((w) => w[0] || '').join('') || 'XXX').toUpperCase();
        field('sku').value = `UMI-${cat}-${ini}${Math.floor(Math.random() * 90) + 10}`;
        renderVariants();
    });

    const desc = field('description');
    const TEMPLATE = '✨ NAMA PRODUK BY UMI STORE ✨\n\nDeskripsi singkat busana...\n\nKeunggulan Produk:\n• \n• \n\nDetail Produk:\n• Bahan: \n• Panduan ukuran: \n\nCatatan: warna dapat sedikit berbeda dari foto karena pencahayaan.';
    $$('[data-fmt]', form).forEach((b) =>
        b.addEventListener('click', () => {
            const s = desc.selectionStart, e = desc.selectionEnd, sel = desc.value.slice(s, e), f = b.dataset.fmt;
            let out;
            if (f === 'ul') out = (sel || 'Poin').split('\n').map((l) => '• ' + l).join('\n');
            else if (f === 'ol') out = (sel || 'Poin').split('\n').map((l, i) => `${i + 1}. ${l}`).join('\n');
            else out = f + (sel || 'teks') + f;
            desc.setRangeText(out, s, e, 'end');
            desc.focus();
        })
    );
    $('[data-template]', form)?.addEventListener('click', () => {
        desc.value = desc.value.trim() ? desc.value + '\n\n' + TEMPLATE : TEMPLATE;
        desc.focus();
    });

    /* ---------- 4. Harga ---------- */
    const marginEl = $('[data-margin]', form);
    function updateMargin() {
        const cost = digits(field('cost_price').value), price = digits(field('price').value);
        if (!price) { marginEl.textContent = ''; return; }
        const profit = price - cost;
        marginEl.textContent = `Estimasi laba per item: ${rupiah(profit)} (${((profit / price) * 100).toFixed(1).replace('.', ',')}%)`;
    }
    $$('[data-money]', form).forEach((i) =>
        i.addEventListener('input', () => {
            const d = i.value.replace(/\D/g, '');
            i.value = d ? Number(d).toLocaleString('id-ID') : '';
            updateMargin();
        })
    );
    updateMargin();

    /* ---------- 2. Galeri foto ---------- */
    const gal = $('[data-gallery]', form);
    if (gal) {
        const MAX = 5, MAX_SIZE = 5 * 1024 * 1024;
        const input = $('input[type=file]', gal), grid = $('[data-gallery-grid]', gal), counter = $('[data-gallery-count]', gal);
        const err = $('[data-gallery-error]', gal), zone = $('[data-dropzone]', gal);
        let items = JSON.parse(gal.dataset.initial || '[]');

        const syncInput = () => {
            const dt = new DataTransfer();
            items.forEach((i) => i.file && dt.items.add(i.file));
            input.files = dt.files;
        };
        const renderGallery = () => {
            counter.textContent = `${items.length} / ${MAX} Foto Terpasang`;
            grid.innerHTML = items.map((it, i) => `
                <figure class="thumb-card" style="--tone:${esc(it.color || '#94A3B8')}">
                    ${it.src ? `<img src="${it.src}" alt="">` : `<span class="thumb-card__ph">${SHIRT}</span>`}
                    ${i === 0 ? '<span class="thumb-card__main">Foto Utama</span>' : ''}
                    <button type="button" class="thumb-card__rm" data-rm-photo="${i}" aria-label="Hapus foto">${TRASH}</button>
                    <figcaption>${esc(it.label)}</figcaption>
                </figure>`).join('');
        };
        const addFiles = (files) => {
            err.textContent = '';
            for (const f of files) {
                if (!/^image\/(jpeg|png|webp)$/.test(f.type)) { err.textContent = 'Format harus JPG, PNG, atau WEBP.'; continue; }
                if (f.size > MAX_SIZE) { err.textContent = `"${f.name}" melebihi 5MB.`; continue; }
                if (items.length >= MAX) { err.textContent = 'Maksimal 5 foto.'; break; }
                items.push({ file: f, src: URL.createObjectURL(f), label: f.name.replace(/\.[^.]+$/, '') });
            }
            syncInput();
            renderGallery();
        };

        input.addEventListener('change', () => addFiles([...input.files]));
        ['dragenter', 'dragover'].forEach((ev) => zone.addEventListener(ev, (e) => { e.preventDefault(); zone.classList.add('is-drag'); }));
        ['dragleave', 'drop'].forEach((ev) => zone.addEventListener(ev, () => zone.classList.remove('is-drag')));
        zone.addEventListener('drop', (e) => { e.preventDefault(); addFiles([...e.dataTransfer.files]); });
        grid.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-rm-photo]');
            if (!btn) return;
            items.splice(Number(btn.dataset.rmPhoto), 1);
            syncInput();
            renderGallery();
        });
        renderGallery();
    }

    /* ---------- 3. Varian ---------- */
    const panel = $('[data-variants-panel]', form);
    const toggle = $('[data-variants-toggle]', form);
    const body = $('[data-variant-body]', form);
    const stockInput = $('[data-stock-total]', form);
    const stockMode = $('[data-stock-mode]', form);
    const cfg = JSON.parse(panel.dataset.initial || '{}');
    const PALETTE = cfg.palette || {};
    const SUGGEST = Object.keys(PALETTE).slice(0, 5);
    const ORDER = ['S', 'M', 'L', 'XL', 'XXL', 'All Size'];
    const state = { colors: cfg.colors || [], sizes: [...(cfg.sizes || [])], rows: {} };
    const key = (c, s) => `${c}|${s}`;
    (cfg.rows || []).forEach((r) => (state.rows[key(r.color, r.size)] = { extra: r.extra || 0, stock: r.stock || 0 }));

    const code = (name) => {
        const w = name.trim().split(/\s+/);
        return (w.map((x) => x[0]).join('') + w[w.length - 1].slice(1)).slice(0, 3).toUpperCase();
    };

    function renderColors() {
        const chips = state.colors.map((c) => `<span class="color-chip"><i style="background:${esc(c.hex)}"></i>${esc(c.name)}<button type="button" data-rm-color="${esc(c.name)}" aria-label="Hapus warna ${esc(c.name)}">×</button></span>`);
        const suggest = SUGGEST.filter((n) => !state.colors.some((c) => c.name === n))
            .map((n) => `<button type="button" class="color-chip color-chip--add" data-add-suggest="${esc(n)}"><i style="background:${esc(PALETTE[n])}"></i>+ ${esc(n)}</button>`);
        $('[data-colors]', form).innerHTML = chips.concat(suggest).join('');
    }

    function syncSizes() {
        $$('[data-size]', form).forEach((b) => {
            const on = state.sizes.includes(b.dataset.size);
            b.classList.toggle('is-on', on);
            b.setAttribute('aria-pressed', String(on));
        });
    }

    function updateTotal() {
        if (!toggle.checked) return;
        stockInput.value = $$('[data-stock]', body).reduce((sum, i) => sum + (Number(i.value) || 0), 0);
    }

    function renderVariants() {
        const colors = state.colors.length ? state.colors : [null];
        const sizes = state.sizes.length ? state.sizes : [null];
        const combos = [];
        if (state.colors.length || state.sizes.length) colors.forEach((c) => sizes.forEach((s) => combos.push([c, s])));

        const base = (field('sku').value || 'UMI').trim();
        body.innerHTML = combos.length ? combos.map(([c, s], i) => {
            const k = key(c ? c.name : '', s || '');
            const row = state.rows[k] || (state.rows[k] = { extra: 0, stock: 0 });
            const sku = [base, c && code(c.name), s && s.replace(/\s/g, '').toUpperCase()].filter(Boolean).join('-');
            const label = [c && c.name, s].filter(Boolean).join(' - ');
            return `<tr>
                <td><span class="variant-name">${c ? `<i style="background:${esc(c.hex)}"></i>` : ''}${esc(label)}</span>
                    <input type="hidden" name="variants[${i}][color]" value="${esc(c ? c.name : '')}">
                    <input type="hidden" name="variants[${i}][size]" value="${esc(s || '')}">
                    <input type="hidden" name="variants[${i}][sku]" value="${esc(sku)}"></td>
                <td><div class="prefix-input"><span>+Rp</span><input type="text" inputmode="numeric" class="input" data-extra="${esc(k)}" name="variants[${i}][extra_price]" value="${Number(row.extra).toLocaleString('id-ID')}" aria-label="Harga tambahan ${esc(label)}"></div></td>
                <td><input type="number" min="0" class="input" data-stock="${esc(k)}" name="variants[${i}][stock]" value="${row.stock}" aria-label="Stok ${esc(label)}"></td>
                <td class="text-muted">${esc(sku)}</td>
                <td><span class="badge ${row.stock > 0 ? 'badge--active' : 'badge--out'}" data-status>${row.stock > 0 ? 'Tersedia' : 'Habis'}</span></td>
            </tr>`;
        }).join('') : '<tr><td colspan="5"><div class="variant-empty">Pilih warna dan ukuran untuk membuat kombinasi varian.</div></td></tr>';
        updateTotal();
    }

    body.addEventListener('input', (e) => {
        const el = e.target;
        if (el.dataset.stock !== undefined) {
            const n = Math.max(0, Number(el.value) || 0);
            state.rows[el.dataset.stock].stock = n;
            const badge = $('[data-status]', el.closest('tr'));
            badge.className = `badge ${n > 0 ? 'badge--active' : 'badge--out'}`;
            badge.textContent = n > 0 ? 'Tersedia' : 'Habis';
            updateTotal();
        } else if (el.dataset.extra !== undefined) {
            const n = digits(el.value);
            state.rows[el.dataset.extra].extra = n;
            el.value = n.toLocaleString('id-ID');
        }
    });

    $('[data-colors]', form).addEventListener('click', (e) => {
        const rm = e.target.closest('[data-rm-color]');
        const add = e.target.closest('[data-add-suggest]');
        if (rm) state.colors = state.colors.filter((c) => c.name !== rm.dataset.rmColor);
        else if (add) state.colors.push({ name: add.dataset.addSuggest, hex: PALETTE[add.dataset.addSuggest] });
        else return;
        renderColors();
        renderVariants();
    });

    const colorForm = $('[data-color-form]', form);
    const colorName = $('[data-color-name]', form), colorHex = $('[data-color-hex]', form);
    $('[data-add-color]', form).addEventListener('click', () => { colorForm.classList.toggle('is-hidden'); colorName.focus(); });
    const addCustomColor = () => {
        const name = colorName.value.trim();
        if (!name || state.colors.some((c) => c.name.toLowerCase() === name.toLowerCase())) return;
        state.colors.push({ name, hex: colorHex.value });
        colorName.value = '';
        renderColors();
        renderVariants();
    };
    $('[data-color-submit]', form).addEventListener('click', addCustomColor);
    colorName.addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); addCustomColor(); } });

    $$('[data-size]', form).forEach((b) =>
        b.addEventListener('click', () => {
            const s = b.dataset.size;
            if (state.sizes.includes(s)) state.sizes = state.sizes.filter((x) => x !== s);
            else if (s === 'All Size') state.sizes = ['All Size'];
            else state.sizes = state.sizes.filter((x) => x !== 'All Size').concat(s);
            state.sizes.sort((a, b) => ORDER.indexOf(a) - ORDER.indexOf(b));
            syncSizes();
            renderVariants();
        })
    );

    const applyToggle = () => {
        panel.disabled = !toggle.checked;
        stockInput.readOnly = toggle.checked;
        stockMode.textContent = toggle.checked ? 'Otomatis dari varian' : 'Input manual';
        updateTotal();
    };
    toggle.addEventListener('change', applyToggle);
    field('sku').addEventListener('input', renderVariants);

    renderColors();
    syncSizes();
    renderVariants();
    applyToggle();
})();