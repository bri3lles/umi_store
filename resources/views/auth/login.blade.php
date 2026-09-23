<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk - Akun Anda</title>
  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Memanggil CSS Terpisah -->
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

  <div class="container">
    <div class="left-side">
      <img src="{{ asset('images/bg.png') }}" alt="Store Front">
    </div>

    <div class="right-side">
      <div class="nav-tabs">
        <a href="{{ route('login') }}" class="active">MASUK</a>
        <a href="{{ route('register') }}">DAFTAR</a>
      </div>

      <div class="form-header">
        <h2>Masuk ke Akun Anda</h2>
        <p>Silahkan masukkan detail akun anda untuk melanjutkan</p>
      </div>

      <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="masukkan email" required>
        </div>

        <div class="form-group">
          <label for="password">Kata Sandi</label>
          <input type="password" id="password" name="password" placeholder="masukkan sandi" required>
        </div>

        <div class="checkbox-group">
          <input type="checkbox" id="show-pass">
          <label for="show-pass">Tampilkan kata sandi</label>
        </div>

        <button type="submit" class="btn-submit">MASUK</button>
      </form>

      <div class="social-login">
        <p>atau masuk dengan</p>
        <div class="social-icons">
          <button type="button" title="Google">G</button>
          <button type="button" title="Apple"></button>
        </div>
      </div>
    </div>
  </div>

  <!-- Memanggil JS Terpisah -->
  <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>