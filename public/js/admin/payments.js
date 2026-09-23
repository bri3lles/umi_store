(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const modals = { approve: $('[data-modal="approve"]'), reject: $('[data-modal="reject"]'), proof: $('[data-modal="proof"]') };
    if (!modals.approve) return;

    let active = null;
    const open = (name) => {
        Object.values(modals).forEach((m) => m.classList.remove('is-open'));
        modals[name].classList.add('is-open');
    };

    $('[data-refresh]')?.addEventListener('click', () => location.reload());

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-pay-action]');
        if (!btn) return;
        const host = btn.closest('[data-payment]');
        if (host) active = JSON.parse(host.dataset.payment);
        if (!active) return;

        switch (btn.dataset.payAction) {
            case 'approve':
                $('[data-ap-order]', modals.approve).textContent = active.order;
                $('[data-ap-name]', modals.approve).textContent = active.customer;
                $('[data-ap-amount]', modals.approve).textContent = active.amount_label;
                $('[data-ap-form]', modals.approve).action = active.approve_url;
                open('approve');
                break;
            case 'reject':
                $('[data-rj-order]', modals.reject).textContent = active.order;
                $('[data-rj-form]', modals.reject).action = active.reject_url;
                $('[data-rj-form]', modals.reject).reset();
                open('reject');
                break;
            case 'view-proof':
                fillProof(active);
                open('proof');
                break;
        }
    });

    function fillProof(p) {
        $('[data-pf-order]', modals.proof).textContent = p.order;
        $('[data-pf-image]', modals.proof).src = p.proof_image ?? '';
    }
})();