@extends('layouts.app')

@section('title', 'Laporan Statistik Dokumen')
@section('page-title', 'Laporan Statistik Dokumen')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="#">Laporan</a></li>
  <li class="breadcrumb-item active">Statistik Dokumen</li>
@endsection

@section('content')
  <div class="container-fluid">
    <!-- Header Card -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
          <i class="fas fa-chart-bar mr-2"></i>Laporan Statistik Dokumen
        </h3>
        <div class="card-tools">
          <a href="{{ route('reports.statistik-dokumen.pdf', ['preview' => 1]) }}" class="btn btn-info btn-sm mr-2"
            title="Preview PDF" target="_blank">
            <i class="fas fa-eye mr-1"></i> Preview PDF
          </a>

          <a href="{{ route('reports.statistik-dokumen.pdf') }}" class="btn btn-danger btn-sm" title="Download PDF">
            <i class="fas fa-file-pdf mr-1"></i> Download PDF
          </a>
        </div>
      </div>
      <div class="card-body">
        <p class="text-muted mb-0">
          <i class="fas fa-info-circle mr-1"></i>
          Laporan statistik keseluruhan dokumen administrasi kredit. Data diperbarui real-time.
        </p>
      </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mt-3">
      <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-file-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Dokumen</span>
            <span class="info-box-number">{{ number_format($stats->total) }}</span>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Pending</span>
            <span class="info-box-number">{{ number_format($stats->pending) }}</span>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Verified</span>
            <span class="info-box-number">{{ number_format($stats->verified) }}</span>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="fas fa-times-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Rejected</span>
            <span class="info-box-number">{{ number_format($stats->rejected) }}</span>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="info-box">
          <span class="info-box-icon bg-secondary"><i class="fas fa-calendar-times"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Expired</span>
            <span class="info-box-number">{{ number_format($stats->expired) }}</span>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Hampir Expired</span>
            <span class="info-box-number">{{ number_format($stats->expiring_soon) }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Distribusi Status Dokumen
            </h3>
          </div>
          <div class="card-body">
            <div style="position: relative; height: 300px;">
              <canvas id="statusChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-line mr-1"></i>
              Trend Bulanan (6 Bulan Terakhir)
            </h3>
          </div>
          <div class="card-body">
            <div style="position: relative; height: 300px;">
              <canvas id="monthlyChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Tables -->
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-star mr-1"></i>
              Top 5 Kategori Kredit
            </h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Rank</th>
                    <th>Kategori Kredit</th>
                    <th>Jumlah</th>
                    <th>Persentase</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($topKategori as $index => $kategori)
                    <tr>
                      <td class="text-center">
                        @if ($index == 0)
                          <span class="badge badge-warning">1</span>
                        @elseif($index == 1)
                          <span class="badge badge-secondary">2</span>
                        @elseif($index == 2)
                          <span class="badge badge-info">3</span>
                        @else
                          <span class="badge badge-light">{{ $index + 1 }}</span>
                        @endif
                      </td>
                      <td>{{ $kategori->kategori_kredit ?? 'Tidak Terkategori' }}</td>
                      <td class="text-right">{{ number_format($kategori->total) }}</td>
                      <td>
                        @php
                          $percentage = $stats->total > 0 ? ($kategori->total / $stats->total) * 100 : 0;
                        @endphp
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-primary" style="width: {{ min($percentage, 100) }}%">
                            <span class="progress-text">{{ number_format($percentage, 1) }}%</span>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-warning">
            <h3 class="card-title mb-0">
              <i class="fas fa-exclamation-triangle mr-1"></i>
              Dokumen Hampir Expired (30 Hari)
            </h3>
          </div>
          <div class="card-body">
            @if ($expiringSoon->count() > 0)
              <div class="table-responsive">
                <table class="table table-sm table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nasabah</th>
                      <th>No. Rekening</th>
                      <th>Expired Date</th>
                      <th>Sisa Hari</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($expiringSoon as $doc)
                      @php
                        $now = \Carbon\Carbon::now();
                        $expired = \Carbon\Carbon::parse($doc->expired_date);

                        // Hitung selisih hari (selalu positif)
                        $daysLeft = $now->diffInDays($expired, false);

                        // Tampilkan
                        if ($daysLeft < 0) {
                            $displayDays = 'Expired!';
                            $badgeColor = 'danger';
                        } elseif ($daysLeft == 0) {
                            $displayDays = 'Hari ini';
                            $badgeColor = 'warning';
                        } else {
                            $displayDays = round($daysLeft) . ' hari'; // BULATKAN
                            $badgeColor = $daysLeft <= 7 ? 'danger' : ($daysLeft <= 15 ? 'warning' : 'info');
                        }
                      @endphp
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                          <strong>{{ $doc->nama_nasabah }}</strong><br>
                          <small class="text-muted">{{ $doc->no_ktp }}</small>
                        </td>
                        <td>{{ $doc->no_rekening }}</td>
                        <td>{{ \Carbon\Carbon::parse($doc->expired_date)->format('d/m/Y') }}</td>
                        <td class="text-center">
                          <span class="badge badge-{{ $badgeColor }}">
                            {{ $displayDays }}
                          </span>
                        </td>
                        <td>{!! $doc->status_badge !!}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="text-center py-4">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="text-success">Tidak ada dokumen yang hampir expired</h5>
                <p class="text-muted">Semua dokumen dalam kondisi baik</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- Chart.js CDN (Latest version) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <script>
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Chart.js version:', Chart.version);

      // ========== PIE CHART (Status Dokumen) ==========
      const statusCtx = document.getElementById('statusChart');

      if (statusCtx) {
        new Chart(statusCtx, {
          type: 'doughnut',
          data: {
            labels: ['Pending', 'Verified', 'Rejected', 'Expired'],
            datasets: [{
              data: [
                {{ $stats->pending ?? 0 }},
                {{ $stats->verified ?? 0 }},
                {{ $stats->rejected ?? 0 }},
                {{ $stats->expired ?? 0 }}
              ],
              backgroundColor: [
                '#ffc107', // Kuning (Pending)
                '#28a745', // Hijau (Verified)
                '#dc3545', // Merah (Rejected)
                '#6c757d' // Abu (Expired)
              ],
              borderWidth: 2,
              borderColor: '#fff'
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  padding: 15,
                  font: {
                    size: 12
                  }
                }
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const label = context.label || '';
                    const value = context.parsed || 0;
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                    return label + ': ' + value + ' (' + percentage + '%)';
                  }
                }
              }
            }
          }
        });
        console.log('✅ Pie chart created');
      } else {
        console.error('❌ Canvas #statusChart not found');
      }

      // ========== BAR CHART (Monthly Trend) ==========
      const monthlyCtx = document.getElementById('monthlyChart');

      if (monthlyCtx) {
        @php
          $hasMonthlyData = isset($monthlyData) && $monthlyData->count() > 0;
        @endphp

        @if ($hasMonthlyData)
          new Chart(monthlyCtx, {
            type: 'bar',
            data: {
              labels: @json($monthlyData->pluck('month')->toArray()),
              datasets: [{
                  label: 'Total Dokumen',
                  data: @json($monthlyData->pluck('total')->toArray()),
                  backgroundColor: 'rgba(54, 162, 235, 0.7)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                },
                {
                  label: 'Terverifikasi',
                  data: @json($monthlyData->pluck('verified')->toArray()),
                  backgroundColor: 'rgba(75, 192, 192, 0.7)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 1
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    stepSize: 1,
                    precision: 0
                  },
                  title: {
                    display: true,
                    text: 'Jumlah Dokumen'
                  }
                },
                x: {
                  title: {
                    display: true,
                    text: 'Bulan'
                  }
                }
              },
              plugins: {
                legend: {
                  position: 'top',
                },
                tooltip: {
                  mode: 'index',
                  intersect: false,
                }
              }
            }
          });
          console.log('✅ Bar chart created');
        @else
          // Jika tidak ada data, tampilkan pesan
          monthlyCtx.parentElement.innerHTML = `
          <div class="text-center py-5">
            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada data bulanan</p>
          </div>
        `;
          console.log('⚠️ No monthly data available');
        @endif
      } else {
        console.error('❌ Canvas #monthlyChart not found');
      }
    });
  </script>
@endpush
