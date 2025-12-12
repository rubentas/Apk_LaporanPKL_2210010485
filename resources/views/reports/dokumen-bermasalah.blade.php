@extends('layouts.app')

@section('title', 'Laporan Dokumen Bermasalah')
@section('page-title', 'Laporan Dokumen Bermasalah')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="#">Laporan</a></li>
  <li class="breadcrumb-item active">Dokumen Bermasalah</li>
@endsection

@section('content')
  <div class="container-fluid">
    <!-- Summary Cards -->
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="info-box bg-danger">
          <span class="info-box-icon"><i class="fas fa-calendar-times"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Dokumen Expired</span>
            <span class="info-box-number">{{ $summary['expired'] }}</span>
            <div class="progress">
              <div class="progress-bar"
                style="width: {{ $summary['total'] > 0 ? ($summary['expired'] / $summary['total']) * 100 : 0 }}%"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Dokumen Ditolak</span>
            <span class="info-box-number">{{ $summary['rejected'] }}</span>
            <div class="progress">
              <div class="progress-bar"
                style="width: {{ $summary['total'] > 0 ? ($summary['rejected'] / $summary['total']) * 100 : 0 }}%"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="info-box bg-info">
          <span class="info-box-icon"><i class="fas fa-clock"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Pending Lama (>7 hari)</span>
            <span class="info-box-number">{{ $summary['pending_lama'] }}</span>
            <div class="progress">
              <div class="progress-bar"
                style="width: {{ $summary['total'] > 0 ? ($summary['pending_lama'] / $summary['total']) * 100 : 0 }}%">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="info-box bg-purple">
          <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">NIK Duplikat</span>
            <span class="info-box-number">{{ $summary['nik_duplikat'] }}</span>
            <div class="progress">
              <div class="progress-bar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-3">
      <div class="col-12">
        <div class="card">
          <div class="card-body text-center">
            <a href="{{ route('reports.dokumen-bermasalah.pdf', ['preview' => 1]) }}" class="btn btn-danger mr-2"
              target="_blank">
              <i class="fas fa-eye mr-1"></i> Preview PDF
            </a>
            <a href="{{ route('reports.dokumen-bermasalah.pdf') }}" class="btn btn-success">
              <i class="fas fa-download mr-1"></i> Download PDF
            </a>
            <button class="btn btn-info ml-2" data-toggle="modal" data-target="#infoModal">
              <i class="fas fa-info-circle mr-1"></i> Info Laporan
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Dokumen Expired -->
    @if ($expired->count() > 0)
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-calendar-times mr-1"></i>
            Dokumen Expired ({{ $expired->count() }})
          </h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nasabah</th>
                  <th>Jenis Dokumen</th>
                  <th>Expired Date</th>
                  <th>Status</th>
                  <th>Upload Date</th>
                  <th>Verifikator</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($expired as $doc)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <strong>{{ $doc->nama_nasabah }}</strong><br>
                      <small>{{ $doc->no_rekening }}</small>
                    </td>
                    <td>{{ $doc->jenis_dokumen }}</td>
                    <td>
                      <span class="badge badge-danger">
                        {{ $doc->expired_date->format('d/m/Y') }}
                      </span>
                    </td>
                    <td>{!! $doc->status_badge !!}</td>
                    <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                    <td>
                      @if ($doc->verifier)
                        {{ $doc->verifier->name }}
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endif

    <!-- Dokumen Rejected -->
    @if ($rejected->count() > 0)
      <div class="card card-warning mt-3">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-times-circle mr-1"></i>
            Dokumen Ditolak ({{ $rejected->count() }})
          </h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nasabah</th>
                  <th>Jenis Dokumen</th>
                  <th>Alasan Penolakan</th>
                  <th>Tanggal Ditolak</th>
                  <th>Verifikator</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rejected as $doc)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <strong>{{ $doc->nama_nasabah }}</strong><br>
                      <small>{{ $doc->no_rekening }}</small>
                    </td>
                    <td>{{ $doc->jenis_dokumen }}</td>
                    <td>
                      @if ($doc->catatan)
                        <span class="text-danger">{{ Str::limit($doc->catatan, 50) }}</span>
                      @else
                        <span class="text-muted">Tidak ada catatan</span>
                      @endif
                    </td>
                    <td>{{ $doc->verified_at ? $doc->verified_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                      @if ($doc->verifier)
                        {{ $doc->verifier->name }}
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endif

    <!-- Pending Lama -->
    @if ($pendingLama->count() > 0)
      <div class="card card-info mt-3">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-clock mr-1"></i>
            Dokumen Pending Lama >7 Hari ({{ $pendingLama->count() }})
          </h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nasabah</th>
                  <th>Jenis Dokumen</th>
                  <th>Tanggal Upload</th>
                  <th>Lama Pending</th>
                  <th>Uploader</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pendingLama as $doc)
                  @php
                    $daysPending = $doc->created_at->diffInDays(now());
                  @endphp
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <strong>{{ $doc->nama_nasabah }}</strong><br>
                      <small>{{ $doc->no_rekening }}</small>
                    </td>
                    <td>{{ $doc->jenis_dokumen }}</td>
                    <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                    <td>
                      <span class="badge badge-warning">{{ $daysPending }} hari</span>
                    </td>
                    <td>
                      @if ($doc->uploader)
                        {{ $doc->uploader->name }}
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('documents.show', $doc) }}" class="btn btn-xs btn-info">
                        <i class="fas fa-eye"></i>
                      </a>
                      @if (auth()->user()->isAdmin() || auth()->user()->id == $doc->uploaded_by)
                        <a href="{{ route('documents.edit', $doc) }}" class="btn btn-xs btn-warning">
                          <i class="fas fa-edit"></i>
                        </a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endif

    <!-- NIK Duplikat -->
    @if (count($nikDuplikat) > 0)
      <div class="card card-purple mt-3">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-exclamation-triangle mr-1"></i>
            Data NIK KTP Duplikat ({{ count($nikDuplikat) }})
          </h3>
        </div>
        <div class="card-body">
          <!-- Keterangan -->
          <div class="alert alert-info">
            <i class="fas fa-info-circle mr-1"></i>
            <strong>Keterangan:</strong> NIK KTP yang terdaftar untuk beberapa nama berbeda.
            Ini adalah <strong>potensi masalah data integrity</strong> yang perlu diverifikasi.
            Meskipun NIK duplikat, dokumen-dokumen ini mungkin dalam status baik (tidak expired/rejected).
          </div>

          @foreach ($nikDuplikat as $index => $data)
            <div class="alert alert-warning">
              <h5>
                <i class="fas fa-id-card mr-1"></i>
                NIK: <strong>{{ $data['nik'] }}</strong>
                <span class="badge badge-danger ml-2">{{ $data['count'] }} dokumen</span>
              </h5>
              <p class="mb-1">
                <strong>Nama yang terdaftar:</strong> {{ implode(', ', $data['names']) }}
              </p>
              <p class="mb-1">
                <strong>Status dokumen:</strong>
                @php
                  $statusCounts = [];
                  foreach ($data['documents'] as $doc) {
                      $statusCounts[$doc->status] = ($statusCounts[$doc->status] ?? 0) + 1;
                  }
                  $statusText = [];
                  foreach ($statusCounts as $status => $count) {
                      $statusText[] = "$count " . ucfirst($status);
                  }
                @endphp
                {{ implode(', ', $statusText) }}
              </p>
              <p class="mb-2">
                <strong>Kemungkinan:</strong> Data duplikat atau kesalahan input NIK
              </p>
              <div class="mt-2">
                <a href="{{ route('reports.per-nasabah') }}?search_nasabah={{ $data['names'][0] }}"
                  class="btn btn-xs btn-info">
                  <i class="fas fa-search"></i> Cek Data
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- Empty State -->
    @if ($summary['total'] == 0 && count($nikDuplikat) == 0)
      <div class="card mt-3">
        <div class="card-body text-center py-5">
          <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
          <h3 class="text-success">Tidak Ada Dokumen Bermasalah</h3>
          <p class="text-muted">Semua dokumen dalam kondisi baik. Pertahankan!</p>
        </div>
      </div>
    @endif
  </div>

  <!-- Info Modal -->
  <div class="modal fade" id="infoModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-info-circle mr-1"></i> Informasi Laporan
          </h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>Laporan ini menampilkan dokumen-dokumen yang memerlukan perhatian khusus:</strong></p>
          <ul>
            <li><span class="text-danger">Dokumen Expired:</span> Sudah melewati tanggal expired</li>
            <li><span class="text-warning">Dokumen Ditolak:</span> Ditolak oleh verifikator</li>
            <li><span class="text-info">Pending Lama:</span> Belum diverifikasi >7 hari</li>
            <li><span class="text-purple">NIK Duplikat:</span> Satu NIK terdaftar untuk beberapa nama</li>
          </ul>
          <p class="mb-0"><small class="text-muted">Laporan ini diperbarui real-time berdasarkan data terbaru.</small>
          </p>
        </div>
      </div>
    </div>
  </div>

  <style>
    .card-purple {
      background-color: #6f42c1 !important;
      color: white;
    }

    .card-purple .card-header {
      background-color: #5a32a3;
      color: white;
    }

    .bg-purple {
      background-color: #6f42c1 !important;
    }
  </style>
@endsection
