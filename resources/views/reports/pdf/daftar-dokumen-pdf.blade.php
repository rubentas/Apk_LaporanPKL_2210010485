<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Daftar Dokumen - BRI KC Tanjung Tabalong</title>
  <style>
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
      padding: 15mm;
      background: #fff;
    }

    /* ============================================
       HEADER RESMI BRI - DIUPDATE
       ============================================ */
    .official-header {
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 3px solid #000;
      position: relative;
      text-align: center;
      /* Center align untuk seluruh header */
    }

    .logo-container {
      margin-bottom: 8px;
      text-align: center;
    }

    .logo-bri {
      height: 70px;
      /* Tinggi logo */
      margin: 0 auto;
      /* Center logo */
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
      max-width: 500px;
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

    /* SUMMARY BOX - CLEAN */
    .summary-box {
      background: #f8f9fa;
      padding: 6px 8px;
      margin: 10px 0 15px 0;
      border-radius: 3px;
      border-left: 3px solid #0033a0;
      font-size: 8pt;
    }

    .summary-grid {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .total-docs {
      font-weight: bold;
      color: #0033a0;
    }

    /* TABLE */
    .table-container {
      margin-top: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
    }

    thead th {
      background: #0033a0;
      color: white;
      padding: 6px 4px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
      font-size: 8pt;
    }

    tbody td {
      padding: 5px 4px;
      border: 1px solid #e0e0e0;
      vertical-align: top;
    }

    tbody tr:nth-child(even) {
      background: #fafafa;
    }

    /* COLUMN WIDTHS */
    .col-no {
      width: 25px;
      text-align: center;
    }

    .col-id {
      width: 55px;
    }

    .col-nama {
      width: 110px;
    }

    .col-rekening {
      width: 75px;
    }

    .col-jenis {
      width: 75px;
    }

    .col-kategori {
      width: 85px;
    }

    .col-status {
      width: 55px;
    }

    .col-tanggal {
      width: 65px;
    }

    .col-expired {
      width: 65px;
    }

    /* STATUS BADGES */
    .status {
      display: inline-block;
      padding: 2px 4px;
      border-radius: 2px;
      font-size: 7pt;
      font-weight: bold;
      text-align: center;
      min-width: 50px;
    }

    .status-verified {
      background: #28a745;
      color: white;
    }

    .status-pending {
      background: #ffc107;
      color: #000;
    }

    .status-rejected {
      background: #dc3545;
      color: white;
    }

    .status-expired {
      background: #6c757d;
      color: white;
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

    .small {
      font-size: 7pt;
      display: block;
      color: #888;
    }

    .highlight {
      background: #fffacd;
      padding: 1px 3px;
      border-radius: 2px;
    }

    /* BASE64 LOGO FALLBACK */
    .logo-fallback {
      display: none;
    }
  </style>
</head>

<body>

  <!-- HEADER RESMI BRI DENGAN LOGO -->
  <div class="official-header">
    <div class="logo-container">
      <!-- Logo dari path yang kamu berikan -->
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
    <div class="report-title">LAPORAN DAFTAR DOKUMEN</div>
    <div class="report-subtitle">Sistem Arsip Digital Administrasi Kredit</div>
  </div>

  <!-- SUMMARY BOX -->
  <div class="summary-box">
    <div class="summary-grid">
      <div class="total-docs">Total: {{ $documents->count() }} dokumen</div>
      @if (isset($is_selected_report) && $is_selected_report)
        <div style="color: #dc3545; font-weight: bold;">• Dokumen Terpilih</div>
      @endif
    </div>
  </div>

  <!-- TABLE -->
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th class="col-no">No</th>
          <th class="col-id">ID</th>
          <th class="col-nama">Nama Nasabah</th>
          <th class="col-rekening">No Rekening</th>
          <th class="col-jenis">Jenis Dokumen</th>
          <th class="col-kategori">Kategori</th>
          <th class="col-status">Status</th>
          <th class="col-tanggal">Tgl. Upload</th>
          <th class="col-expired">Expired</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($documents as $document)
          <tr>
            <td class="col-no text-center">{{ $loop->iteration }}</td>
            <td class="col-id">{{ $document->id }}</td>
            <td class="col-nama">
              {{ $document->nama_nasabah }}
              <span class="small">KTP: {{ $document->no_ktp }}</span>
            </td>
            <td class="col-rekening">{{ $document->no_rekening }}</td>
            <td class="col-jenis">{{ $document->jenis_dokumen }}</td>
            <td class="col-kategori">{{ $document->kategori_kredit }}</td>
            <td class="col-status text-center">
              @php
                $statusClass = 'status-' . $document->status;
                $statusLabel = ucfirst($document->status);
              @endphp
              <span class="status {{ $statusClass }}">{{ $statusLabel }}</span>
            </td>
            <td class="col-tanggal">{{ $document->created_at->format('d/m/Y') }}</td>
            <td class="col-expired">
              @if ($document->expired_date)
                {{ $document->expired_date->format('d/m/Y') }}
                @if ($document->expired_date->isPast())
                  <span class="status status-expired">EXP</span>
                @endif
              @else
                -
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <div>Dokumen ini dicetak secara otomatis dari sistem</div>
    <div style="margin-top: 5px; color: #999; font-size: 6.5pt;">
      {{ $tanggal_cetak }} • BRI KC Tanjung Tabalong
    </div>
  </div>

</body>

</html>
