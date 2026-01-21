<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Analisis Statistik - BRI KC Tanjung Tabalong</title>
  <style>
    /* SET PAGE SIZE PORTRAIT */
    @page {
      size: A4 portrait;
      margin: 15mm;
    }

    /* RESET & BASE STYLES */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      font-size: 9pt;
      line-height: 1.4;
      color: #333;
      margin: 0;
      padding: 0;
      width: 210mm;
      background: #fff;
    }

    .page-container {
      padding: 15mm;
    }

    /* =================
       HEADER RESMI BRI
       ================= */
    .official-header {
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 3px solid #000;
      position: relative;
      text-align: center;
    }

    .logo-container {
      margin-bottom: 8px;
      text-align: center;
    }

    .logo-bri {
      height: 70px;
      margin: 0 auto;
      display: block;
    }

    .bank-info {
      margin-top: 5px;
    }

    .bank-name {
      font-weight: bold;
      font-size: 9pt;
      line-height: 1.2;
      margin-bottom: 1px;
      color: #000;
    }

    .bank-address {
      font-size: 7pt;
      line-height: 1.3;
      color: #333;
      margin-top: 3px;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
    }

    .header-line {
      border-bottom: 1px solid #000;
      margin: 5px auto 0 auto;
      width: 100%;
    }

    /* JUDUL LAPORAN */
    .report-title-section {
      text-align: center;
      margin: 15px 0 20px 0;
    }

    .report-title {
      font-size: 12pt;
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 5px;
      color: #000;
    }

    .report-subtitle {
      font-size: 9pt;
      color: #333;
      margin-top: 3px;
    }

    /* SECTION TITLES */
    .section-title {
      color: #0033a0;
      font-size: 10pt;
      font-weight: bold;
      margin: 20px 0 10px 0;
      padding-bottom: 5px;
      border-bottom: 2px solid #0033a0;
    }

    /* TABLES - CLEAN */
    .table-container {
      margin-top: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
      margin-bottom: 15px;
    }

    table thead th {
      background: #0033a0;
      color: white;
      padding: 8px 6px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
    }

    table tbody td {
      padding: 7px 6px;
      border: 1px solid #e0e0e0;
      vertical-align: top;
    }

    table tbody tr:nth-child(even) {
      background: #f9f9f9;
    }

    /* COLUMN WIDTHS */
    .col-status {
      width: 80px;
    }

    .col-jumlah {
      width: 60px;
      text-align: center;
    }

    .col-persen {
      width: 70px;
      text-align: right;
    }

    .col-bulan {
      width: 100px;
    }

    .col-nasabah {
      width: 100px;
      word-wrap: break-word;
    }

    .col-rekening {
      width: 80px;
    }

    .col-jenis {
      width: 90px;
    }

    .col-tanggal {
      width: 70px;
      text-align: center;
    }

    .col-sisa {
      width: 60px;
      text-align: center;
    }

    /* STATUS BADGES */
    .status-badge {
      display: inline-block;
      padding: 3px 6px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: bold;
      text-align: center;
      min-width: 60px;
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

    /* TOTAL ROW */
    .total-row {
      font-weight: bold;
      background: #f0f0f0 !important;
      border-top: 2px solid #0033a0;
    }

    /* EXPIRING SOON */
    .expiring-soon {
      color: #dc3545;
      font-weight: bold;
    }

    /* FOOTER - MINIMAL */
    .footer {
      margin-top: 20px;
      padding-top: 8px;
      border-top: 1px solid #eee;
      text-align: center;
      font-size: 7pt;
      color: #777;
      line-height: 1.3;
    }

    /* UTILITY */
    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }
  </style>
</head>

<body>
  <div class="page-container">
    <!-- HEADER RESMI BRI DENGAN LOGO -->
    <div class="official-header">
      <div class="logo-container">
        <img src="{{ public_path('adminlte/dist/img/LogoBankBRI.png') }}" alt="Logo BRI" class="logo-bri">
      </div>

      <div class="bank-info">
        <div class="bank-name">PT. BANK RAKYAT INDONESIA (PERSERO) Tbk</div>
        <div class="bank-name">KANTOR CABANG TANJUNG TABALONG</div>
        <div class="header-line"></div>
        <div class="bank-address">
          Jalan Putri Zaleha No.2 RT.003, Tanjung, Tabalong, Kalimantan Selatan 71571<br>
          Telepon: (0526) 2021030 • Email: bri.tanjungtabalong@bri.co.id
        </div>
      </div>
    </div>

    <!-- JUDUL LAPORAN -->
    <div class="report-title-section">
      <div class="report-title">LAPORAN ANALISIS STATISTIK DOKUMEN</div>
      <div class="report-subtitle">Sistem Arsip Digital Administrasi Kredit</div>
    </div>

    <!-- DISTRIBUSI STATUS -->
    <div class="section-title">Distribusi Status Dokumen</div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Status</th>
            <th class="col-jumlah">Jumlah</th>
            <th class="col-persen">Persentase</th>
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
                <span class="status-badge {{ $status['class'] }}">{{ $status['label'] }}</span>
              </td>
              <td class="col-jumlah text-center">{{ number_format($status['value']) }}</td>
              <td class="col-persen text-right">
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
            <td class="col-jumlah text-center"><strong>{{ number_format($total) }}</strong></td>
            <td class="col-persen text-right"><strong>100%</strong></td>
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
            <th class="col-bulan">Bulan</th>
            <th class="col-jumlah">Total</th>
            <th class="col-jumlah">Verified</th>
            <th class="col-persen">% Verified</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($monthlyData as $month)
            <tr>
              <td class="col-bulan">{{ $month->month }}</td>
              <td class="col-jumlah text-center">{{ $month->total }}</td>
              <td class="col-jumlah text-center">{{ $month->verified }}</td>
              <td class="col-persen text-right">
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
            <th class="col-jumlah">Jumlah</th>
            <th class="col-persen">%</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($topKategori as $index => $kategori)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td>{{ $kategori->kategori_kredit ?? 'Tidak Terkategori' }}</td>
              <td class="col-jumlah text-center">{{ number_format($kategori->total) }}</td>
              <td class="col-persen text-right">
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
              <th class="col-nasabah">Nasabah</th>
              <th class="col-rekening">No. Rekening</th>
              <th class="col-jenis">Jenis Dokumen</th>
              <th class="col-tanggal">Tgl Expired</th>
              <th class="col-sisa">Sisa Hari</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($expiringSoon as $doc)
              @php
                $daysLeft = \Carbon\Carbon::parse($doc->expired_date)->diffInDays(now(), false) * -1;
              @endphp
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="col-nasabah">{{ $doc->nama_nasabah }}</td>
                <td class="col-rekening">{{ $doc->no_rekening }}</td>
                <td class="col-jenis">{{ $doc->jenis_dokumen }}</td>
                <td class="col-tanggal">{{ \Carbon\Carbon::parse($doc->expired_date)->format('d/m/Y') }}</td>
                <td class="col-sisa text-center">
                  @if ($daysLeft > 0)
                    <span class="expiring-soon">{{ $daysLeft }} hari</span>
                  @else
                    <span class="status-badge badge-expired">EXPIRED</span>
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
      <div style="margin-top: 5px; color: #999; font-size: 6.5pt;">
        {{ $tanggal_cetak }} • BRI KC Tanjung Tabalong
      </div>
    </div>
  </div>
</body>

</html>
