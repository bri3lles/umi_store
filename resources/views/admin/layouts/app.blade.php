<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Umi Store Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    <script src="{{ asset('js/admin/admin.js') }}" defer></script>
    @stack('styles')
</head>
<body class="admin-body">
    @include('admin.layouts.aside')
    <div class="admin-overlay" data-aside-overlay></div>

    <div class="admin-main">
        @include('admin.layouts.header')

        <main class="admin-content">
            @if (session('success'))
                <div class="alert alert--success" role="status">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert--danger" role="alert">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>