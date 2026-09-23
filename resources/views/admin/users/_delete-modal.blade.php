{{--
    Modal ini dipakai ulang (shared) untuk semua baris user; nama user diisi lewat
    JavaScript (data-modal-name) saat modal dibuka — lihat public/js/admin/users.js.
    Karena itu, placeholder ":name" pada string terjemahan TIDAK diganti oleh __(),
    melainkan digantikan dengan elemen <strong data-modal-name> lewat str_replace.
--}}
<div class="modal" data-modal="delete" role="dialog" aria-modal="true" aria-labelledby="delete-title">
    <div class="modal__dialog">
        <div class="modal__icon"><x-admin.icon name="alert" :size="22" /></div>
        <h2 class="modal__title" id="delete-title">{{ __('users.delete_modal.title') }}</h2>
        <p class="modal__text">
            {!! str_replace(':name', '<strong data-modal-name></strong>', __('users.delete_modal.description')) !!}
        </p>
        <div class="modal__actions">
            <button type="button" class="btn btn--secondary" data-modal-close>{{ __('users.delete_modal.cancel') }}</button>
            <form method="POST" action="#">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--danger">{{ __('users.delete_modal.submit') }}</button>
            </form>
        </div>
    </div>
</div>