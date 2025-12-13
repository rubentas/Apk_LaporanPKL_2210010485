@extends('layouts.app')

@section('title', 'Laporan Dokumen Per Kategori Kredit')
@section('page-title', 'Laporan Dokumen Per Kategori Kredit')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Laporan</a></li>
  <li class="breadcrumb-item active">Per Kategori Kredit</li>
@endsection

@section('content')
  <div class="container-fluid">

    {{-- Alert Messages --}}
    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-filter mr-1"></i>
              Laporan Dokumen Berdasarkan Kategori Kredit
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

            <!-- Filter Form -->
            <form method="GET" action="{{ route('reports.dokumen-per-kategori') }}" class="mb-4">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Pilih Kategori (Opsional)</label>
                    <select name="kategori" class="form-control" id="kategoriSelect">
                      <option value="">-- Semua Kategori --</option>
                      @foreach ($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                          {{ $label }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter mr-1"></i> Filter
                      </button>
                      <a href="{{ route('reports.dokumen-per-kategori') }}" class="btn btn-secondary">
                        <i class="fas fa-sync mr-1"></i> Reset
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 text-right">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                      <a href="{{ route('reports.dokumen-per-kategori.pdf', array_merge(request()->all(), ['preview' => 1])) }}"
                        target="_blank" class="btn btn-success" title="Preview PDF di tab baru">
                        <i class="fas fa-eye mr-1"></i> Preview PDF
                      </a>
                      <a href="{{ route('reports.dokumen-per-kategori.pdf', request()->all()) }}" class="btn btn-danger"
                        title="Download PDF">
                        <i class="fas fa-download mr-1"></i> Download PDF
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </form>

            <!-- Summary Cards -->
            <div class="row mb-4">
              <div class="col-md-3 col-sm-6">
                <div class="info-box bg-info">
                  <span class="info-box-icon"><i class="fas fa-layer-group"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Kategori</span>
                    <span class="info-box-number">{{ $summary['total_categories'] }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="info-box bg-success">
                  <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Dokumen</span>
                    <span class="info-box-number">{{ number_format($summary['total_documents']) }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="info-box bg-warning">
                  <span class="info-box-icon"><i class="fas fa-chart-bar"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Rata-rata per Kategori</span>
                    <span class="info-box-number">{{ $summary['avg_docs_per_category'] }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="info-box bg-primary">
                  <span class="info-box-icon"><i class="fas fa-percentage"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tingkat Verifikasi</span>
                    <span class="info-box-number">
                      @php
                        $totalVerified = 0;
                        foreach ($reportData as $data) {
                            $totalVerified += $data['verified'];
                        }
                        $percentage =
                            $summary['total_documents'] > 0
                                ? round(($totalVerified / $summary['total_documents']) * 100, 1)
                                : 0;
                      @endphp
                      {{ $percentage }}%
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Main Table -->
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped" id="reportTable">
                <thead class="thead-dark">
                  <tr>
                    <th style="width: 50px;">No</th>
                    <th>Kategori Kredit</th>
                    <th class="text-center" style="width: 100px;">Total Dokumen</th>
                    <th class="text-center" style="width: 80px;">Pending</th>
                    <th class="text-center" style="width: 80px;">Verified</th>
                    <th class="text-center" style="width: 80px;">Rejected</th>
                    <th class="text-center" style="width: 80px;">Expired</th>
                    <th class="text-center" style="width: 120px;">Rata-rata Verifikasi</th>
                    <th style="width: 150px;">Persentase</th>
                    <th class="text-center" style="width: 80px;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($reportData as $key => $data)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <strong>{{ $data['label'] }}</strong>
                      </td>
                      <td class="text-center">
                        <span class="badge badge-primary badge-pill" style="font-size: 1.1em;">
                          {{ $data['total'] }}
                        </span>
                      </td>
                      <td class="text-center">
                        @if ($data['pending'] > 0)
                          <span class="badge badge-warning">{{ $data['pending'] }}</span>
                        @else
                          <span class="text-muted">0</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if ($data['verified'] > 0)
                          <span class="badge badge-success">{{ $data['verified'] }}</span>
                        @else
                          <span class="text-muted">0</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if ($data['rejected'] > 0)
                          <span class="badge badge-danger">{{ $data['rejected'] }}</span>
                        @else
                          <span class="text-muted">0</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if ($data['expired'] > 0)
                          <span class="badge badge-dark">{{ $data['expired'] }}</span>
                        @else
                          <span class="text-muted">0</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if ($data['avg_verification'] > 0)
                          <span class="text-info">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $data['avg_verification'] }} hari
                          </span>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        <div class="progress progress-sm mb-1">
                          <div class="progress-bar bg-success" style="width: {{ $data['percentage'] }}%">
                          </div>
                        </div>
                        <small class="text-center d-block">{{ $data['percentage'] }}%</small>
                      </td>
                      <td class="text-center">
                        <a href="{{ route('documents.index', ['kategori_kredit' => $key]) }}"
                          class="btn btn-sm btn-info" title="Lihat Dokumen Kategori {{ $data['label'] }}">
                          <i class="fas fa-eye"></i>
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="10" class="text-center text-muted py-4">
                        <i class="fas fa-exclamation-circle fa-2x mb-2"></i><br>
                        Tidak ada data dokumen untuk ditampilkan
                      </td>
                    </tr>
                  @endforelse
                </tbody>
                @if (count($reportData) > 0)
                  <tfoot class="bg-light">
                    <tr>
                      <th colspan="2" class="text-right">TOTAL:</th>
                      <th class="text-center">
                        <span class="badge badge-primary badge-pill">{{ $summary['total_documents'] }}</span>
                      </th>
                      <th class="text-center">
                        @php $totalPending = array_sum(array_column($reportData, 'pending')); @endphp
                        <span class="badge badge-warning">{{ $totalPending }}</span>
                      </th>
                      <th class="text-center">
                        <span class="badge badge-success">{{ $totalVerified }}</span>
                      </th>
                      <th class="text-center">
                        @php $totalRejected = array_sum(array_column($reportData, 'rejected')); @endphp
                        <span class="badge badge-danger">{{ $totalRejected }}</span>
                      </th>
                      <th class="text-center">
                        @php $totalExpired = array_sum(array_column($reportData, 'expired')); @endphp
                        <span class="badge badge-dark">{{ $totalExpired }}</span>
                      </th>
                      <th colspan="3"></th>
                    </tr>
                  </tfoot>
                @endif
              </table>
            </div>

            <!-- Insights Section -->
            @if (count($reportData) > 0)
              <div class="row mt-4">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header bg-warning">
                      <h3 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Kategori Perlu Perhatian
                      </h3>
                    </div>
                    <div class="card-body">
                      @php
                        $problemCategories = [];
                        foreach ($reportData as $key => $data) {
                            if (
                                $data['expired'] > 0 ||
                                $data['rejected'] > 5 ||
                                ($data['total'] > 0 && $data['pending'] / $data['total'] > 0.3)
                            ) {
                                $problemCategories[] = $data;
                            }
                        }
                      @endphp

                      @if (count($problemCategories) > 0)
                        <ul class="list-group">
                          @foreach ($problemCategories as $cat)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                              {{ $cat['label'] }}
                              <div>
                                @if ($cat['expired'] > 0)
                                  <span class="badge badge-dark mr-1">{{ $cat['expired'] }} expired</span>
                                @endif
                                @if ($cat['rejected'] > 5)
                                  <span class="badge badge-danger mr-1">{{ $cat['rejected'] }} rejected</span>
                                @endif
                                @if ($cat['total'] > 0 && $cat['pending'] / $cat['total'] > 0.3)
                                  <span class="badge badge-warning">{{ $cat['pending'] }} pending</span>
                                @endif
                              </div>
                            </li>
                          @endforeach
                        </ul>
                      @else
                        <p class="text-success mb-0">
                          <i class="fas fa-check-circle mr-1"></i>
                          Semua kategori dalam kondisi baik
                        </p>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header bg-success">
                      <h3 class="card-title mb-0">
                        <i class="fas fa-trophy mr-1"></i>
                        Top Performers
                      </h3>
                    </div>
                    <div class="card-body">
                      @php
                        $sortedByVerified = collect($reportData)->sortByDesc('verified')->take(3);
                      @endphp

                      @foreach ($sortedByVerified as $cat)
                        <div class="mb-3">
                          <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                              <strong>{{ $cat['label'] }}</strong><br>
                              <small class="text-muted">
                                {{ $cat['verified'] }} verified dari {{ $cat['total'] }} dokumen
                                ({{ $cat['total'] > 0 ? round(($cat['verified'] / $cat['total']) * 100) : 0 }}%)
                              </small>
                            </div>
                            <span class="badge badge-success badge-pill">
                              {{ $cat['total'] > 0 ? round(($cat['verified'] / $cat['total']) * 100) : 0 }}%
                            </span>
                          </div>
                          <div class="progress progress-xs">
                            <div class="progress-bar bg-success"
                              style="width: {{ $cat['total'] > 0 ? ($cat['verified'] / $cat['total']) * 100 : 0 }}%">
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
          <div class="card-footer">
            <small class="text-muted">
              <i class="fas fa-info-circle mr-1"></i>
              Data diambil dari dokumen yang terdaftar dalam sistem. Terakhir diperbarui:
              {{ now()->format('d/m/Y H:i') }} WIB
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      // Initialize DataTables jika ada data
      @if (count($reportData) > 0)
        $('#reportTable').DataTable({
          "paging": false,
          "searching": false,
          "ordering": true,
          "info": false,
          "responsive": true,
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
          }
        });
      @endif

      // Auto dismiss alerts after 5 seconds
      setTimeout(function() {
        $('.alert').fadeOut('slow');
      }, 5000);
    });
  </script>
@endsection

@section('styles')
  <style>
    .info-box-number {
      font-size: 1.5rem !important;
    }

    .progress-sm {
      height: 8px !important;
    }

    .table thead th {
      vertical-align: middle;
    }

    .badge-pill {
      padding: 0.35em 0.75em;
    }
  </style>
@endsection
