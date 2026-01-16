@extends('layouts.app')

@section('title', 'Laporan Aktivitas Pengguna')
@section('page-title', 'Laporan Aktivitas Pengguna')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="#">Laporan</a></li>
  <li class="breadcrumb-item active">Aktivitas Pengguna</li>
@endsection

@section('styles')
  <style>
    /* Fix pagination styling */
    .pagination {
      margin: 0;
    }

    .pagination .page-link {
      padding: 0.375rem 0.75rem;
      font-size: 0.875rem;
      line-height: 1.5;
      border: 1px solid #dee2e6;
      color: #007bff;
    }

    .pagination .page-item.active .page-link {
      background-color: #007bff;
      border-color: #007bff;
      color: #fff;
    }

    .pagination .page-item.disabled .page-link {
      color: #6c757d;
      pointer-events: none;
      background-color: #fff;
      border-color: #dee2e6;
    }

    .pagination .page-link:hover {
      color: #0056b3;
      background-color: #e9ecef;
      border-color: #dee2e6;
    }

    /* Remove any custom SVG/icon styling that might be causing issues */
    .pagination svg {
      display: none;
    }

    .pagination .page-link::before,
    .pagination .page-link::after {
      content: none;
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <!-- Filter Card -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter mr-1"></i>Filter Aktivitas
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('reports.aktivitas-pengguna') }}">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>User</label>
                <select name="user_id" class="form-control">
                  <option value="all">Semua User</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                      {{ $user->name }} ({{ $user->isAdmin() ? 'Admin' : 'Verifikator' }})
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Aksi</label>
                <select name="action" class="form-control">
                  <option value="all">Semua Aksi</option>
                  @foreach ($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                      {{ ucfirst($action) }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Dokumen</label>
                <select name="document_id" class="form-control">
                  <option value="">Semua Dokumen</option>
                  @foreach ($documents as $doc)
                    <option value="{{ $doc->id }}" {{ request('document_id') == $doc->id ? 'selected' : '' }}>
                      {{ $doc->nama_nasabah }} - {{ $doc->no_rekening }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group" style="padding-top: 30px;">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('reports.aktivitas-pengguna') }}" class="btn btn-secondary">
                  <i class="fas fa-redo"></i> Reset
                </a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mt-3">
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-history"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Aktivitas</span>
            <span class="info-box-number">{{ $activities->total() }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-upload"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Upload</span>
            <span class="info-box-number">
              {{ $activities->where('action', 'upload')->count() }}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-check-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Verifikasi</span>
            <span class="info-box-number">
              {{ $activities->whereIn('action', ['verify', 'reject'])->count() }}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-download"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Download</span>
            <span class="info-box-number">
              {{ $activities->where('action', 'download')->count() }}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-secondary"><i class="fas fa-sign-in-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Login</span>
            <span class="info-box-number">
              {{ $activities->where('action', 'login')->count() }}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="fas fa-user-clock"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">User Aktif</span>
            <span class="info-box-number">
              {{ $users->where('last_login_at', '>=', now()->subDay())->count() }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Table -->
    <div class="card mt-3">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
          <i class="fas fa-history mr-2"></i>Log Aktivitas
        </h3>
        <div class="card-tools">
          <a href="{{ route('reports.aktivitas-pengguna.pdf', array_merge(request()->all(), ['preview' => 1])) }}"
            class="btn btn-light btn-sm mr-2" target="_blank">
            <i class="fas fa-eye mr-1"></i> Preview PDF
          </a>
          <a href="{{ route('reports.aktivitas-pengguna.pdf', request()->all()) }}" class="btn btn-light btn-sm">
            <i class="fas fa-download mr-1"></i> Download PDF
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        @if ($activities->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Waktu</th>
                  <th>User</th>
                  <th>Aksi</th>
                  <th>Deskripsi</th>
                  <th>Dokumen</th>
                  <th>IP Address</th>
                  <th>Browser</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($activities as $activity)
                  <tr>
                    <td class="text-center">
                      {{ $loop->iteration + $activities->perPage() * ($activities->currentPage() - 1) }}</td>
                    <td>
                      <small>{{ $activity->created_at->format('d/m/Y') }}</small><br>
                      <small class="text-muted">{{ $activity->created_at->format('H:i:s') }}</small>
                    </td>
                    <td>
                      @if ($activity->user)
                        <strong>{{ $activity->user->name }}</strong><br>
                        <small class="text-muted">
                          {{ $activity->user->isAdmin() ? 'Admin' : 'Verifikator' }}
                        </small>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>
                      @php
                        $badgeColors = [
                            'upload' => 'success',
                            'download' => 'info',
                            'verify' => 'primary',
                            'reject' => 'danger',
                            'edit' => 'warning',
                            'delete' => 'dark',
                            'login' => 'secondary',
                            'logout' => 'secondary',
                            'login_failed' => 'danger',
                        ];
                        $color = $badgeColors[$activity->action] ?? 'secondary';
                      @endphp
                      <span class="badge badge-{{ $color }}">
                        {{ strtoupper($activity->action) }}
                      </span>
                    </td>
                    <td>{{ $activity->description }}</td>
                    <td>
                      @if ($activity->document)
                        <small>
                          <strong>{{ $activity->document->nama_nasabah }}</strong><br>
                          {{ $activity->document->no_rekening }}
                        </small>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>
                      <small class="text-muted">{{ $activity->ip_address }}</small>
                    </td>
                    <td>
                      <small class="text-muted" title="{{ $activity->user_agent }}">
                        {{ Str::limit($activity->user_agent, 30) }}
                      </small>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="row align-items-center">
              <div class="col-md-6">
                <small class="text-muted">
                  Menampilkan {{ $activities->firstItem() }} - {{ $activities->lastItem() }} dari
                  {{ $activities->total() }} aktivitas
                </small>
              </div>
              <div class="col-md-6">
                <div class="float-right">
                  {{ $activities->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="text-center py-5">
            <i class="fas fa-history fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada aktivitas</h5>
            <p class="text-muted">Tidak ditemukan data aktivitas dengan filter yang dipilih</p>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      // Initialize tooltips
      $('[title]').tooltip();
    });
  </script>
@endsection
