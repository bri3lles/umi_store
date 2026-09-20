<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'UMI STORE')</title>

  <!-- Panggil CSS langsung dari folder public -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <!-- Penampung CSS Khusus Per Halaman (seperti katalog.css) -->
  @stack('styles')

  <!-- Font Awesome v6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  @include('partials.navbar')

  <main>
    @yield('content')
  </main>

  @include('partials.footer')

  <!-- Script Utama -->
  <script src="{{ asset('js/main.js') }}"></script>

  <!-- Penampung JS Khusus Per Halaman (seperti katalog.js) -->
  @stack('scripts')

</body>
</html>