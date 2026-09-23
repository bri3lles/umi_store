@php
    // Data dummy dipakai bila belum ada user yang login (tahap frontend).
    $admin         = auth()->user();
    $adminName     = $admin->name ?? 'Ibu Rahma';
    $adminPosition = $admin->position ?? 'Owner';
@endphp

<header class="admin-header">
    <button type="button" class="admin-header__menu" data-aside-toggle aria-label="{{ __('common.open_menu') }}" aria-controls="admin-aside">
        <x-admin.icon name="menu" />
    </button>

    <form class="admin-search" role="search" action="#" method="GET" onsubmit="return false">
        <x-admin.icon name="search" :size="20" />
        <input type="search" name="q" placeholder="{{ __('common.search_placeholder') }}" aria-label="{{ __('common.search_label') }}" data-search-input autocomplete="off">
    </form>

    <div class="admin-header__right">
        <div class="dropdown" data-dropdown>
            <button type="button" class="admin-profile__btn" data-dropdown-toggle aria-expanded="false" aria-haspopup="menu">
                @if (!empty($admin?->photo))
                    <img class="admin-profile__photo" src="{{ asset('storage/' . $admin->photo) }}" alt="">
                @else
                    <x-admin.avatar :name="$adminName" />
                @endif
                <span class="admin-profile__text">
                    <span class="admin-profile__name">{{ $adminName }} ({{ $adminPosition }})</span>
                </span>
            </button>
        </div>
    </div>
</header>