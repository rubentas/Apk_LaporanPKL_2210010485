<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Aktivitas - BRI KC Tanjung Tabalong</title>
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
       HEADER RESMI BRI - SAMA DENGAN DOKUMEN
       ============================================ */
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

    /* TABLE - CLEAN */
    .table-container {
      margin-top: 10px;
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
    }

    thead th {
      background: #0033a0;
      color: white;
      padding: 8px 6px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
    }

    tbody td {
      padding: 7px 6px;
      border: 1px solid #e0e0e0;
      vertical-align: top;
    }

    tbody tr:nth-child(even) {
      background: #f9f9f9;
    }

    /* COLUMN WIDTHS - PORTRAIT LAYOUT */
    .col-no {
      width: 30px;
      text-align: center;
    }

    .col-user {
      width: 120px;
    }

    .col-action {
      width: 70px;
      text-align: center;
    }

    .col-description {
      min-width: 200px;
    }

    .col-date {
      width: 90px;
      text-align: center;
    }

    /* ACTION BADGES */
    .badge {
      display: inline-block;
      padding: 3px 6px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: bold;
      text-align: center;
      min-width: 60px;
    }

    .badge-upload {
      background: #28a745;
      color: white;
    }

    .badge-download {
      background: #17a2b8;
      color: white;
    }

    .badge-edit {
      background: #ffc107;
      color: #000;
    }

    .badge-delete {
      background: #dc3545;
      color: white;
    }

    .badge-verify {
      background: #007bff;
      color: white;
    }

    .badge-reject {
      background: #6c757d;
      color: white;
    }

    .badge-login {
      background: #6610f2;
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
      color: #777;
      display: block;
    }
  </style>
</head>

<body>

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
    <div class="report-title">LAPORAN AKTIVITAS PENGGUNA</div>
    <div class="report-subtitle">Sistem Arsip Digital Administrasi Kredit</div>
  </div>

  <!-- ACTIVITY LIST -->
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th class="col-no">No</th>
          <th class="col-user">Pengguna</th>
          <th class="col-action">Aksi</th>
          <th class="col-description">Deskripsi</th>
          <th class="col-date">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($activities as $activity)
          @php
            $badgeClass = 'badge-' . $activity->action;
          @endphp
          <tr>
            <td class="col-no text-center">{{ $loop->iteration }}</td>
            <td>
              {{ $activity->user->name ?? 'System' }}
              @if ($activity->user)
                <span class="small">{{ $activity->user->email ?? '' }}</span>
              @endif
            </td>
            <td class="col-action">
              <span class="badge {{ $badgeClass }}">
                {{ strtoupper($activity->action) }}
              </span>
            </td>
            <td>
              {{ $activity->description }}
              @if ($activity->document)
                <span class="small">Dokumen: {{ $activity->document->nama_nasabah ?? '' }} (ID:
                  {{ $activity->document_id }})</span>
              @endif
            </td>
            <td class="col-date">
              {{ $activity->created_at->format('d/m/Y') }}
              <span class="small">{{ $activity->created_at->format('H:i') }}</span>
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
