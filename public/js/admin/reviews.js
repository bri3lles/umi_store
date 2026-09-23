(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const replyModal = $('[data-modal="reply"]'), visModal = $('[data-modal="visibility"]'), delModal = $('[data-modal="delete"]');
    if (!replyModal) return;

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-review-action]');
        const card = btn?.closest('[data-review]');
        if (!card) return;
        const r = JSON.parse(card.dataset.review);

        switch (btn.dataset.reviewAction) {
            case 'reply': {
                $('[data-rp-customer]', replyModal).textContent = r.customer;
                $('[data-rp-product]', replyModal).textContent = r.product;
                $('[data-rp-comment]', replyModal).textContent = '“' + r.comment + '”';
                $('[data-rp-form]', replyModal).action = r.reply_url;
                $('[name="message"]', replyModal).value = r.reply || '';
                replyModal.classList.add('is-open');
                $('[name="message"]', replyModal).focus();
                break;
            }
            case 'visibility': {
                const hide = !r.hidden;
                $('[data-vs-title]', visModal).textContent = hide ? 'Sembunyikan ulasan?' : 'Tampilkan ulasan?';
                $('[data-vs-text]', visModal).innerHTML = hide
                    ? `Ulasan <b>${esc(r.customer)}</b> untuk <b>${esc(r.product)}</b> tidak akan tampil di halaman produk, tapi datanya tetap tersimpan.`
                    : `Ulasan <b>${esc(r.customer)}</b> untuk <b>${esc(r.product)}</b> akan tampil kembali di halaman produk.`;
                $('[data-vs-form]', visModal).action = r.visibility_url;
                visModal.classList.add('is-open');
                break;
            }
            case 'delete':
                $('[data-del-customer]', delModal).textContent = r.customer;
                $('[data-del-product]', delModal).textContent = r.product;
                $('[data-del-form]', delModal).action = r.delete_url;
                delModal.classList.add('is-open');
                break;
        }
    });
})();