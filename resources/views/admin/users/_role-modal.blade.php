{{--
    Modal ini dipakai ulang (shared) untuk semua baris user; nama user diisi lewat
    JavaScript (data-modal-name) saat modal dibuka. Placeholder ":name" pada string
    terjemahan digantikan dengan elemen <strong data-modal-name> lewat str_replace.
--}}
<div class="modal" data-modal="role" role="dialog" aria-modal="true" aria-labelledby="role-title">
    <div class="modal__dialog">
        <h2 class="modal__title" id="role-title">{{ __('users.role_modal.title') }}</h2>
        <p class="modal__text">
            {!! str_replace(':name', '<strong data-modal-name></strong>', __('users.role_modal.description')) !!}
        </p>
        <form method="POST" action="#">
            @csrf
            @method('PATCH')
            <div class="field modal__field">
                <label class="field__label" for="role-select">{{ __('users.role_modal.field_label') }}</label>
                <select id="role-select" name="role" class="select">
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal__actions">
                <button type="button" class="btn btn--secondary" data-modal-close>{{ __('users.role_modal.cancel') }}</button>
                <button type="submit" class="btn btn--primary">{{ __('users.role_modal.submit') }}</button>
            </div>
        </form>
    </div>
</div>