@extends('admin.layouts.app')

@section('title', __('users.index.title'))

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">{{ __('users.index.title') }}</h1>
            <p class="page-subtitle">{{ __('users.index.subtitle') }}</p>
        </div>
    </div>

    <div class="card">
        <form method="GET" action="{{ route('admin.users.index') }}" class="toolbar">
            <label class="search-field">
                <x-admin.icon name="search" :size="18" />
                <input type="search" name="q" class="input" value="{{ request('q') }}"
                       placeholder="{{ __('users.index.search_placeholder') }}"
                       aria-label="{{ __('users.index.search_label') }}">
            </label>
            <select name="role" class="select" aria-label="{{ __('users.index.filter_role_label') }}" data-autosubmit>
                <option value="">{{ __('users.index.filter_role_all') }}</option>
                @foreach ($roles as $value => $label)
                    <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="status" class="select" aria-label="{{ __('users.index.filter_status_label') }}" data-autosubmit>
                <option value="">{{ __('users.index.filter_status_all') }}</option>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @if (request()->hasAny(['q', 'role', 'status']))
                <a href="{{ route('admin.users.index') }}" class="btn btn--ghost">{{ __('users.index.reset') }}</a>
            @endif
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-no">{{ __('users.index.col_no') }}</th>
                        <th>{{ __('users.index.col_name') }}</th>
                        <th>{{ __('users.index.col_email') }}</th>
                        <th>{{ __('users.index.col_role') }}</th>
                        <th>{{ __('users.index.col_status') }}</th>
                        <th>{{ __('users.index.col_joined') }}</th>
                        <th class="col-actions">{{ __('users.index.col_actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-muted">{{ $users->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="user-cell">
                                    <x-admin.avatar :name="$user->name" />
                                    <a class="user-cell__name" href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a>
                                </div>
                            </td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td><span class="badge badge--{{ $user->role }}">{{ $roles[$user->role] }}</span></td>
                            <td>
    @php
        $statusKey = $user->status ?: 'active';
    @endphp

    <span class="badge badge--{{ $statusKey }}">
        {{ $statuses[$statusKey] ?? ucfirst($statusKey) }}
    </span>
</td>
                            <td class="text-muted">{{ $user->created_at->locale(app()->getLocale())->translatedFormat('d M Y') }}</td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="icon-btn"
                                       title="{{ __('users.index.action_detail') }}"
                                       aria-label="{{ __('users.index.action_detail_for', ['name' => $user->name]) }}">
                                        <x-admin.icon name="eye" :size="18" />
                                    </a>
                                    <button type="button" class="icon-btn"
                                            title="{{ __('users.index.action_role') }}"
                                            aria-label="{{ __('users.index.action_role_for', ['name' => $user->name]) }}"
                                            data-modal-open="role" data-action="{{ route('admin.users.role', $user->id) }}"
                                            data-name="{{ $user->name }}" data-role="{{ $user->role }}">
                                        <x-admin.icon name="user-cog" :size="18" />
                                    </button>
                                    <button type="button" class="icon-btn icon-btn--danger"
                                            title="{{ __('users.index.action_delete') }}"
                                            aria-label="{{ __('users.index.action_delete_for', ['name' => $user->name]) }}"
                                            data-modal-open="delete" data-action="{{ route('admin.users.destroy', $user->id) }}"
                                            data-name="{{ $user->name }}">
                                        <x-admin.icon name="trash" :size="18" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="empty">{{ __('users.index.empty') }}</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-admin.pagination :paginator="$users" />
    </div>

    @include('admin.users._delete-modal')
    @include('admin.users._role-modal')
@endsection