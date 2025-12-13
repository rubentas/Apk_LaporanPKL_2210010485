<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Dokumen Per Kategori Kredit - BRI</title>
  <style>
    @page {
      margin: 15px 20px;
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 11px;
      line-height: 1.4;
      color: #333;
    }

    .header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 3px solid #0033a0;
      padding-bottom: 8px;
    }

    .header img {
      height: 40px;
      margin-bottom: 8px;
    }

    .header h1 {
      color: #0033a0;
      font-size: 16px;
      margin: 3px 0;
      font-weight: bold;
    }

    .header h2 {
      color: #333;
      font-size: 12px;
      margin: 2px 0;
      font-weight: normal;
    }

    .header .periode {
      font-size: 10px;
      color: #666;
      margin-top: 5px;
    }

    .summary-box {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      padding: 8px;
      margin-bottom: 15px;
    }

    .summary-item {
      display: inline-block;
      width: 32%;
      text-align: center;
      vertical-align: top;
    }

    .summary-value {
      font-size: 14px;
      font-weight: bold;
      color: #0033a0;
    }

    .summary-label {
      font-size: 10px;
      color: #6c757d;
    }

    .filter-info {
      background-color: #fff3cd;
      border: 1px solid #ffc107;
      padding: 6px 10px;
      margin-bottom: 12px;
      border-radius: 4px;
      font-size: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }

    table th {
      background-color: #0033a0;
      color: white;
      text-align: left;
      padding: 6px;
      font-size: 10px;
      border: 1px solid #dee2e6;
      font-weight: bold;
    }

    table td {
      padding: 5px 6px;
      border: 1px solid #dee2e6;
      font-size: 10px;
    }

    table tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    table tfoot td {
      background-color: #e9ecef;
      font-weight: bold;
      border-top: 2px solid #0033a0;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .badge {
      display: inline-block;
      padding: 2px 6px;
      font-size: 9px;
      font-weight: bold;
      border-radius: 3px;
      text-align: center;
    }

    .badge-primary {
      background-color: #007bff;
      color: white;
    }

    .badge-success {
      background-color: #28a745;
      color: white;
    }

    .badge-warning {
      background-color: #ffc107;
      color: #212529;
    }

    .badge-danger {
      background-color: #dc3545;
      color: white;
    }

    .badge-dark {
      background-color: #343a40;
      color: white;
    }

    .progress {
      height: 12px;
      background-color: #e9ecef;
      border-radius: 3px;
      margin: 3px 0;
      overflow: hidden;
    }

    .progress-bar {
      height: 100%;
      background-color: #28a745;
      float: left;
    }

    .section-title {
      background-color: #e9ecef;
      padding: 6px 8px;
      margin: 12px 0 8px 0;
      border-left: 4px solid #0033a0;
      font-weight: bold;
      font-size: 11px;
    }

    .insight-box {
      border: 1px solid #dee2e6;
      border-radius: 4px;
      padding: 8px;
      margin-bottom: 12px;
      page-break-inside: avoid;
    }

    .insight-title {
      font-weight: bold;
      color: #0033a0;
      margin-bottom: 6px;
      font-size: 11px;
    }

    .insight-content {
      font-size: 10px;
      line-height: 1.5;
    }

    .two-columns {
      width: 100%;
      margin-bottom: 12px;
    }

    .two-columns .column {
      width: 48%;
      display: inline-block;
      vertical-align: top;
    }

    .two-columns .column:first-child {
      margin-right: 3%;
    }

    .footer {
      margin-top: 20px;
      padding-top: 8px;
      border-top: 1px solid #dee2e6;
      text-align: center;
      font-size: 9px;
      color: #6c757d;
    }

    .text-success {
      color: #28a745;
    }

    .text-danger {
      color: #dc3545;
    }

    .text-warning {
      color: #ffc107;
    }

    .text-muted {
      color: #6c757d;
    }

    ul {
      margin: 5px 0;
      padding-left: 18px;
      font-size: 10px;
    }

    ul li {
      margin-bottom: 3px;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <div>
      <strong>PT BANK RAKYAT INDONESIA (PERSERO) Tbk</strong><br>
      <small>KC TANJUNG TABALONG</small>
    </div>
    <h1>LAPORAN DOKUMEN PER KATEGORI KREDIT</h1>
    <h2>Sistem Manajemen Arsip Digital BRI</h2>
    <div class="periode">
      Periode: {{ date('d/m/Y', strtotime('first day of this month')) }} - {{ date('d/m/Y') }}
    </div>
  </div>

  <!-- Summary -->
  <div class="summary-box">
    <div class="summary-item">
      <div class="summary-value">{{ $summary['total_categories'] }}</div>
      <div class="summary-label">Total Kategori</div>
    </div>
    <div class="summary-item">
      <div class="summary-value">{{ number_format($summary['total_documents']) }}</div>
      <div class="summary-label">Total Dokumen</div>
    </div>
    <div class="summary-item">
      <div class="summary-value">{{ $summary['avg_docs_per_category'] }}</div>
      <div class="summary-label">Rata-rata per Kategori</div>
    </div>
  </div>

  <!-- Filter Info -->
  @if (isset($selectedCategoryLabel) && $selectedCategoryLabel)
    <div class="filter-info">
      <strong>Filter Aktif:</strong> Menampilkan data untuk kategori: <strong>{{ $selectedCategoryLabel }}</strong>
    </div>
  @endif

  <!-- Main Table -->
  <div class="section-title">DETAIL PER KATEGORI KREDIT</div>
  <table>
    <thead>
      <tr>
        <th width="4%">No</th>
        <th width="23%">Kategori Kredit</th>
        <th width="8%" class="text-center">Total</th>
        <th width="7%" class="text-center">Pending</th>
        <th width="7%" class="text-center">Verified</th>
        <th width="7%" class="text-center">Rejected</th>
        <th width="7%" class="text-center">Expired</th>
        <th width="12%" class="text-center">Rata-rata Verifikasi</th>
        <th width="25%">Persentase</th>
      </tr>
    </thead>
    <tbody>
      @php
        $totalPending = 0;
        $totalVerified = 0;
        $totalRejected = 0;
        $totalExpired = 0;
      @endphp

      @foreach ($reportData as $key => $data)
        @php
          $totalPending += $data['pending'];
          $totalVerified += $data['verified'];
          $totalRejected += $data['rejected'];
          $totalExpired += $data['expired'];
        @endphp
        <tr>
          <td class="text-center">{{ $loop->iteration }}</td>
          <td><strong>{{ $data['label'] }}</strong></td>
          <td class="text-center">
            <span class="badge badge-primary">{{ $data['total'] }}</span>
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
              {{ $data['avg_verification'] }} hari
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td>
            <div class="progress">
              <div class="progress-bar" style="width: {{ $data['percentage'] }}%"></div>
            </div>
            <div class="text-center" style="margin-top: 2px;">{{ $data['percentage'] }}%</div>
          </td>
        </tr>
      @endforeach
    </tbody>
    @if (count($reportData) > 0)
      <tfoot>
        <tr>
          <td colspan="2" class="text-right"><strong>TOTAL:</strong></td>
          <td class="text-center">
            <span class="badge badge-primary">{{ $summary['total_documents'] }}</span>
          </td>
          <td class="text-center">
            <span class="badge badge-warning">{{ $totalPending }}</span>
          </td>
          <td class="text-center">
            <span class="badge badge-success">{{ $totalVerified }}</span>
          </td>
          <td class="text-center">
            <span class="badge badge-danger">{{ $totalRejected }}</span>
          </td>
          <td class="text-center">
            <span class="badge badge-dark">{{ $totalExpired }}</span>
          </td>
          <td colspan="2"></td>
        </tr>
      </tfoot>
    @endif
  </table>

  <!-- Insights Section -->
  <div class="section-title">ANALISIS DAN INSIGHTS</div>

  <div class="two-columns">
    <!-- Problem Categories -->
    <div class="column">
      <div class="insight-box">
        <div class="insight-title" style="color: #dc3545;">
          ⚠ KATEGORI PERLU PERHATIAN
        </div>
        <div class="insight-content">
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
            <ul>
              @foreach ($problemCategories as $cat)
                <li>
                  <strong>{{ $cat['label'] }}</strong>
                  @if ($cat['expired'] > 0)
                    <span class="badge badge-dark">{{ $cat['expired'] }} expired</span>
                  @endif
                  @if ($cat['rejected'] > 5)
                    <span class="badge badge-danger">{{ $cat['rejected'] }} rejected</span>
                  @endif
                  @if ($cat['total'] > 0 && $cat['pending'] / $cat['total'] > 0.3)
                    <span class="badge badge-warning">{{ $cat['pending'] }} pending</span>
                  @endif
                </li>
              @endforeach
            </ul>
          @else
            <div style="color: #28a745;">
              ✓ Semua kategori dalam kondisi baik
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Top Performers -->
    <div class="column">
      <div class="insight-box">
        <div class="insight-title" style="color: #28a745;">
          🏆 TOP PERFORMERS
        </div>
        <div class="insight-content">
          @php
            $sortedByVerified = collect($reportData)->sortByDesc('verified')->take(3);
          @endphp

          @foreach ($sortedByVerified as $cat)
            <div style="margin-bottom: 8px;">
              <div style="margin-bottom: 2px;">
                <strong>{{ $cat['label'] }}</strong>
                <span class="badge badge-success" style="float: right;">
                  {{ $cat['total'] > 0 ? round(($cat['verified'] / $cat['total']) * 100) : 0 }}%
                </span>
              </div>
              <div style="font-size: 9px; color: #666; margin-bottom: 3px;">
                {{ $cat['verified'] }} verified dari {{ $cat['total'] }} dokumen
              </div>
              <div class="progress">
                <div class="progress-bar"
                  style="width: {{ $cat['total'] > 0 ? ($cat['verified'] / $cat['total']) * 100 : 0 }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- Performance Summary -->
  <div class="section-title">RINGKASAN PERFORMANSI</div>
  <div class="insight-box">
    @php
      $verificationRate =
          $summary['total_documents'] > 0 ? round(($totalVerified / $summary['total_documents']) * 100, 1) : 0;
      $rejectionRate =
          $summary['total_documents'] > 0 ? round(($totalRejected / $summary['total_documents']) * 100, 1) : 0;
    @endphp

    <div style="margin-bottom: 8px;">
      <table style="width: 100%; border: none;">
        <tr style="background: none;">
          <td style="border: none; width: 33%; padding: 5px;">
            <strong>Tingkat Verifikasi:</strong><br>
            <span style="font-size: 13px; color: #28a745;">{{ $verificationRate }}%</span>
          </td>
          <td style="border: none; width: 33%; padding: 5px;">
            <strong>Tingkat Penolakan:</strong><br>
            <span style="font-size: 13px; color: #dc3545;">{{ $rejectionRate }}%</span>
          </td>
          <td style="border: none; width: 33%; padding: 5px;">
            <strong>Dokumen Expired:</strong><br>
            <span style="font-size: 13px; color: #343a40;">{{ $totalExpired }}</span>
          </td>
        </tr>
      </table>
    </div>

    @if ($rejectionRate > 10)
      <div
        style="background-color: #f8d7da; color: #721c24; padding: 6px; border-radius: 3px; margin-top: 8px; font-size: 10px;">
        <strong>⚠️ PERHATIAN:</strong> Tingkat penolakan dokumen melebihi 10%. Perlu evaluasi proses verifikasi.
      </div>
    @endif

    @if ($totalExpired > 0)
      <div
        style="background-color: #e2e3e5; color: #383d41; padding: 6px; border-radius: 3px; margin-top: 8px; font-size: 10px;">
        <strong>ℹ️ INFORMASI:</strong> Terdapat {{ $totalExpired }} dokumen yang telah expired. Segera lakukan tindakan
        follow-up.
      </div>
    @endif
  </div>

  <!-- Footer -->
  <div class="footer">
    <div style="margin-bottom: 4px;">
      Laporan ini dibuat secara otomatis oleh Sistem Manajemen Arsip Digital BRI
    </div>
    <div>
      Dicetak pada: {{ $summary['tanggal_cetak'] }} WIB<br>
      Hak Cipta &copy; {{ date('Y') }} PT Bank Rakyat Indonesia (Persero) Tbk.
    </div>
  </div>

</body>

</html>
