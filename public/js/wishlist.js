document.addEventListener('DOMContentLoaded', function () {
    const KEY = 'umiWishlist';
    const grid = document.getElementById('wishlistGrid');
    const empty = document.getElementById('wishlistEmpty');
    if (!grid) return;

    function read(){try{const x=JSON.parse(localStorage.getItem(KEY)||'[]');return Array.isArray(x)?x:[]}catch{return[]}}
    function save(x){localStorage.setItem(KEY,JSON.stringify(x))}
    function money(v){return 'Rp '+Number(v||0).toLocaleString('id-ID')}
    function slug(v){return String(v).toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'')}

    function render(){
        const items=read(); grid.innerHTML='';
        empty.style.display=items.length?'none':'block';
        items.forEach(item=>{
            const card=document.createElement('div'); card.className='wishlist-product-card';
            card.innerHTML=`<div class="wishlist-image-container"><img src="${item.image||''}" alt="${item.name||'Produk'}" class="wishlist-product-image" onerror="this.style.visibility='hidden'"><button type="button" class="wishlist-btn active" data-id="${item.id}"><i class="fa-solid fa-heart"></i></button></div><div class="wishlist-product-info"><div class="wishlist-rating"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div><h3 class="wishlist-product-title">${item.name||'Produk Umi Store'}</h3><p class="wishlist-product-subtitle">${item.category||'Koleksi Umi Store'}</p><div class="wishlist-product-bottom"><span class="wishlist-product-price">${money(item.price)}</span><a href="{{ route('detail') }}?product=${encodeURIComponent(item.id||slug(item.name))}" class="wishlist-detail-btn">Lihat Detail</a></div></div>`;
            grid.appendChild(card);
        });
    }

    grid.addEventListener('click', function(e){
        const btn=e.target.closest('.wishlist-btn'); if(!btn)return;
        const id=btn.dataset.id; save(read().filter(item=>item.id!==id)); render();
    });
    render();
});
