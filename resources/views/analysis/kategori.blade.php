@extends('layouts.app')

@section('title', 'Analisis per Kategori Kredit')
@section('page-title', 'Analisis Kategori Kredit')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Analisis Kategori</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-2"></i>
              Analisis Detail per Kategori Kredit
            </h3>
          </div>
          <div class="card-body">
            <!-- Statistik Keseluruhan -->
            <div class="row">
              @foreach ($kategoriStats as $stat)
                <div class="col-md-4">
                  <div class="info-box">
                    <span class="info-box-icon bg-info">
                      <i
                        class="fas fa-{{ str_contains($stat->kategori_kredit, 'KUR')
                            ? 'store'
                            : (str_contains($stat->kategori_kredit, 'KPR')
                                ? 'home'
                                : (str_contains($stat->kategori_kredit, 'KKB')
                                    ? 'car'
                                    : 'file')) }}"></i>
                    </span>
                    <div class="info-box-content">
                      <span class="info-box-text">{{ $stat->kategori_kredit }}</span>
                      <span class="info-box-number">{{ $stat->total_dokumen }} dokumen</span>
                      <div class="progress">
                        <div class="progress-bar" style="width: {{ ($stat->verified / $stat->total_dokumen) * 100 }}%"></div>
                      </div>
                      <span class="progress-description">
                        {{ $stat->verified }} verified |
                        Rp {{ number_format($stat->rata_nominal, 0, ',', '.') }} rata-rata
                      </span>
                      <a href="?kategori={{ urlencode($stat->kategori_kredit) }}" class="small-box-footer">
                        Lihat detail <i class="fas fa-arrow-circle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- Detail Kategori (jika dipilih) -->
            @if ($selectedKategori)
              <div class="row mt-4">
                <div class="col-md-12">
                  <div class="card card-default">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Detail Kategori: <strong>{{ $selectedKategori }}</strong>
                      </h3>
                    </div>
                    <div class="card-body">
                      @if ($detailKategori->count() > 0)
                        <div class="table-responsive">
                          <table class="table table-bordered">
                            <thead class="bg-light">
                              <tr>
                                <th>Jenis Bunga</th>
                                <th>Status Riwayat</th>
                                <th>Jumlah</th>
                                <th>Bunga (Min-Max)</th>
                                <th>Nominal (Min-Max)</th>
                                <th>Tenor (Min-Max)</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($detailKategori as $detail)
                                <tr>
                                  <td>
                                    <span
                                      class="badge {{ $detail->jenis_bunga == 'flat' ? 'badge-primary' : 'badge-info' }}">
                                      {{ $detail->jenis_bunga ?? '-' }}
                                    </span>
                                  </td>
                                  <td>
                                    @if ($detail->status_riwayat == 'bersih')
                                      <span class="badge badge-success">Bersih</span>
                                    @elseif($detail->status_riwayat == 'pernah_telat')
                                      <span class="badge badge-warning">Pernah Telat</span>
                                    @else
                                      <span class="badge badge-danger">Bermasalah</span>
                                    @endif
                                  </td>
                                  <td>{{ $detail->jumlah }}</td>
                                  <td>
                                    @if ($detail->bunga_min)
                                      {{ $detail->bunga_min }}% - {{ $detail->bunga_max }}%
                                    @else
                                      -
                                    @endif
                                  </td>
                                  <td>
                                    @if ($detail->nominal_min)
                                      Rp {{ number_format($detail->nominal_min, 0, ',', '.') }}<br>
                                      s/d<br>
                                      Rp {{ number_format($detail->nominal_max, 0, ',', '.') }}
                                    @else
                                      -
                                    @endif
                                  </td>
                                  <td>
                                    @if ($detail->tenor_min)
                                      {{ $detail->tenor_min }} - {{ $detail->tenor_max }} bulan
                                    @else
                                      -
                                    @endif
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      @else
                        <div class="alert alert-warning">
                          <i class="fas fa-exclamation-triangle mr-2"></i>
                          Tidak ada data detail untuk kategori ini.
                        </div>
                      @endif

                      <!-- Tombol Back -->
                      <a href="{{ route('analysis.kategori') }}" class="btn btn-default mt-3">
                        <i class="fas fa-arrow-left"></i> Kembali ke Semua Kategori
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @else
              <!-- Panduan -->
              <div class="alert alert-info mt-4">
                <h5><i class="fas fa-lightbulb"></i> Cara Menggunakan Analisis Kategori</h5>
                <ul class="mb-0">
                  <li>Klik <strong>"Lihat detail"</strong> pada kartu kategori untuk melihat informasi spesifik</li>
                  <li>Informasi yang ditampilkan: jenis bunga, range nominal, tenor, dan status riwayat</li>
                  <li>Data ini berguna untuk menentukan kebijakan kredit per kategori</li>
                </ul>
              </div>
            @endif

            <!-- Ringkasan -->
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="card card-success">
                  <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i> Ringkasan Statistik</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <table class="table table-sm">
                          <tr>
                            <th>Total Kategori</th>
                            <td>{{ $kategoriStats->count() }}</td>
                          </tr>
                          <tr>
                            <th>Total Dokumen</th>
                            <td>{{ $kategoriStats->sum('total_dokumen') }}</td>
                          </tr>
                          <tr>
                            <th>Total Verified</th>
                            <td>{{ $kategoriStats->sum('verified') }}</td>
                          </tr>
                          <tr>
                            <th>Total Riwayat Bersih</th>
                            <td>{{ $kategoriStats->sum('bersih') }}</td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-sm">
                          <tr>
                            <th>Rata-rata Nominal</th>
                            <td>Rp {{ number_format($kategoriStats->avg('rata_nominal'), 0, ',', '.') }}</td>
                          </tr>
                          <tr>
                            <th>Rata-rata Bunga</th>
                            <td>{{ number_format($kategoriStats->avg('rata_bunga'), 2) }}%</td>
                          </tr>
                          <tr>
                            <th>Rata-rata Tenor</th>
                            <td>{{ number_format($kategoriStats->avg('rata_tenor'), 1) }} bulan</td>
                          </tr>
                          <tr>
                            <th>Kategori Terbanyak</th>
                            <td>{{ $kategoriStats->first()->kategori_kredit ?? '-' }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
