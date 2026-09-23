(function () {
    'use strict';

    const CART_KEY = 'umiCart';
    const get = id => document.getElementById(id);
    const money = value => 'Rp ' + Number(value || 0).toLocaleString('id-ID');

    function toast(message, type = 'success') {
        let el = get('umiDetailToast');
        if (!el) { el = document.createElement('div'); el.id='umiDetailToast'; el.style.cssText='position:fixed;right:24px;bottom:24px;z-index:9999;background:#002D72;color:#fff;padding:12px 16px;border-radius:10px;font:600 14px Inter,sans-serif;box-shadow:0 10px 25px rgba(0,0,0,.15)'; document.body.appendChild(el); }
        el.textContent=message; el.style.background=type==='error'?'#b42318':'#002D72'; clearTimeout(window.__detailToast); window.__detailToast=setTimeout(()=>el.remove(),2400);
    }

    function selectedColor() {
        const active = document.querySelector('.color-chip-group .chip-btn.active, .variant-box:first-of-type .chip-btn.active');
        return active?.dataset.colorName || active?.dataset.color || active?.innerText.trim() || '';
    }

    function selectedSize() {
        const active = document.querySelector('.size-chip-group .chip-btn.active');
        return active?.dataset.size || active?.innerText.trim() || '';
    }

    function selectColor(element) {
        if (element.disabled || element.classList.contains('disabled')) return;
        document.querySelectorAll('.chip-btn[data-color-id], .color-chip-group .chip-btn').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
        const label = get('colorName') || get('selectedColorLabel');
        if (label) label.textContent = element.dataset.colorName || element.dataset.color || element.innerText.trim();
        const target = document.querySelector(`.thumb-card[data-color-id="${element.dataset.colorId}"]`);
        const main = get('mainImage');
        if (target && main) main.src = target.src;
        document.querySelectorAll('.thumb-card').forEach(thumb => thumb.classList.remove('active'));
        target?.classList.add('active');
    }

    function switchImage(element) {
        const main = get('mainImage');
        if (main) main.src = element.src;
        document.querySelectorAll('.thumb-card').forEach(thumb => thumb.classList.remove('active'));
        element.classList.add('active');
        if (element.dataset.colorId) {
            const color = document.querySelector(`.chip-btn[data-color-id="${element.dataset.colorId}"]`);
            if (color) selectColor(color);
        }
    }

    function selectSize(element) {
        if (element.disabled || element.classList.contains('disabled')) return;
        document.querySelectorAll('.size-chip-group .chip-btn').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
        const label = get('selectedSizeLabel');
        if (label) label.textContent = element.dataset.size || element.innerText.trim();
    }

    function adjustQty(amount) {
        const input = get('quantity');
        if (!input) return;
        const current = Math.max(1, Number(input.value) || 1);
        const next = Math.max(1, Math.min(5, current + amount));
        input.value = next;
    }

    function toggleModal(show) { get('sizeModal')?.classList.toggle('is-open', Boolean(show)); }
    function openSizeModal() { toggleModal(true); }

    function toggleReadMore() {
        const wrapper=get('descWrapper'), btn=get('btnReadMore'); if(!wrapper||!btn)return;
        const expanded=wrapper.classList.toggle('expanded'); btn.classList.toggle('active',expanded); btn.innerHTML=expanded?'Sembunyikan <i class="fa-solid fa-chevron-up"></i>':'Baca Selengkapnya <i class="fa-solid fa-chevron-down"></i>';
    }

    function toggleReviews() {
        const btn=get('btnToggleReviews'); if(!btn)return;
        const expanded=btn.classList.toggle('active');
        document.querySelectorAll('.review-post.is-hidden').forEach(item=>item.style.display=expanded?'flex':'none');
        const label=btn.querySelector('span'); if(label)label.textContent=expanded?'Sembunyikan Ulasan':'Lihat Semua Ulasan';
    }

    function getCart(){try{const x=JSON.parse(localStorage.getItem(CART_KEY)||'[]');return Array.isArray(x)?x:[]}catch{return[]}}
    function saveCart(cart){localStorage.setItem(CART_KEY,JSON.stringify(cart))}

    function addToCart(buyNow=false){
        const color=selectedColor(), size=selectedSize();
        if(!color){toast('Pilih warna terlebih dahulu.','error');return}
        if(!size){toast('Pilih ukuran terlebih dahulu.','error');return}
        const input=get('quantity'); const qty=Math.max(1,Number(input?.value||1));
        const name=document.querySelector('.item-title')?.textContent.trim()||'Kaos Polos Cotton Combed';
        const price=Number((document.querySelector('.price-active')?.textContent||'').replace(/[^0-9]/g,''))||149000;
        const image=get('mainImage')?.src||'';
        const id='kaos-polos-cotton-combed';
        let cart=getCart();
        const key=`${id}-${size}-${color}`;
        const existing=cart.find(item=>item.id===key);
        if(existing) existing.qty=Math.min(5,existing.qty+qty); else cart.push({id:key,productId:id,name,price,qty,size,color,image,stock:5,selected:true});
        saveCart(cart);
        toast(buyNow?'Menyiapkan pembelian...':'Produk ditambahkan ke keranjang.');
        setTimeout(()=>{window.location.href=buyNow?window.umiRoutes.shipping:window.umiRoutes.cart},250);
    }

    window.selectColor=selectColor; window.switchImage=switchImage; window.selectSize=selectSize; window.adjustQty=adjustQty; window.toggleModal=toggleModal; window.openSizeModal=openSizeModal; window.toggleReadMore=toggleReadMore; window.toggleReviews=toggleReviews;

    document.addEventListener('DOMContentLoaded',()=>{
        get('btnAddToCart')?.addEventListener('click',()=>addToCart(false));
        get('btnBuyNow')?.addEventListener('click',()=>addToCart(true));
    });
})();
