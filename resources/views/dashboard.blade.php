@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
  <!-- Welcome Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card bg-gradient-primary">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h3 class="text-white mb-2">
                <i class="fas fa-hand-wave mr-2"></i>
                Selamat Datang, {{ Auth::user()->name }}!
              </h3>
              <p class="text-white-50 mb-0">
                <i class="fas fa-shield-alt mr-1"></i>
                Role: <strong class="text-white">{{ Auth::user()->isAdmin() ? 'Administrator' : 'Verifikator' }}</strong>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <i class="far fa-clock mr-1"></i>
                {{ now()->format('d F Y, H:i') }} WITA
              </p>
            </div>
            <div class="col-md-4 text-right">
              <a href="{{ route('documents.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Dokumen
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $totalDocuments ?? 0 }}</h3>
          <p>Total Dokumen</p>
        </div>
        <div class="icon">
          <i class="fas fa-file-alt"></i>
        </div>
        <a href="{{ route('documents.index') }}" class="small-box-footer">
          Lihat Detail <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $pendingDocuments ?? 0 }}</h3>
          <p>Pending Verification</p>
        </div>
        <div class="icon">
          <i class="fas fa-clock"></i>
        </div>
        <a href="{{ route('documents.index', ['status' => 'pending']) }}" class="small-box-footer">
          Lihat Detail <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $verifiedDocuments ?? 0 }}</h3>
          <p>Verified</p>
        </div>
        <div class="icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <a href="{{ route('documents.index', ['status' => 'verified']) }}" class="small-box-footer">
          Lihat Detail <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $rejectedDocuments ?? 0 }}</h3>
          <p>Rejected</p>
        </div>
        <div class="icon">
          <i class="fas fa-times-circle"></i>
        </div>
        <a href="{{ route('documents.index', ['status' => 'rejected']) }}" class="small-box-footer">
          Lihat Detail <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- Analysis Cards -->
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="info-box bg-gradient-success">
        <span class="info-box-icon"><i class="fas fa-user-check"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Nasabah Berpotensi</span>
          <span class="info-box-number">
            @php
              $nasabahBerpotensi = App\Models\Document::where('status_riwayat', 'bersih')
                  ->where('status', 'verified')
                  ->where('estimasi_selesai', '<=', date('Y'))
                  ->distinct('no_rekening')
                  ->count('no_rekening');
            @endphp
            {{ $nasabahBerpotensi ?? 0 }} Nasabah
          </span>
          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <span class="progress-description">
            Nasabah dengan riwayat kredit bersih
          </span>
        </div>
        <div class="info-box-footer">
          <a href="{{ route('analysis.rekomendasi') }}" class="text-white">
            Lihat Rekomendasi <i class="fas fa-arrow-circle-right ml-1"></i>
          </a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="info-box bg-gradient-info">
        <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Analisis Kategori Dokumen</span>
          <span class="info-box-number">
            {{ App\Models\Document::distinct('jenis_dokumen')->count() }} Kategori
          </span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="progress-description">
            Distribusi berdasarkan jenis dokumen
          </span>
        </div>
        <div class="info-box-footer">
          <a href="{{ route('analysis.kategori') }}" class="text-white">
            Lihat Analisis <i class="fas fa-arrow-circle-right ml-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="row">
    <!-- Recent Documents -->
    <section class="col-lg-8">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-file-alt mr-2"></i>
            Dokumen Terbaru
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i> Upload Baru
            </a>
          </div>
        </div>
        <div class="card-body p-0">
          @if (isset($recentDocuments) && $recentDocuments->count() > 0)
            <div class="table-responsive">
              <table class="table table-hover table-striped mb-0">
                <thead class="bg-light">
                  <tr>
                    <th>Nasabah</th>
                    <th>Jenis Dokumen</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($recentDocuments as $document)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="user-avatar mr-2">
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                          </div>
                          <div>
                            <strong>{{ $document->nama_nasabah }}</strong><br>
                            <small class="text-muted">
                              <i class="fas fa-credit-card mr-1"></i>
                              {{ $document->no_rekening }}
                            </small>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-secondary">
                          <i class="fas {{ $document->document_type_icon }} mr-1"></i>
                          {{ $document->jenis_dokumen }}
                        </span>
                      </td>
                      <td class="text-center">{!! $document->status_badge !!}</td>
                      <td class="text-center">
                        <small>
                          <i class="far fa-calendar-alt mr-1"></i>
                          {{ $document->created_at->format('d/m/Y') }}
                        </small>
                      </td>
                      <td class="text-center">
                        <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-info"
                          title="Lihat Detail">
                          <i class="fas fa-eye"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer text-center">
              <a href="{{ route('documents.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-list mr-1"></i> Lihat Semua Dokumen
              </a>
            </div>
          @else
            <div class="text-center py-5">
              <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
              <h5 class="text-muted">Belum Ada Dokumen</h5>
              <p class="text-muted">Mulai dengan mengupload dokumen nasabah pertama Anda</p>
              <a href="{{ route('documents.create') }}" class="btn btn-primary mt-2">
                <i class="fas fa-plus mr-2"></i> Upload Dokumen Pertama
              </a>
            </div>
          @endif
        </div>
      </div>
    </section>

    <!-- Quick Actions & Activity -->
    <section class="col-lg-4">
      <!-- Quick Actions -->
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-bolt mr-2"></i>
            Quick Actions
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="list-group list-group-flush">
            <a href="{{ route('documents.create') }}" class="list-group-item list-group-item-action">
              <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-primary text-white rounded-circle mr-3"
                  style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-upload"></i>
                </div>
                <div>
                  <strong>Upload Dokumen</strong><br>
                  <small class="text-muted">Tambah dokumen baru</small>
                </div>
              </div>
            </a>

            <a href="{{ route('documents.index') }}" class="list-group-item list-group-item-action">
              <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-info text-white rounded-circle mr-3"
                  style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-list"></i>
                </div>
                <div>
                  <strong>Daftar Dokumen</strong><br>
                  <small class="text-muted">Lihat semua dokumen</small>
                </div>
              </div>
            </a>

            @if (Auth::user()->isAdmin())
              <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                  <div class="icon-wrapper bg-warning text-white rounded-circle mr-3"
                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-users"></i>
                  </div>
                  <div>
                    <strong>Management User</strong><br>
                    <small class="text-muted">Kelola pengguna</small>
                  </div>
                </div>
              </a>
            @endif

            <a href="{{ route('reports.daftar-dokumen') }}" class="list-group-item list-group-item-action">
              <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-success text-white rounded-circle mr-3"
                  style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-chart-bar"></i>
                </div>
                <div>
                  <strong>Generate Laporan</strong><br>
                  <small class="text-muted">Buat laporan dokumen</small>
                </div>
              </div>
            </a>

            <a href="{{ route('analysis.rekomendasi') }}" class="list-group-item list-group-item-action">
              <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-purple text-white rounded-circle mr-3"
                  style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-user-check"></i>
                </div>
                <div>
                  <strong>Rekomendasi</strong><br>
                  <small class="text-muted">Nasabah berpotensi</small>
                </div>
              </div>
            </a>

            <a href="{{ route('analysis.kategori') }}" class="list-group-item list-group-item-action">
              <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-danger text-white rounded-circle mr-3"
                  style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                  <strong>Analisis Kategori</strong><br>
                  <small class="text-muted">Distribusi dokumen</small>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>

      <!-- System Info -->
      <div class="card card-secondary card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-info-circle mr-2"></i>
            Informasi Sistem
          </h3>
        </div>
        <div class="card-body">
          <div class="info-item mb-3">
            <i class="fas fa-server text-primary mr-2"></i>
            <strong>Status Server:</strong>
            <span class="badge badge-success float-right">Online</span>
          </div>
          <div class="info-item mb-3">
            <i class="fas fa-database text-info mr-2"></i>
            <strong>Database:</strong>
            <span class="badge badge-success float-right">Connected</span>
          </div>
          <div class="info-item mb-3">
            <i class="fas fa-hdd text-warning mr-2"></i>
            <strong>Storage:</strong>
            <span class="text-muted float-right">75% Used</span>
          </div>

        </div>
      </div>
    </section>
  </div>
@endsection

@push('styles')
  <style>
    .bg-purple {
      background-color: #6f42c1 !important;
    }

    .info-box-footer {
      padding: 10px;
      text-align: center;
      background: rgba(0, 0, 0, 0.1);
    }

    .info-box-footer a {
      text-decoration: none;
      font-weight: 500;
    }

    .list-group-item:hover {
      background-color: #f8f9fa;
      transform: translateX(5px);
      transition: all 0.3s ease;
    }

    .icon-wrapper {
      flex-shrink: 0;
    }

    .info-item {
      padding: 8px 0;
      border-bottom: 1px solid #e9ecef;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .user-avatar {
      flex-shrink: 0;
    }
  </style>
@endpush
