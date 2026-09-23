@extends('layouts.app')

@section('title', 'Profile - Umi Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')

<main class="profile-page">

    <div class="profile-container">

        {{-- =========================
             PROFILE HEADER
        ========================== --}}
        <section class="profile-header">

            <div class="profile-info">

                <div class="profile-user">

                    {{-- FOTO PROFILE --}}
                    <div class="profile-avatar-wrapper">

                        <img
                            src="{{ $user->foto_profil ?? 'https://i.pinimg.com/1200x/6b/ff/7a/6bff7ab751622668e3ef078064de7cfe.jpg' }}"
                            alt="Foto Profil"
                            class="profile-avatar"
                        >

                    </div>


                    {{-- DATA USER --}}
                    <div class="profile-user-info">

                        <h1>
                            {{ $user->nama ?? 'Reva' }}
                        </h1>

                        <p>
                            <i class="fa-regular fa-envelope"></i>
                            {{ $user->email ?? 'siti.rahmawati@email.com' }}
                        </p>

                    </div>


                    {{-- LOGOUT --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="profile-logout-btn">

                            <i class="fa-solid fa-right-from-bracket"></i>

                            <span>Keluar</span>

                        </button>

                    </form>

                </div>


                {{-- =========================
                     NAVIGASI PROFILE
                ========================== --}}
                <div class="profile-tabs-bar">
                    <nav class="profile-tabs">
                        <a href="{{ route('profile.pesanan') }}" class="profile-tab {{ request()->routeIs('profile.pesanan') ? 'is-active' : '' }}">
                            <i class="fa-solid fa-box"></i>
                            <span>Pesanan Saya</span>
                        </a>
                        <a href="{{ route('profile.wishlist') }}" class="profile-tab {{ request()->routeIs('profile.wishlist') ? 'is-active' : '' }}">
                            <i class="fa-regular fa-heart"></i>
                            <span>Wishlist</span>
                        </a>
                        <a href="{{ route('profile.pengaturan') }}" class="profile-tab {{ request()->routeIs('profile.pengaturan') ? 'is-active' : '' }}">
                            <i class="fa-solid fa-gear"></i>
                            <span>Pengaturan</span>
                        </a>
                    </nav>
                </div>
            </div>
        </section>
        @yield('profile-content')
    </div>
</main>

@endsection