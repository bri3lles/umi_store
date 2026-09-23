@extends('admin.layouts.app')

@section('title', __('users.show.title'))

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">{{ __('users.show.title') }}</h1>
            <p class="page-subtitle">{{ __('users.show.subtitle') }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn--secondary">
                <x-admin.icon name="arrow-left" :size="18" /> {{ __('users.show.back') }}
            </a>
            <button type="button" class="btn btn--primary" data-modal-open="role"
                    data-action="{{ route('admin.users.role', $user->id) }}"
                    data-name="{{ $user->name }}" data-role="{{ $user->role }}">
                <x-admin.icon name="user-cog" :size="18" /> {{ __('users.show.edit_role') }}
            </button>
            <button type="button" class="btn btn--danger" data-modal-open="delete"
                    data-action="{{ route('admin.users.destroy', $user->id) }}" data-name="{{ $user->name }}">
                <x-admin.icon name="trash" :size="18" /> {{ __('users.show.delete') }}
            </button>
        </div>
    </div>

    <div class="profile">
        <div class="card card--pad profile__card">
            <x-admin.avatar :name="$user->name" :size="88" />
            <h2 class="profile__name">{{ $user->name }}</h2>
            <p class="profile__email">{{ $user->email }}</p>
            <div class="profile__badges">
                <span class="badge badge--{{ $user->role }}">{{ $roles[$user->role] }}</span>
                <span class="badge badge--{{ $user->status }}">{{ $statuses[$user->status] }}</span>
            </div>
        </div>

        <div class="card card--pad">
            <h2 class="info-title">{{ __('users.show.account_info_title') }}</h2>
            <dl class="info-grid">
                <div>
                    <dt>{{ __('users.show.field_name') }}</dt>
                    <dd>{{ $user->name }}</dd>
                </div>
                <div>
                    <dt>{{ __('users.show.field_email') }}</dt>
                    <dd>{{ $user->email }}</dd>
                </div>
                <div>
                    <dt>{{ __('users.show.field_role') }}</dt>
                    <dd>{{ $roles[$user->role] }}</dd>
                </div>
                <div>
                    <dt>{{ __('users.show.field_status') }}</dt>
                    <dd>{{ $statuses[$user->status] }}</dd>
                </div>
                <div>
                    <dt>{{ __('users.show.field_created_at') }}</dt>
                    <dd>{{ $user->created_at->locale(app()->getLocale())->translatedFormat(__('users.show.date_format')) }}</dd>
                </div>
                <div>
                    <dt>{{ __('users.show.field_updated_at') }}</dt>
                    <dd>{{ $user->updated_at->locale(app()->getLocale())->translatedFormat(__('users.show.date_format')) }}</dd>
                </div>
                <div>
                    <dt>{{ __('users.show.field_user_id') }}</dt>
                    <dd>#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</dd>
                </div>
                <div>
                    <dt>{{ __('users.show.field_total_orders') }}</dt>
                    <dd>
                        {{ $user->role === 'customer'
                            ? __('users.show.orders_count', ['count' => $user->id * 3])
                            : __('users.show.not_applicable') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    @include('admin.users._delete-modal')
    @include('admin.users._role-modal')
@endsection