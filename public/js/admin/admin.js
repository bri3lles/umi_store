const $ = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => [...c.querySelectorAll(s)];
const body = document.body;

/* Sidebar (drawer di mobile/tablet) */
const setAside = (open) => body.classList.toggle('is-aside-open', open);
$$('[data-aside-toggle]').forEach((btn) =>
    btn.addEventListener('click', () => setAside(!body.classList.contains('is-aside-open')))
);
$('[data-aside-overlay]')?.addEventListener('click', () => setAside(false));
$$('.admin-aside__link').forEach((a) => a.addEventListener('click', () => setAside(false)));

/* Dropdown: notifikasi & profil */
const closeDropdowns = () =>
    $$('[data-dropdown].is-open').forEach((dd) => {
        dd.classList.remove('is-open');
        $('[data-dropdown-toggle]', dd)?.setAttribute('aria-expanded', 'false');
    });

$$('[data-dropdown]').forEach((dd) => {
    const toggle = $('[data-dropdown-toggle]', dd);
    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        const willOpen = !dd.classList.contains('is-open');
        closeDropdowns();
        dd.classList.toggle('is-open', willOpen);
        toggle.setAttribute('aria-expanded', String(willOpen));
    });
});
document.addEventListener('click', (e) => {
    if (!e.target.closest('[data-dropdown]')) closeDropdowns();
});

/* Search: tekan "/" untuk fokus */
document.addEventListener('keydown', (e) => {
    const typing = /^(input|textarea|select)$/i.test(document.activeElement.tagName);
    if (e.key === '/' && !typing) {
        e.preventDefault();
        $('[data-search-input]')?.focus();
    }
    if (e.key === 'Escape') {
        closeDropdowns();
        setAside(false);
        $('[data-modal].is-open')?.classList.remove('is-open');
    }
});

/* Filter: kirim form otomatis saat select berubah */
$$('[data-autosubmit]').forEach((el) => el.addEventListener('change', () => el.form.submit()));

/* Modal (hapus & ubah role) */
$$('[data-modal-open]').forEach((btn) =>
    btn.addEventListener('click', () => {
        const modal = $(`[data-modal="${btn.dataset.modalOpen}"]`);
        if (!modal) return;
        $('form', modal).action = btn.dataset.action;
        $('[data-modal-name]', modal).textContent = btn.dataset.name;
        const select = $('select[name="role"]', modal);
        if (select) select.value = btn.dataset.role;
        modal.classList.add('is-open');
        $('[data-modal-close]', modal)?.focus();
    })
);
$$('[data-modal]').forEach((modal) =>
    modal.addEventListener('click', (e) => {
        if (e.target === modal || e.target.closest('[data-modal-close]')) modal.classList.remove('is-open');
    })
);