<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Statistik - BRI KC Tanjung Tabalong</title>
  <style>
    /* RESET & BASE */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      font-size: 10pt;
      line-height: 1.3;
      color: #333;
      margin: 0;
      padding: 15mm;
      background: #fff;
    }

    /* HEADER - CLEAN */
    .header {
      text-align: center;
      margin-bottom: 20px;
      padding-bottom: 10px;
    }

    .header h1 {
      color: #0033a0;
      font-size: 14pt;
      font-weight: bold;
      margin-bottom: 3px;
    }

    .header h2 {
      color: #0033a0;
      font-size: 12pt;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .header h3 {
      color: #333;
      font-size: 10pt;
      margin-top: 8px;
    }

    /* STATS SUMMARY - SIMPLE */
    .stats-summary {
      background: #f8f9fa;
      padding: 10px;
      margin: 15px 0;
      border-radius: 4px;
      border-left: 4px solid #0033a0;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
      font-size: 9pt;
    }

    .summary-label {
      font-weight: bold;
      color: #0033a0;
      min-width: 120px;
    }

    .summary-value {
      color: #333;
      font-weight: bold;
    }

    /* SECTION TITLES */
    .section-title {
      color: #0033a0;
      font-size: 11pt;
      font-weight: bold;
      margin: 25px 0 10px 0;
      padding-bottom: 5px;
      border-bottom: 2px solid #0033a0;
    }

    /* TABLES - CLEAN */
    .table-container {
      margin-top: 10px;
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 9pt;
      margin-bottom: 20px;
    }

    table th {
      background: #0033a0;
      color: white;
      padding: 8px 6px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
    }

    table td {
      padding: 7px 6px;
      border: 1px solid #e0e0e0;
      vertical-align: top;
    }

    table tr:nth-child(even) {
      background: #f9f9f9;
    }

    /* COLUMN ALIGNMENT */
    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    /* STATUS BADGES - SIMPLE */
    .badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: bold;
      min-width: 65px;
      text-align: center;
    }

    .badge-pending {
      background: #ffc107;
      color: #000;
    }

    .badge-verified {
      background: #28a745;
      color: white;
    }

    .badge-rejected {
      background: #dc3545;
      color: white;
    }

    .badge-expired {
      background: #6c757d;
      color: white;
    }

    /* FOOTER - MINIMAL */
    .footer {
      margin-top: 30px;
      padding-top: 10px;
      border-top: 1px solid #ddd;
      text-align: center;
      font-size: 8pt;
      color: #666;
    }

    /* UTILITY */
    .highlight {
      background: #fffacd;
      padding: 2px 4px;
      border-radius: 2px;
      font-weight: bold;
    }

    .total-row {
      font-weight: bold;
      background: #f0f0f0 !important;
    }

    /* EXPIRING SOON */
    .expiring-soon {
      color: #dc3545;
      font-weight: bold;
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <div class="header">
    <h1>BRI KC TANJUNG TABALONG</h1>
    <h2>Laporan Statistik Dokumen</h2>
    <h3>Sistem Arsip Digital Administrasi Kredit</h3>
  </div>

  <!-- STATS SUMMARY -->
  <div class="stats-summary">
    <div class="summary-row">
      <span class="summary-label">Total Dokumen:</span>
      <span class="summary-value">{{ number_format($stats->total) }}</span>
    </div>
    <div class="summary-row">
      <span class="summary-label">Terverifikasi:</span>
      <span class="summary-value">{{ number_format($stats->verified) }}</span>
    </div>
    <div class="summary-row">
      <span class="summary-label">Pending:</span>
      <span class="summary-value">{{ number_format($stats->pending) }}</span>
    </div>
    <div class="summary-row">
      <span class="summary-label">Ditolak:</span>
      <span class="summary-value">{{ number_format($stats->rejected) }}</span>
    </div>
    <div class="summary-row">
      <span class="summary-label">Expired:</span>
      <span class="summary-value">{{ number_format($stats->expired) }}</span>
    </div>
    <div class="summary-row">
      <span class="summary-label">Hampir Expired:</span>
      <span class="summary-value">{{ number_format($stats->expiring_soon) }}</span>
    </div>
  </div>

  <!-- DISTRIBUSI STATUS -->
  <div class="section-title">Distribusi Status Dokumen</div>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Status</th>
          <th class="text-center">Jumlah</th>
          <th class="text-right">Persentase</th>
        </tr>
      </thead>
      <tbody>
        @php
          $total = $stats->total;
          $statuses = [
              ['label' => 'Pending', 'value' => $stats->pending, 'class' => 'badge-pending'],
              ['label' => 'Verified', 'value' => $stats->verified, 'class' => 'badge-verified'],
              ['label' => 'Rejected', 'value' => $stats->rejected, 'class' => 'badge-rejected'],
              ['label' => 'Expired', 'value' => $stats->expired, 'class' => 'badge-expired'],
          ];
        @endphp
        @foreach ($statuses as $status)
          <tr>
            <td>
              <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
            </td>
            <td class="text-center">{{ number_format($status['value']) }}</td>
            <td class="text-right">
              @if ($total > 0)
                {{ number_format(($status['value'] / $total) * 100, 1) }}%
              @else
                0%
              @endif
            </td>
          </tr>
        @endforeach
        <!-- TOTAL ROW -->
        <tr class="total-row">
          <td><strong>TOTAL</strong></td>
          <td class="text-center"><strong>{{ number_format($total) }}</strong></td>
          <td class="text-right"><strong>100%</strong></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- TREND BULANAN -->
  <div class="section-title">Trend 6 Bulan Terakhir</div>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Bulan</th>
          <th class="text-center">Total</th>
          <th class="text-center">Verified</th>
          <th class="text-right">% Verified</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($monthlyData as $month)
          <tr>
            <td>{{ $month->month }}</td>
            <td class="text-center">{{ $month->total }}</td>
            <td class="text-center">{{ $month->verified }}</td>
            <td class="text-right">
              @if ($month->total > 0)
                {{ number_format(($month->verified / $month->total) * 100, 1) }}%
              @else
                0%
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- TOP KATEGORI -->
  <div class="section-title">Top 5 Kategori Kredit</div>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Kategori Kredit</th>
          <th class="text-center">Jumlah</th>
          <th class="text-right">%</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($topKategori as $index => $kategori)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $kategori->kategori_kredit ?? 'Tidak Terkategori' }}</td>
            <td class="text-center">{{ number_format($kategori->total) }}</td>
            <td class="text-right">
              @if ($stats->total > 0)
                {{ number_format(($kategori->total / $stats->total) * 100, 1) }}%
              @else
                0%
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- DOKUMEN HAMPIR EXPIRED -->
  @if ($expiringSoon->count() > 0)
    <div class="section-title">Dokumen Hampir Expired (30 Hari)</div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nasabah</th>
            <th>No. Rekening</th>
            <th>Jenis Dokumen</th>
            <th class="text-center">Tgl Expired</th>
            <th class="text-center">Sisa Hari</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($expiringSoon as $doc)
            @php
              $daysLeft = \Carbon\Carbon::parse($doc->expired_date)->diffInDays(now(), false) * -1;
            @endphp
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td>{{ $doc->nama_nasabah }}</td>
              <td>{{ $doc->no_rekening }}</td>
              <td>{{ $doc->jenis_dokumen }}</td>
              <td class="text-center">{{ \Carbon\Carbon::parse($doc->expired_date)->format('d/m/Y') }}</td>
              <td class="text-center">
                @if ($daysLeft > 0)
                  <span class="expiring-soon">{{ $daysLeft }} hari</span>
                @else
                  <span class="badge badge-expired">EXPIRED</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <!-- FOOTER -->
  <div class="footer">
    <div>Dokumen ini dicetak secara otomatis dari sistem</div>
    <div style="margin-top: 5px; color: #999; font-size: 7pt;">
      {{ $tanggal_cetak }} • BRI KC Tanjung Tabalong
    </div>
  </div>

</body>

</html>
