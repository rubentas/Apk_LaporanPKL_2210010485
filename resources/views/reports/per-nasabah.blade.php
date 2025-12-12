@extends('layouts.app')

@section('title', 'Laporan per Nasabah')
@section('page-title', 'Laporan per Nasabah')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="#">Laporan</a></li>
  <li class="breadcrumb-item active">Per Nasabah</li>
@endsection

@section('content')
  <div class="container-fluid">
    <!-- Filter Card -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter mr-1"></i>Filter Laporan
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('reports.per-nasabah') }}">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Nama Nasabah</label>
                <input type="text" name="search_nasabah" class="form-control" value="{{ request('search_nasabah') }}"
                  placeholder="Cari nama nasabah...">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Kategori Kredit</label>
                <select name="kategori_kredit" class="form-control">
                  <option value="">Semua Kategori</option>
                  @foreach ($kategoriOptions as $kategori)
                    <option value="{{ $kategori }}" {{ request('kategori_kredit') == $kategori ? 'selected' : '' }}>
                      {{ $kategori }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" style="padding-top: 30px;">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('reports.per-nasabah') }}" class="btn btn-secondary">
                  <i class="fas fa-redo"></i> Reset
                </a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mt-3">
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Nasabah</span>
            <span class="info-box-number">{{ count($nasabahData) }}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-file-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Dokumen</span>
            <span class="info-box-number">
              {{ array_sum(array_column($nasabahData, 'total_dokumen')) }}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Dokumen Verified</span>
            <span class="info-box-number">
              {{ array_sum(array_column($nasabahData, 'verified')) }}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Dokumen Pending</span>
            <span class="info-box-number">
              {{ array_sum(array_column($nasabahData, 'pending')) }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Issues Warning -->
    @php
      $problematicData = array_filter($nasabahData, function ($item) {
          return $item['has_issue'];
      });
    @endphp
    @if (count($problematicData) > 0)
      <div class="alert alert-warning alert-dismissible mt-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Data Bermasalah Ditemukan!</h5>
        Terdapat <strong>{{ count($problematicData) }} nasabah</strong> dengan NIK KTP yang terdaftar untuk beberapa nama
        berbeda.
        Ini mungkin data duplikat yang perlu diverifikasi.
        <ul class="mt-2 mb-0">
          @foreach (array_slice($problematicData, 0, 3) as $problem)
            <li>NIK <strong>{{ $problem['no_ktp'] }}</strong>: {{ implode(', ', $problem['all_names']) }}</li>
          @endforeach
          @if (count($problematicData) > 3)
            <li>... dan {{ count($problematicData) - 3 }} data bermasalah lainnya</li>
          @endif
        </ul>
      </div>
    @endif

    <!-- Main Content -->
    <div class="card mt-3">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
          <i class="fas fa-user-friends mr-2"></i>Data Nasabah
        </h3>
        <div class="card-tools">
          <span class="badge badge-light">
            {{ count($nasabahData) }} Nasabah
          </span>
          @if (count($problematicData) > 0)
            <span class="badge badge-warning ml-2">
              <i class="fas fa-exclamation-triangle"></i> {{ count($problematicData) }} Bermasalah
            </span>
          @endif
        </div>
      </div>
      <div class="card-body p-0">
        @if (count($nasabahData) > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nasabah</th>
                  <th>Kontak</th>
                  <th>Statistik Dokumen</th>
                  <th>Dokumen Terbaru</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($nasabahData as $index => $nasabah)
                  <tr class="{{ $nasabah['has_issue'] ? 'table-warning' : '' }}">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                      <strong class="d-block">{{ $nasabah['nama_nasabah'] }}</strong>
                      @if ($nasabah['has_issue'])
                        <span class="badge badge-danger small mt-1" title="{{ $nasabah['issue_message'] }}"
                          data-toggle="tooltip">
                          <i class="fas fa-exclamation-triangle"></i> Data Bermasalah
                        </span>
                      @endif
                      <small class="text-muted d-block">
                        <i class="fas fa-credit-card mr-1"></i>{{ $nasabah['no_rekening'] }}
                      </small>
                      <small class="text-muted d-block">
                        <i class="fas fa-id-card mr-1"></i>{{ $nasabah['no_ktp'] }}
                      </small>
                      @if ($nasabah['all_names'] && count($nasabah['all_names']) > 1)
                        <small class="text-danger d-block mt-1">
                          <i class="fas fa-info-circle mr-1"></i>
                          Juga terdaftar sebagai: {{ implode(', ', array_slice($nasabah['all_names'], 1)) }}
                        </small>
                      @endif
                      @if ($nasabah['kategori_kredit'])
                        <span class="badge badge-info mt-1">
                          {{ $nasabah['kategori_kredit'] }}
                        </span>
                      @endif
                    </td>
                    <td>
                      <small class="d-block">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ Str::limit($nasabah['alamat'], 30) }}
                      </small>
                      <small class="d-block">
                        <i class="fas fa-phone mr-1"></i>{{ $nasabah['telepon'] }}
                      </small>
                    </td>
                    <td>
                      <div class="small">
                        <span class="badge badge-primary">Total: {{ $nasabah['total_dokumen'] }}</span>
                        <span class="badge badge-warning">Pending: {{ $nasabah['pending'] }}</span>
                        <span class="badge badge-success">Verified: {{ $nasabah['verified'] }}</span>
                        <span class="badge badge-danger">Rejected: {{ $nasabah['rejected'] }}</span>
                        <span class="badge badge-secondary">Expired: {{ $nasabah['expired'] }}</span>
                      </div>
                      @if ($nasabah['total_dokumen'] > 0)
                        <div class="progress mt-1" style="height: 5px;">
                          @php
                            $total = $nasabah['total_dokumen'];
                            $pendingWidth = ($nasabah['pending'] / $total) * 100;
                            $verifiedWidth = ($nasabah['verified'] / $total) * 100;
                            $rejectedWidth = ($nasabah['rejected'] / $total) * 100;
                          @endphp
                          <div class="progress-bar bg-warning" style="width: {{ $pendingWidth }}%"></div>
                          <div class="progress-bar bg-success" style="width: {{ $verifiedWidth }}%"></div>
                          <div class="progress-bar bg-danger" style="width: {{ $rejectedWidth }}%"></div>
                        </div>
                      @endif
                    </td>
                    <td>
                      @if ($nasabah['dokumen']->count() > 0)
                        <ul class="list-unstyled mb-0">
                          @foreach ($nasabah['dokumen']->take(3) as $doc)
                            <li class="mb-1">
                              <small>
                                <i class="fas {{ $doc->document_type_icon }} mr-1"></i>
                                {{ $doc->jenis_dokumen }}
                                <span
                                  class="badge badge-sm {{ $doc->status == 'verified' ? 'badge-success' : ($doc->status == 'pending' ? 'badge-warning' : 'badge-danger') }}">
                                  {{ $doc->status }}
                                </span>
                                <br>
                                <small class="text-muted">
                                  {{ $doc->created_at->format('d/m/Y') }}
                                </small>
                              </small>
                            </li>
                          @endforeach
                        </ul>
                        @if ($nasabah['dokumen']->count() > 3)
                          <small class="text-muted">
                            + {{ $nasabah['dokumen']->count() - 3 }} dokumen lainnya
                          </small>
                        @endif
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('reports.detail-nasabah', $nasabah['no_rekening']) }}"
                        class="btn btn-sm btn-info" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="{{ route('reports.per-nasabah.pdf', ['nasabah' => $nasabah['no_rekening'], 'preview' => 1]) }}"
                        class="btn btn-sm btn-danger" title="Export PDF" target="_blank">
                        <i class="fas fa-file-pdf"></i>
                      </a>
                      @if ($nasabah['has_issue'])
                        <button class="btn btn-sm btn-warning" title="Data Bermasalah" disabled>
                          <i class="fas fa-exclamation"></i>
                        </button>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada data nasabah</h5>
            <p class="text-muted">Tidak ditemukan data nasabah dengan filter yang dipilih</p>
          </div>
        @endif
      </div>
      @if (count($nasabahData) > 0)
        <div class="card-footer">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">
                Menampilkan {{ count($nasabahData) }} nasabah
                @if (count($problematicData) > 0)
                  ({{ count($problematicData) }} data bermasalah)
                @endif
              </small>
            </div>
            <div class="col-md-6 text-right">
              <a href="{{ route('reports.per-nasabah.pdf', ['preview' => 1]) }}" class="btn btn-danger mr-2"
                target="_blank">
                <i class="fas fa-eye mr-1"></i> Preview Semua PDF
              </a>
              <a href="{{ route('reports.per-nasabah.pdf') }}" class="btn btn-success">
                <i class="fas fa-download mr-1"></i> Download Semua PDF
              </a>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      // Initialize tooltips
      $('[data-toggle="tooltip"]').tooltip();

      // Auto-close alerts after 10 seconds
      setTimeout(function() {
        $('.alert').alert('close');
      }, 10000);
    });
  </script>
@endsection
