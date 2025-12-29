@extends('layouts.app')

@section('title', 'Laporan Kredit Akan Selesai')
@section('page-title', 'Laporan Kredit Akan Selesai')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Laporan</a></li>
  <li class="breadcrumb-item active">Kredit Akan Selesai</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-calendar-check mr-2"></i>
              Laporan Kredit Akan Selesai ({{ date('Y') }} - {{ date('Y') + 1 }})
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

            <!-- Filter Form -->
            <form method="GET" action="{{ route('reports.kredit-akan-selesai') }}" class="mb-4">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Kategori Kredit</label>
                    <select name="kategori" class="form-control">
                      <option value="">Semua Kategori</option>
                      @foreach ($kategoriOptions as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                          {{ $kategori }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tahun Estimasi Selesai</label>
                    <select name="tahun" class="form-control">
                      <option value="">Semua Tahun</option>
                      <option value="{{ date('Y') }}" {{ request('tahun') == date('Y') ? 'selected' : '' }}>
                        Tahun {{ date('Y') }}
                      </option>
                      <option value="{{ date('Y') + 1 }}" {{ request('tahun') == date('Y') + 1 ? 'selected' : '' }}>
                        Tahun {{ date('Y') + 1 }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                      </button>
                      <a href="{{ route('reports.kredit-akan-selesai') }}" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 text-right">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                      <a href="{{ route('reports.kredit-akan-selesai.pdf', array_merge(request()->all(), ['preview' => 1])) }}"
                        target="_blank" class="btn btn-success">
                        <i class="fas fa-eye"></i> Preview PDF
                      </a>
                      <a href="{{ route('reports.kredit-akan-selesai.pdf', request()->all()) }}" class="btn btn-danger">
                        <i class="fas fa-download"></i> Download PDF
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </form>

            <!-- Statistik -->
            <div class="row mb-4">
              <div class="col-md-3">
                <div class="info-box bg-info">
                  <span class="info-box-icon"><i class="fas fa-file-contract"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Kredit</span>
                    <span class="info-box-number">{{ $stats['total'] }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box bg-success">
                  <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Selesai {{ date('Y') }}</span>
                    <span class="info-box-number">{{ $stats['tahun_ini'] }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box bg-warning">
                  <span class="info-box-icon"><i class="fas fa-calendar-plus"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Selesai {{ date('Y') + 1 }}</span>
                    <span class="info-box-number">{{ $stats['tahun_depan'] }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box bg-primary">
                  <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Nominal</span>
                    <span class="info-box-number">Rp {{ number_format($stats['total_nominal'], 0, ',', '.') }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tabel -->
            @if ($documents->count() > 0)
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="bg-light">
                    <tr>
                      <th>No</th>
                      <th>Nasabah</th>
                      <th>No Rekening</th>
                      <th>Kategori</th>
                      <th>Nominal Kredit</th>
                      <th>Tahun Pengajuan</th>
                      <th>Tenor</th>
                      <th>Estimasi Selesai</th>
                      <th>Sisa Waktu</th>
                      <th>Status Riwayat</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($documents as $doc)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $doc->nama_nasabah }}</strong></td>
                        <td><code>{{ $doc->no_rekening }}</code></td>
                        <td>{{ $doc->kategori_kredit }}</td>
                        <td>Rp {{ number_format($doc->nominal_kredit, 0, ',', '.') }}</td>
                        <td>{{ $doc->tahun_pengajuan }}</td>
                        <td>{{ $doc->tenor }} bulan</td>
                        <td>
                          <span
                            class="badge {{ $doc->estimasi_selesai == date('Y') ? 'badge-success' : 'badge-warning' }}">
                            {{ $doc->estimasi_selesai }}
                          </span>
                        </td>
                        <td>
                          @php
                            $sisaTahun = $doc->estimasi_selesai - date('Y');
                          @endphp
                          @if ($sisaTahun == 0)
                            <span class="badge badge-danger">Tahun ini</span>
                          @else
                            <span class="badge badge-info">{{ $sisaTahun }} tahun lagi</span>
                          @endif
                        </td>
                        <td>
                          @if ($doc->status_riwayat == 'bersih')
                            <span class="badge badge-success">Bersih</span>
                          @elseif($doc->status_riwayat == 'pernah_telat')
                            <span class="badge badge-warning">Pernah Telat</span>
                          @else
                            <span class="badge badge-danger">Bermasalah</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                Tidak ada data kredit yang akan selesai dalam periode {{ date('Y') }} - {{ date('Y') + 1 }}
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
