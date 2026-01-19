<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan Kredit Akan Selesai - BRI KC Tanjung Tabalong</title>
  <style>
    /* SET PAGE SIZE LANDSCAPE */
    @page {
      size: A4 landscape;
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
      width: 297mm;
      /* Lebar A4 landscape */
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

    .periode-info {
      font-size: 8pt;
      color: #666;
      margin-top: 3px;
      font-weight: bold;
    }

    /* FILTER INFO */
    .filter-info {
      background: #fff3cd;
      padding: 5px 8px;
      margin-bottom: 10px;
      border-radius: 3px;
      font-size: 8pt;
      border-left: 3px solid #ffc107;
    }

    /* TABLE - CLEAN */
    .table-container {
      margin-top: 5px;
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
    }

    table thead th {
      background: #0033a0;
      color: white;
      padding: 8px 6px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
      vertical-align: middle;
    }

    table tbody td {
      padding: 7px 6px;
      border: 1px solid #e0e0e0;
      vertical-align: top;
    }

    table tbody tr:nth-child(even) {
      background: #f9f9f9;
    }

    /* COLUMN WIDTHS - LANDSCAPE */
    .col-no {
      width: 30px;
      text-align: center;
    }

    .col-nasabah {
      width: 120px;
      word-wrap: break-word;
    }

    .col-rekening {
      width: 90px;
    }

    .col-kategori {
      width: 100px;
    }

    .col-nominal {
      width: 100px;
    }

    .col-tahun {
      width: 70px;
      text-align: center;
    }

    .col-tenor {
      width: 50px;
      text-align: center;
    }

    .col-estimasi {
      width: 80px;
      text-align: center;
    }

    .col-sisa {
      width: 70px;
      text-align: center;
    }

    .col-status {
      width: 80px;
      text-align: center;
    }

    .col-bunga {
      width: 60px;
      text-align: center;
    }

    /* BADGES */
    .badge {
      display: inline-block;
      padding: 3px 6px;
      border-radius: 3px;
      font-size: 7.5pt;
      font-weight: bold;
      text-align: center;
      min-width: 50px;
    }

    .badge-success {
      background: #28a745;
      color: white;
    }

    .badge-warning {
      background: #ffc107;
      color: #000;
    }

    .badge-danger {
      background: #dc3545;
      color: white;
    }

    .badge-info {
      background: #17a2b8;
      color: white;
    }

    /* EMPTY STATE */
    .empty-state {
      text-align: center;
      padding: 40px 20px;
      color: #666;
      font-style: italic;
      font-size: 9pt;
      border: 1px dashed #dee2e6;
      border-radius: 5px;
      margin: 20px 0;
      background: #f8f9fa;
    }

    /* FOOTER - MINIMAL */
    .footer {
      margin-top: 15px;
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
      <div class="report-title">LAPORAN KREDIT AKAN SELESAI</div>
      <div class="report-subtitle">Sistem Arsip Digital Administrasi Kredit</div>
      <div class="periode-info">Periode: {{ $tahun_ini }} - {{ $tahun_depan }}</div>
    </div>

    <!-- FILTER INFO -->
    @if (isset($filter['kategori']) && $filter['kategori'])
      <div class="filter-info">
        <strong>Filter:</strong> Kategori: {{ $filter['kategori'] }}
        @if (isset($filter['tahun']) && $filter['tahun'])
          | Tahun: {{ $filter['tahun'] }}
        @endif
      </div>
    @endif

    <!-- TABLE -->
    <div class="table-container">
      @if ($documents->count() > 0)
        <table>
          <thead>
            <tr>
              <th class="col-no">No</th>
              <th class="col-nasabah">Nasabah</th>
              <th class="col-rekening">No Rekening</th>
              <th class="col-kategori">Kategori Kredit</th>
              <th class="col-nominal">Nominal Kredit</th>
              <th class="col-tahun">Tahun Pengajuan</th>
              <th class="col-tenor">Tenor</th>
              <th class="col-estimasi">Estimasi Selesai</th>
              <th class="col-sisa">Sisa Waktu</th>
              <th class="col-status">Status Riwayat</th>
              <th class="col-bunga">Suku Bunga</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($documents as $doc)
              <tr>
                <td class="col-no text-center">{{ $loop->iteration }}</td>
                <td class="col-nasabah">{{ $doc->nama_nasabah }}</td>
                <td class="col-rekening">{{ $doc->no_rekening }}</td>
                <td class="col-kategori">{{ $doc->kategori_kredit }}</td>
                <td class="col-nominal">Rp {{ number_format($doc->nominal_kredit, 0, ',', '.') }}</td>
                <td class="col-tahun text-center">{{ $doc->tahun_pengajuan }}</td>
                <td class="col-tenor text-center">{{ $doc->tenor }} bln</td>
                <td class="col-estimasi text-center">
                  <span class="badge {{ $doc->estimasi_selesai == $tahun_ini ? 'badge-success' : 'badge-warning' }}">
                    {{ $doc->estimasi_selesai }}
                  </span>
                </td>
                <td class="col-sisa text-center">
                  @php $sisa = $doc->estimasi_selesai - $tahun_ini; @endphp
                  @if ($sisa == 0)
                    <span class="badge badge-danger">Tahun ini</span>
                  @else
                    <span class="badge badge-info">{{ $sisa }} tahun</span>
                  @endif
                </td>
                <td class="col-status text-center">
                  @if ($doc->status_riwayat == 'bersih')
                    <span class="badge badge-success">Bersih</span>
                  @elseif($doc->status_riwayat == 'pernah_telat')
                    <span class="badge badge-warning">P.Telat</span>
                  @else
                    <span class="badge badge-danger">Masalah</span>
                  @endif
                </td>
                <td class="col-bunga text-center">{{ $doc->suku_bunga }}%</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty-state">
          Tidak ada data kredit yang akan selesai dalam periode {{ $tahun_ini }} - {{ $tahun_depan }}
        </div>
      @endif
    </div>

    <!-- FOOTER -->
    <div class="footer">
      <div>Laporan ini digunakan untuk monitoring kredit yang akan selesai dalam 2 tahun ke depan</div>
      <div style="margin-top: 5px; color: #999; font-size: 6.5pt;">
        {{ date('d/m/Y H:i') }} • BRI KC Tanjung Tabalong
      </div>
    </div>
  </div>
</body>

</html>
