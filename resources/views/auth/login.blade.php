<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sistem Arsip Digital BRI</title>

  <link rel="icon" href="https://www.bri.co.id/favicon.ico" type="image/x-icon">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
      max-width: 420px;
      margin: 0 auto;
      padding-top: 60px;
    }

    .bri-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .bri-logo {
      width: 120px;
      height: auto;
      margin-bottom: 15px;
      object-fit: contain;
    }

    .bri-title {
      color: #0033a0;
      font-weight: 700;
      font-size: 24px;
      margin-bottom: 5px;
    }

    .bri-subtitle {
      color: #666;
      font-size: 14px;
      margin-bottom: 0;
    }

    .login-card {
      background: white;
      border-radius: 12px;
      border: none;
      box-shadow: 0 8px 30px rgba(0, 51, 160, 0.12);
      overflow: hidden;
    }

    .card-header {
      background: #0033a0;
      color: white;
      text-align: center;
      padding: 20px;
      border-bottom: 0;
    }

    .card-body {
      padding: 30px;
    }

    .form-control {
      border-radius: 8px;
      padding: 12px 15px;
      border: 1px solid #ddd;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: #0033a0;
      box-shadow: 0 0 0 0.25rem rgba(0, 51, 160, 0.25);
    }

    .btn-bri {
      background: #0033a0;
      color: white;
      border-radius: 8px;
      padding: 12px;
      font-weight: 600;
      border: none;
      transition: all 0.3s;
    }

    .btn-bri:hover {
      background: #00267a;
      transform: translateY(-1px);
    }

    .footer {
      text-align: center;
      margin-top: 30px;
      color: #666;
      font-size: 12px;
    }

    .input-icon {
      position: relative;
    }

    .input-icon i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
    }

    .input-icon input {
      padding-left: 45px;
    }

    .forgot-password {
      text-align: center;
      margin-top: 15px;
    }

    .forgot-password a {
      color: #0033a0;
      text-decoration: none;
      font-size: 14px;
    }

    .forgot-password a:hover {
      text-decoration: underline;
    }

    .alert {
      border-radius: 8px;
      border: none;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #842029;
    }

    .alert-success {
      background-color: #d1e7dd;
      color: #0f5132;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="login-container">
      <!-- HEADER LOGO -->
      <div class="bri-header">
        <!-- Logo BRI menggunakan Laravel asset helper -->
        <img src="{{ asset('adminlte/dist/img/LogoBankBRI.png') }}" alt="BRI Logo" class="bri-logo"
          onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Logo_BRI_%28Bank_Rakyat_Indonesia%29.svg/2560px-Logo_BRI_%28Bank_Rakyat_Indonesia%29.svg.png'">

        <h1 class="bri-title">Sistem Arsip Digital</h1>
        <p class="bri-subtitle">BRI KC Tanjung Tabalong</p>
      </div>

      <!-- LOGIN CARD -->
      <div class="login-card">
        <div class="card-header">
          <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Masuk ke Sistem</h5>
        </div>

        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <i class="fas fa-exclamation-circle me-2"></i>
              Email atau password salah.
            </div>
          @endif

          @if (session('success'))
            <div class="alert alert-success">
              <i class="fas fa-check-circle me-2"></i>
              {{ session('success') }}
            </div>
          @endif

          <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <!-- Email Input -->
            <div class="mb-3 input-icon">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" class="form-control" placeholder="Alamat Email"
                value="{{ old('email') }}" required autofocus>
            </div>

            <!-- Password Input -->
            <div class="mb-4 input-icon">
              <i class="fas fa-key"></i>
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-bri w-100">
              <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
            </button>

            <!-- Forgot Password Link -->
            <div class="forgot-password">
              <a href="#">
                <i class="fas fa-question-circle me-1"></i>Lupa Password?
              </a>
            </div>
          </form>
        </div>
      </div>

      <!-- FOOTER -->
      <div class="footer">
        <p class="mb-1">&copy; {{ date('Y') }} PT Bank Rakyat Indonesia (Persero) Tbk.</p>
        <p class="mb-0">Sistem Arsip Digital Administrasi Kredit</p>
        <p class="mb-0 mt-2">
          <i class="fas fa-shield-alt me-1"></i>Keamanan Terjaga
        </p>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JavaScript untuk form handling -->
  <script>
    // Focus ke email input saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
      const emailInput = document.querySelector('input[name="email"]');
      if (emailInput) {
        emailInput.focus();
      }

      // Set judul halaman secara dinamis
      document.title = "Login - Sistem Arsip Digital BRI";
    });

    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
      const email = document.querySelector('input[name="email"]').value;
      const password = document.querySelector('input[name="password"]').value;

      if (!email || !password) {
        e.preventDefault();
        alert('Harap isi email dan password!');
        return false;
      }

      // Validasi format email sederhana
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Format email tidak valid!');
        return false;
      }
    });
  </script>
</body>

</html>
