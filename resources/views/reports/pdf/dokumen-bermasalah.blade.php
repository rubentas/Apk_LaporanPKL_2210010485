<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Dokumen Bermasalah - BRI</title>
  <style>
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 10px;
      line-height: 1.3;
    }

    .header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 3px solid #dc3545;
      padding-bottom: 10px;
    }

    .header h1 {
      margin: 0;
      color: #dc3545;
      font-size: 20px;
    }

    .header h2 {
      margin: 3px 0;
      color: #6c757d;
      font-size: 14px;
    }

    .summary-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 8px;
      margin: 15px 0;
    }

    .summary-box {
      text-align: center;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .summary-expired {
      background-color: #f8d7da;
      border-color: #f5c6cb;
    }

    .summary-rejected {
      background-color: #fff3cd;
      border-color: #ffeaa7;
    }

    .summary-pending {
      background-color: #d1ecf1;
      border-color: #bee5eb;
    }

    .summary-nik {
      background-color: #e2d9f3;
      border-color: #d6c8f0;
    }

    .summary-value {
      font-size: 20px;
      font-weight: bold;
      display: block;
    }

    .summary-expired .summary-value {
      color: #721c24;
    }

    .summary-rejected .summary-value {
      color: #856404;
    }

    .summary-pending .summary-value {
      color: #0c5460;
    }

    .summary-nik .summary-value {
      color: #4a3c6e;
    }

    .summary-label {
      font-size: 9px;
      text-transform: uppercase;
      display: block;
      margin-top: 3px;
    }

    .section {
      margin: 20px 0;
      page-break-inside: avoid;
    }

    .section-title {
      background-color: #f8f9fa;
      padding: 8px;
      border-left: 4px solid;
      margin-bottom: 10px;
      font-weight: bold;
      font-size: 12px;
    }

    .section-expired {
      border-left-color: #dc3545;
    }

    .section-rejected {
      border-left-color: #ffc107;
    }

    .section-pending {
      border-left-color: #17a2b8;
    }

    .section-nik {
      border-left-color: #6f42c1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
      font-size: 9px;
    }

    table th {
      background-color: #343a40;
      color: white;
      padding: 6px 8px;
      text-align: left;
    }

    table td {
      padding: 5px 6px;
      border-bottom: 1px solid #dee2e6;
    }

    .badge {
      padding: 2px 6px;
      border-radius: 3px;
      font-size: 8px;
      font-weight: bold;
    }

    .badge-expired {
      background-color: #dc3545;
      color: white;
    }

    .badge-rejected {
      background-color: #ffc107;
      color: black;
    }

    .badge-pending {
      background-color: #17a2b8;
      color: white;
    }

    .text-danger {
      color: #dc3545;
    }

    .text-warning {
      color: #856404;
    }

    .text-info {
      color: #0c5460;
    }

    .footer {
      margin-top: 30px;
      padding-top: 8px;
      border-top: 1px solid #ddd;
      font-size: 8px;
      color: #6c757d;
      text-align: right;
    }

    .page-break {
      page-break-before: always;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <h1>PT BANK RAKYAT INDONESIA (PERSERO) Tbk</h1>
    <h2>KC TANJUNG TABALONG</h2>
    <h3>LAPORAN DOKUMEN BERMASALAH</h3>
    <p>Periode: {{ date('d/m/Y') }}</p>
  </div>

  <!-- Summary -->
  <div class="summary-grid">
    <div class="summary-box summary-expired">
      <span class="summary-value">{{ $summary['expired'] }}</span>
      <span class="summary-label">Dokumen Expired</span>
    </div>
    <div class="summary-box summary-rejected">
      <span class="summary-value">{{ $summary['rejected'] }}</span>
      <span class="summary-label">Dokumen Ditolak</span>
    </div>
    <div class="summary-box summary-pending">
      <span class="summary-value">{{ $summary['pending_lama'] }}</span>
      <span class="summary-label">Pending >7 Hari</span>
    </div>
    <div class="summary-box summary-nik">
      <span class="summary-value">{{ $summary['nik_duplikat'] }}</span>
      <span class="summary-label">NIK Duplikat</span>
    </div>
  </div>

  <!-- Dokumen Expired -->
  @if ($expired->count() > 0)
    <div class="section">
      <div class="section-title section-expired">
        DOKUMEN EXPIRED ({{ $expired->count() }})
      </div>
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Nasabah</th>
            <th>No. Rekening</th>
            <th>Jenis Dokumen</th>
            <th>Expired Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($expired as $doc)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $doc->nama_nasabah }}</td>
              <td>{{ $doc->no_rekening }}</td>
              <td>{{ $doc->jenis_dokumen }}</td>
              <td>
                <span class="badge badge-expired">
                  {{ $doc->expired_date->format('d/m/Y') }}
                </span>
              </td>
              <td class="text-danger">{{ strtoupper($doc->status) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <!-- Dokumen Rejected -->
  @if ($rejected->count() > 0)
    <div class="section">
      <div class="section-title section-rejected">
        DOKUMEN DITOLAK ({{ $rejected->count() }})
      </div>
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Nasabah</th>
            <th>No. Rekening</th>
            <th>Jenis Dokumen</th>
            <th>Alasan Penolakan</th>
            <th>Tanggal Ditolak</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rejected as $doc)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $doc->nama_nasabah }}</td>
              <td>{{ $doc->no_rekening }}</td>
              <td>{{ $doc->jenis_dokumen }}</td>
              <td class="text-warning">
                {{ $doc->catatan ? Str::limit($doc->catatan, 40) : 'Tidak ada catatan' }}
              </td>
              <td>{{ $doc->verified_at ? $doc->verified_at->format('d/m/Y') : '-' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <!-- Pending Lama -->
  @if ($pendingLama->count() > 0)
    <div class="section">
      <div class="section-title section-pending">
        DOKUMEN PENDING LAMA >7 HARI ({{ $pendingLama->count() }})
      </div>
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Nasabah</th>
            <th>No. Rekening</th>
            <th>Jenis Dokumen</th>
            <th>Tanggal Upload</th>
            <th>Lama Pending</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pendingLama as $doc)
            @php
              $daysPending = $doc->created_at->diffInDays(now());
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $doc->nama_nasabah }}</td>
              <td>{{ $doc->no_rekening }}</td>
              <td>{{ $doc->jenis_dokumen }}</td>
              <td>{{ $doc->created_at->format('d/m/Y') }}</td>
              <td>
                <span class="badge badge-pending">{{ $daysPending }} hari</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
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
    <div style="text-align: center; padding: 40px; color: #28a745;">
      <h4>TIDAK ADA DOKUMEN BERMASALAH</h4>
      <p>Semua dokumen dalam kondisi baik</p>
    </div>
  @endif

  <!-- Footer -->
  <div class="footer">
    <div>Dicetak pada: {{ $tanggal_cetak }}</div>
    <div>Oleh: Sistem Manajemen Arsip Digital BRI</div>
    <div>Halaman 1/1</div>
  </div>
</body>

</html>
