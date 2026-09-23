(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => [...c.querySelectorAll(s)];
    const form = $('[data-settings-form]');
    if (!form) return;

    /* Toko buka/tutup: label ikut berubah */
    const openToggle = $('[data-store-open]', form);
    openToggle?.addEventListener('change', () => {
        $('.switch--sm span', openToggle.closest('.switch')).textContent = `Toko ${openToggle.checked ? 'Buka' : 'Tutup'}`;
    });

    /* Ekspedisi: label status ikut berubah */
    $$('[data-courier-toggle]', form).forEach((cb) =>
        cb.addEventListener('change', () => {
            const status = cb.closest('.courier-card').querySelector('[data-courier-status]');
            status.textContent = cb.checked ? 'Aktif' : 'Nonaktif';
            status.className = 'ind ' + (cb.checked ? 'ind--ok' : 'ind--out');
            const count = $$('[data-courier-toggle]', form).filter((c) => c.checked).length;
            $('[data-courier-count]', form).textContent = `${count} Ekspedisi Aktif`;
        })
    );
})();