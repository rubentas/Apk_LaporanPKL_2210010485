<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Dokumen Bermasalah - BRI KC Tanjung Tabalong</title>
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

    /* ============================================
       HEADER RESMI BRI - SAMA DENGAN DOKUMEN LAIN
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
      color: #dc3545;
    }

    .report-subtitle {
      font-size: 9pt;
      color: #333;
      margin-top: 3px;
    }

    /* TABLE - CLEAN */
    .table-container {
      margin-top: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
      table-layout: fixed;
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
    .col-no {
      width: 30px;
      text-align: center;
    }

    .col-nasabah {
      width: 100px;
      word-wrap: break-word;
    }

    .col-rekening {
      width: 80px;
    }

    .col-jenis {
      width: 70px;
    }

    .col-status {
      width: 70px;
      text-align: center;
    }

    .col-tanggal {
      width: 65px;
      text-align: center;
    }

    .col-keterangan {
      width: 150px;
      word-wrap: break-word;
    }

    /* STATUS BADGES */
    .status-badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: bold;
      text-align: center;
      min-width: 60px;
    }

    .status-expired {
      background: #dc3545;
      color: white;
    }

    .status-rejected {
      background: #ffc107;
      color: #000;
    }

    .status-pending {
      background: #17a2b8;
      color: white;
    }

    .status-nik-duplicate {
      background: #6f42c1;
      color: white;
    }

    /* EMPTY STATE */
    .empty-state {
      text-align: center;
      padding: 40px 20px;
      color: #28a745;
      font-weight: bold;
      font-size: 10pt;
      border: 1px solid #28a745;
      border-radius: 5px;
      margin: 30px 0;
      background: #f8fff8;
    }

    /* SUMMARY FOOTNOTE */
    .summary-note {
      margin-top: 15px;
      font-size: 8pt;
      color: #666;
      padding: 8px;
      background: #f8f9fa;
      border-radius: 3px;
      border-left: 3px solid #0033a0;
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

    .small-text {
      font-size: 7pt;
      color: #666;
      display: block;
      margin-top: 2px;
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
      <div class="report-title">LAPORAN DOKUMEN BERMASALAH</div>
      <div class="report-subtitle">Sistem Arsip Digital Administrasi Kredit</div>
    </div>

    <!-- TABEL LAPORAN -->
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th class="col-no">No</th>
            <th class="col-nasabah">Nasabah</th>
            <th class="col-rekening">No. Rekening</th>
            <th class="col-jenis">Jenis Dokumen</th>
            <th class="col-status">Status</th>
            <th class="col-tanggal">Tgl Upload</th>
            <th class="col-keterangan">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <!-- DOKUMEN EXPIRED -->
          @foreach ($expired as $doc)
            <tr>
              <td class="col-no text-center">{{ $loop->iteration }}</td>
              <td class="col-nasabah">
                {{ $doc->nama_nasabah }}
                <span class="small-text">KTP: {{ $doc->no_ktp }}</span>
              </td>
              <td class="col-rekening">{{ $doc->no_rekening }}</td>
              <td class="col-jenis">{{ $doc->jenis_dokumen }}</td>
              <td class="col-status">
                <span class="status-badge status-expired">EXPIRED</span>
              </td>
              <td class="col-tanggal">{{ $doc->created_at->format('d/m/Y') }}</td>
              <td class="col-keterangan">
                Dokumen kadaluarsa {{ $doc->expired_date->format('d/m/Y') }}
              </td>
            </tr>
          @endforeach

          <!-- DOKUMEN REJECTED -->
          @foreach ($rejected as $doc)
            <tr>
              <td class="col-no text-center">{{ $loop->iteration + $expired->count() }}</td>
              <td class="col-nasabah">
                {{ $doc->nama_nasabah }}
                <span class="small-text">KTP: {{ $doc->no_ktp }}</span>
              </td>
              <td class="col-rekening">{{ $doc->no_rekening }}</td>
              <td class="col-jenis">{{ $doc->jenis_dokumen }}</td>
              <td class="col-status">
                <span class="status-badge status-rejected">DITOLAK</span>
              </td>
              <td class="col-tanggal">{{ $doc->created_at->format('d/m/Y') }}</td>
              <td class="col-keterangan">
                {{ $doc->catatan ?: 'Dokumen ditolak' }}
              </td>
            </tr>
          @endforeach

          <!-- PENDING LAMA -->
          @foreach ($pendingLama as $doc)
            @php
              $daysPending = $doc->created_at->diffInDays(now());
            @endphp
            <tr>
              <td class="col-no text-center">{{ $loop->iteration + $expired->count() + $rejected->count() }}</td>
              <td class="col-nasabah">
                {{ $doc->nama_nasabah }}
                <span class="small-text">KTP: {{ $doc->no_ktp }}</span>
              </td>
              <td class="col-rekening">{{ $doc->no_rekening }}</td>
              <td class="col-jenis">{{ $doc->jenis_dokumen }}</td>
              <td class="col-status">
                <span class="status-badge status-pending">PENDING</span>
              </td>
              <td class="col-tanggal">{{ $doc->created_at->format('d/m/Y') }}</td>
              <td class="col-keterangan">
                Menunggu verifikasi >7 hari
              </td>
            </tr>
          @endforeach

          <!-- NIK DUPLIKAT -->
          @foreach ($nikDuplikat as $nikData)
            @foreach ($nikData['documents'] as $doc)
              <tr>
                <td class="col-no text-center">
                  {{ $loop->parent->iteration + $expired->count() + $rejected->count() + $pendingLama->count() }}
                </td>
                <td class="col-nasabah">
                  {{ $doc->nama_nasabah }}
                  <span class="small-text">KTP: {{ $doc->no_ktp }}</span>
                </td>
                <td class="col-rekening">{{ $doc->no_rekening }}</td>
                <td class="col-jenis">{{ $doc->jenis_dokumen }}</td>
                <td class="col-status">
                  <span class="status-badge status-nik-duplicate">DUPLIKAT</span>
                </td>
                <td class="col-tanggal">{{ $doc->created_at->format('d/m/Y') }}</td>
                <td class="col-keterangan">
                  NIK terdaftar pada {{ $nikData['count'] }} dokumen
                </td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- SUMMARY -->
    @if ($expired->count() + $rejected->count() + $pendingLama->count() + count($nikDuplikat) > 0)
      <div class="summary-note">
        <strong>Total:</strong>
        {{ $expired->count() + $rejected->count() + $pendingLama->count() + count($nikDuplikat) }} dokumen
        • <strong>Expired:</strong> {{ $expired->count() }}
        • <strong>Ditolak:</strong> {{ $rejected->count() }}
        • <strong>Pending >7hr:</strong> {{ $pendingLama->count() }}
        • <strong>NIK Duplikat:</strong> {{ count($nikDuplikat) }}
      </div>
    @else
      <div class="empty-state">
        ✓ TIDAK ADA DOKUMEN BERMASALAH<br>
        <span style="font-size: 8pt; color: #666;">Semua dokumen dalam kondisi normal</span>
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
