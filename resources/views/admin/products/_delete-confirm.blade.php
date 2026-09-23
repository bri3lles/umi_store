<div class="modal" data-modal="delete" role="dialog" aria-modal="true" aria-labelledby="delete-title">
    <div class="modal__dialog">
        <div class="modal__icon"><x-admin.icon name="alert" :size="22" /></div>
        <h2 class="modal__title" id="delete-title">Hapus produk?</h2>
        <p class="modal__text">Apakah Anda yakin ingin menghapus produk <strong data-modal-name></strong>? Foto dan varian produk ikut terhapus dan tidak dapat dikembalikan.</p>
        <div class="modal__actions">
            <button type="button" class="btn btn--secondary" data-modal-close>Batal</button>
            <form method="POST" action="#">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--danger">Hapus</button>
            </form>
        </div>
    </div>
</div>