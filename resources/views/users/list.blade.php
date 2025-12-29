<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Pengguna - BRI Document Management</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f8f9fc;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .container {
      max-width: 1000px;
      width: 100%;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
    }

    .logo-bri {
      height: 50px;
      margin-right: 15px;
    }

    .title {
      color: #0033a0;
      font-weight: 700;
      font-size: 2rem;
      margin-bottom: 5px;
    }

    .subtitle {
      color: #666;
      font-size: 1rem;
      margin-bottom: 30px;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 51, 160, 0.1);
      overflow: hidden;
    }

    .card-header {
      background: linear-gradient(135deg, #0033a0 0%, #0056b3 100%);
      color: white;
      padding: 20px 30px;
      border-bottom: none;
    }

    .card-header h3 {
      margin: 0;
      font-weight: 600;
      font-size: 1.5rem;
    }

    .back-btn {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      color: white;
      text-decoration: none;
      transition: all 0.3s;
      font-size: 0.9rem;
    }

    .back-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
    }

    .table-container {
      padding: 0;
    }

    .table {
      margin: 0;
      border-radius: 0;
    }

    .table thead {
      background-color: #f1f5fd;
    }

    .table thead th {
      border-bottom: 2px solid #dee2e6;
      padding: 15px;
      font-weight: 600;
      color: #0033a0;
      border-top: none;
    }

    .table tbody tr {
      transition: background-color 0.2s;
    }

    .table tbody tr:hover {
      background-color: rgba(0, 51, 160, 0.03);
    }

    .table tbody td {
      padding: 15px;
      vertical-align: middle;
      border-color: #eef2f7;
    }

    .badge-admin {
      background-color: #dc3545;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .badge-adminstaff {
      background-color: #ffc107;
      color: #212529;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .badge-verifikator {
      background-color: #007bff;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .badge-you {
      background-color: #28a745;
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      margin-left: 8px;
    }

    .badge-active {
      background-color: #e9ecef;
      color: #495057;
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
    }

    .card-footer {
      background-color: #f8f9fc;
      border-top: 1px solid #eef2f7;
      padding: 15px 30px;
    }

    .footer-text {
      color: #6c757d;
      font-size: 0.9rem;
    }

    .total-users {
      color: #0033a0;
      font-weight: 600;
    }

    @media (max-width: 768px) {
      .container {
        padding: 10px;
      }

      .title {
        font-size: 1.5rem;
      }

      .table thead th,
      .table tbody td {
        padding: 10px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="logo-container">
        <img src="{{ asset('adminlte/dist/img/LogoBankBRI.png') }}" alt="BRI Logo" class="logo-bri"
          style="filter: brightness(0) invert(0.1);">
        <h1 class="title">BRI Document Management</h1>
      </div>
      <p class="subtitle">Sistem Manajemen Dokumen Kredit BRI</p>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-users me-2"></i> Data Pengguna Sistem</h3>
        <a href="{{ route('dashboard') }}" class="back-btn">
          <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
      </div>

      <div class="table-container">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 60px">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $index => $user)
                <tr>
                  <td class="text-center fw-bold">{{ $index + 1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if ($user->role === 'admin')
                      <span class="badge-admin">Administrator</span>
                    @elseif($user->role === 'adminstaff')
                      <span class="badge-adminstaff">Admin Staff</span>
                    @elseif($user->role === 'verifikator')
                      <span class="badge-verifikator">Verifikator</span>
                    @endif
                  </td>
                  <td>
                    <span class="badge-active">Aktif</span>
                    @if ($user->id === auth()->id())
                      <span class="badge-you">Anda</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-footer">
        <div class="row">
          <div class="col-md-6">
            <p class="footer-text">
              Total: <span class="total-users">{{ $users->count() }}</span> pengguna
            </p>
          </div>
          <div class="col-md-6 text-md-end">
            <p class="footer-text">
              <i class="fas fa-calendar-alt me-1"></i> {{ date('d/m/Y') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>

</html>
