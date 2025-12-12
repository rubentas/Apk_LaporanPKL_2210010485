@extends('layouts.app')

@section('title', 'About System')
@section('page-title', 'About System')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">About System</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
              <i class="fas fa-info-circle mr-2"></i>Sistem Manajemen Arsip Digital BRI
            </h3>
          </div>
          <div class="card-body">
            <div class="text-center mb-4">
              <img src="{{ asset('adminlte/dist/img/LogoBankBRI.png') }}" alt="BRI Logo"
                style="height: 80px; margin-bottom: 20px;">
              <h4>PT BANK RAKYAT INDONESIA (PERSERO) Tbk</h4>
              <h5>KC TANJUNG TABALONG</h5>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="info-box bg-light">
                  <span class="info-box-icon bg-primary"><i class="fas fa-code"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Version</span>
                    <span class="info-box-number">{{ $systemInfo['version'] }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box bg-light">
                  <span class="info-box-icon bg-success"><i class="fas fa-calendar"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Last Update</span>
                    <span class="info-box-number">{{ $systemInfo['last_update'] }}</span>
                  </div>
                </div>
              </div>
            </div>

            <h5 class="mt-4"><i class="fas fa-cogs mr-1"></i> System Information</h5>
            <table class="table table-bordered">
              <tr>
                <th width="40%">Framework</th>
                <td>{{ $systemInfo['framework'] }}</td>
              </tr>
              <tr>
                <th>PHP Version</th>
                <td>{{ $systemInfo['php_version'] }}</td>
              </tr>
              <tr>
                <th>Database</th>
                <td>{{ $systemInfo['database'] }}</td>
              </tr>
              <tr>
                <th>Environment</th>
                <td>
                  <span class="badge badge-{{ $systemInfo['environment'] == 'production' ? 'success' : 'warning' }}">
                    {{ $systemInfo['environment'] }}
                  </span>
                </td>
              </tr>
              <tr>
                <th>Developer</th>
                <td>{{ $systemInfo['developer'] }}</td>
              </tr>
            </table>

            <h5 class="mt-4"><i class="fas fa-feather-alt mr-1"></i> Features</h5>
            <div class="row">
              <div class="col-md-6">
                <ul class="list-group">
                  <li class="list-group-item">
                    <i class="fas fa-check text-success mr-2"></i>Multi-role Authentication
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-check text-success mr-2"></i>Document Upload & Management
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-check text-success mr-2"></i>Verification Workflow
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-check text-success mr-2"></i>File Download & Security
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="list-group">
                  <li class="list-group-item">
                    <i class="fas fa-check text-success mr-2"></i>6 Comprehensive Reports
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-check text-success mr-2"></i>PDF Export Function
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-check text-success mr-2"></i>Activity Logging
                  </li>
                  <li class="list-group-item">
                    <i class="fas fa-check text-success mr-2"></i>Real-time Dashboard
                  </li>
                </ul>
              </div>
            </div>

            <div class="alert alert-info mt-4">
              <h6><i class="fas fa-exclamation-circle mr-1"></i> Important Notes</h6>
              <small>
                • Sistem ini dikembangkan untuk keperluan administrasi kredit BRI<br>
                • Semua data dokumen bersifat rahasia dan terlindungi<br>
                • Lakukan backup data secara berkala<br>
                • Untuk bantuan teknis, hubungi tim IT BRI
              </small>
            </div>
          </div>
          <div class="card-footer text-center">
            <small class="text-muted">
              &copy; {{ date('Y') }} PT Bank Rakyat Indonesia (Persero) Tbk. All rights reserved.
            </small>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-shield-alt mr-1"></i>
              Security Information
            </h3>
          </div>
          <div class="card-body">
            <div class="text-center mb-3">
              <i class="fas fa-lock fa-3x text-success"></i>
            </div>
            <p class="text-justify">
              Sistem ini menggunakan <strong>enkripsi data</strong> dan
              <strong>autentikasi multi-level</strong> untuk memastikan
              keamanan data dokumen nasabah.
            </p>
            <ul class="list-unstyled">
              <li class="mb-2">
                <i class="fas fa-check text-success mr-1"></i>
                Password hashing dengan bcrypt
              </li>
              <li class="mb-2">
                <i class="fas fa-check text-success mr-1"></i>
                Session timeout otomatis
              </li>
              <li class="mb-2">
                <i class="fas fa-check text-success mr-1"></i>
                Protection against XSS & SQL injection
              </li>
              <li class="mb-2">
                <i class="fas fa-check text-success mr-1"></i>
                File validation & virus scanning
              </li>
            </ul>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-question-circle mr-1"></i>
              Quick Help
            </h3>
          </div>
          <div class="card-body">
            <div class="list-group">
              <a href="{{ route('documents.create') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-upload mr-2"></i>Bagaimana cara upload dokumen?
              </a>
              <a href="{{ route('reports.daftar-dokumen') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-chart-bar mr-2"></i>Bagaimana melihat laporan?
              </a>
              <a href="{{ route('settings.profile') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-user mr-2"></i>Bagaimana cara mengubah password?
              </a>
              <button class="list-group-item list-group-item-action" data-toggle="modal" data-target="#contactModal">
                <i class="fas fa-envelope mr-2"></i>Contact Support
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Modal -->
  <div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-envelope mr-1"></i>Contact Support
          </h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Untuk bantuan teknis atau pertanyaan tentang sistem:</p>
          <ul>
            <li><strong>Email:</strong> it.support@bri.co.id</li>
            <li><strong>Phone:</strong> (021) 579-55555</li>
            <li><strong>Ext:</strong> 1234 (IT Support)</li>
          </ul>
          <p class="mb-0"><small class="text-muted">Jam operasional: Senin-Jumat, 08:00-17:00 WIB</small></p>
        </div>
      </div>
    </div>
  </div>
@endsection
