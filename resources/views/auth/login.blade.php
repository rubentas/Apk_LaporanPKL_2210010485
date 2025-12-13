<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sistem Arsip Digital BRI</title>

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
      width: 70px;
      height: auto;
      margin-bottom: 15px;
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

    .demo-info {
      background: #e8f4ff;
      border-left: 4px solid #0033a0;
      padding: 15px;
      border-radius: 6px;
      margin-top: 20px;
      font-size: 13px;
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
  </style>
</head>

<body>
  <div class="container">
    <div class="login-container">
      <!-- HEADER LOGO -->
      <div class="bri-header">
        <img src="{{ asset('adminlte/dist/img/LogoBankBRI.png') }}" alt="BRI Logo" class="bri-logo">
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

          <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <!-- Email Input -->
            <div class="mb-3 input-icon">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" class="form-control" placeholder="Alamat Email"
                value="{{ old('email', 'admin@bri.com') }}" required>
            </div>

            <!-- Password Input -->
            <div class="mb-4 input-icon">
              <i class="fas fa-key"></i>
              <input type="password" name="password" class="form-control" placeholder="Password" value="password123"
                required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-bri w-100">
              <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
            </button>
          </form>

          <!-- Demo Accounts -->
          <div class="demo-info">
            <p class="mb-1"><strong><i class="fas fa-info-circle me-2"></i>Akun Demo:</strong></p>
            <p class="mb-1"><small><strong>Admin:</strong> admin@bri.com | password123</small></p>
            <p class="mb-0"><small><strong>Verifikator:</strong> verifikator@bri.co.id | password123</small></p>
          </div>
        </div>
      </div>

      <!-- FOOTER -->
      <div class="footer">
        <p class="mb-1">&copy; {{ date('Y') }} PT Bank Rakyat Indonesia (Persero) Tbk.</p>
        <p class="mb-0">Sistem Arsip Digital Administrasi Kredit</p>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
