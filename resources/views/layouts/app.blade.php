<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Sistem Arsip Digital BRI')</title>

  <!-- Favicon -->
  <link rel="icon" href="https://www.bri.co.id/favicon.ico" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Bootstrap 4 CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <!-- AdminLTE CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif;
    }

    .main-header .navbar-nav .nav-link {
      padding: 0.5rem 1rem;
    }

    .content-wrapper {
      background-color: #f4f6f9;
      min-height: calc(100vh - 57px);
    }

    .content-header {
      padding: 15px 0.5rem;
    }

    .card {
      border-radius: 8px;
      border: 1px solid #e3e6f0;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }

    .card-header {
      background-color: #f8f9fc;
      border-bottom: 1px solid #e3e6f0;
      font-weight: 700;
    }

    .btn-primary {
      background-color: #0033a0;
      border-color: #0033a0;
    }

    .btn-primary:hover {
      background-color: #002b8a;
      border-color: #002b8a;
    }

    .table th {
      background-color: #f8f9fa;
      font-weight: 600;
      color: #495057;
    }

    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
      background-color: #0033a0;
    }

    .info-box {
      border-radius: 8px;
      overflow: hidden;
    }

    .todo-list>li {
      border-radius: 5px;
      margin-bottom: 5px;
      padding: 8px;
    }

    /* Untuk halaman dokumen kosong */
    .empty-state {
      padding: 4rem 2rem;
      text-align: center;
      background-color: #f8f9fa;
      border-radius: 10px;
    }

    .empty-state i {
      font-size: 4rem;
      color: #6c757d;
      margin-bottom: 1rem;
    }

    .empty-state h4 {
      color: #343a40;
      margin-bottom: 0.5rem;
    }

    .empty-state p {
      color: #6c757d;
      margin-bottom: 1.5rem;
    }

    /* Breadcrumb */
    .breadcrumb {
      background-color: transparent;
      padding: 0;
      margin: 0;
    }

    .breadcrumb-item+.breadcrumb-item::before {
      content: "›";
      color: #6c757d;
    }

    /* Tambahan untuk breadcrumb yang lebih rapi */
    .breadcrumb-item a {
      color: #6c757d;
      text-decoration: none;
    }

    .breadcrumb-item a:hover {
      color: #0033a0;
      text-decoration: underline;
    }

    .breadcrumb-item.active {
      color: #0033a0;
      font-weight: 600;
    }
  </style>

  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('components.navbar')
    @include('components.sidebar')

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                @if (View::hasSection('breadcrumb'))
                  @yield('breadcrumb')
                @else
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @endif
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle mr-2"></i>
              {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-circle mr-2"></i>
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          @yield('content')
        </div>
      </section>
    </div>

    @include('components.footer')
  </div>

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap 4 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AdminLTE CDN -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

  <!-- bs-custom-file-input -->
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

  <script>
    $(document).ready(function() {
      // Auto-hide alerts
      setTimeout(function() {
        $('.alert').alert('close');
      }, 5000);

      // Initialize bs-custom-file-input
      if (typeof bsCustomFileInput !== 'undefined') {
        bsCustomFileInput.init();
      }

      // Initialize tooltips
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

  @stack('scripts')
</body>

</html>
