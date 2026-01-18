@extends('layouts.app')

@section('title', 'Rekomendasi Nasabah Berpotensi')
@section('page-title', 'Rekomendasi Nasabah Berpotensi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Rekomendasi Nasabah</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-user-check mr-2"></i>
              Daftar Nasabah Berpotensi untuk Kredit Baru
            </h3>
          </div>
          <div class="card-body">
            <!-- Statistik -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="info-box bg-success">
                  <span class="info-box-icon"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Nasabah Berpotensi</span>
                    <span class="info-box-number">{{ $totalNasabah }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="info-box bg-info">
                  <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Kredit Bersih</span>
                    <span class="info-box-number">Rp {{ number_format($totalKredit, 0, ',', '.') }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="info-box bg-warning">
                  <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Kriteria</span>
                    <span class="info-box-text">Riwayat Bersih + Kredit Selesai</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Filter -->
            <div class="row mb-3">
              <div class="col-md-12">
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title">Filter</h3>
                  </div>
                  <div class="card-body">
                    <form method="GET" action="{{ route('analysis.rekomendasi') }}" class="form-inline">
                      <div class="form-group mr-3">
                        <label for="kategori" class="mr-2">Kategori Kredit:</label>
                        <select name="kategori" id="kategori" class="form-control">
                          <option value="">Semua Kategori</option>
                          <option value="KUR (Kredit Usaha Rakyat)"
                            {{ request('kategori') == 'KUR (Kredit Usaha Rakyat)' ? 'selected' : '' }}>KUR</option>
                          <option value="KPR (Kredit Pemilikan Rumah)"
                            {{ request('kategori') == 'KPR (Kredit Pemilikan Rumah)' ? 'selected' : '' }}>KPR</option>
                          <option value="KKB (Kredit Kendaraan Bermotor)"
                            {{ request('kategori') == 'KKB (Kredit Kendaraan Bermotor)' ? 'selected' : '' }}>KKB</option>
                          <option value="Kredit Modal Kerja"
                            {{ request('kategori') == 'Kredit Modal Kerja' ? 'selected' : '' }}>Modal Kerja</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                      </button>
                      <a href="{{ route('analysis.rekomendasi') }}" class="btn btn-default ml-2">
                        <i class="fas fa-redo"></i> Reset
                      </a>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tabel Nasabah -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr class="bg-light">
                    <th>No</th>
                    <th>Nama Nasabah</th>
                    <th>No Rekening</th>
                    <th>No KTP</th>
                    <th>Kategori Kredit</th>
                    <th>Total Kredit</th>
                    <th>Total Nominal</th>
                    <th>Tahun Selesai</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($nasabah as $item)
                    <tr>
                      <td>{{ $loop->iteration + $nasabah->perPage() * ($nasabah->currentPage() - 1) }}</td>
                      <td><strong>{{ $item->nama_nasabah }}</strong></td>
                      <td><code>{{ $item->no_rekening }}</code></td>
                      <td>{{ $item->no_ktp }}</td>
                      <td>
                        <span class="badge badge-info">{{ $item->kategori_kredit }}</span>
                      </td>
                      <td>
                        <span class="badge badge-primary">{{ $item->total_kredit }} kredit</span>
                      </td>
                      <td>Rp {{ number_format($item->total_nominal, 0, ',', '.') }}</td>
                      <td>{{ $item->tahun_selesai_terakhir }}</td>
                      <td>
                        <a href="{{ route('documents.index', ['search' => $item->no_rekening]) }}"
                          class="btn btn-sm btn-info" title="Lihat Riwayat">
                          <i class="fas fa-history"></i>
                        </a>
                        <a href="{{ route('documents.create', ['nasabah' => $item->nama_nasabah, 'rekening' => $item->no_rekening]) }}"
                          class="btn btn-sm btn-success" title="Rekomendasikan Kredit Baru">
                          <i class="fas fa-plus-circle"></i>
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="9" class="text-center text-muted">
                        <i class="fas fa-user-slash fa-2x mb-2"></i><br>
                        Belum ada nasabah yang memenuhi kriteria
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
              {{ $nasabah->appends(request()->query())->links() }}
            </div>

            <!-- Catatan -->
            <div class="alert alert-info mt-3">
              <h5><i class="fas fa-info-circle"></i> Kriteria Rekomendasi</h5>
              <ul class="mb-0">
                <li>Status riwayat kredit: <strong>Bersih</strong> (tidak pernah bermasalah)</li>
                <li>Status dokumen: <strong>Verified</strong> (telah disetujui)</li>
                <li>Estimasi selesai kredit: <strong>Tahun ini atau sebelumnya</strong></li>
                <li>Nasabah dengan riwayat baik berpotensi mendapatkan kredit baru</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
