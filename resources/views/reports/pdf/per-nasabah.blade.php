<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Nasabah - BRI KC Tanjung Tabalong</title>
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
      background: #fff;
    }

    .page-container {
      padding: 15mm;
      page-break-inside: avoid;
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
      page-break-after: avoid;
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

    /* TABLE - CLEAN DENGAN PAGE BREAK SUPPORT */
    .table-container {
      margin-top: 10px;
      page-break-inside: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
      page-break-inside: auto;
    }

    table thead {
      display: table-header-group;
    }

    table thead th {
      background: #0033a0;
      color: white;
      padding: 8px 6px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
    }

    table tbody {
      display: table-row-group;
    }

    table tbody td {
      padding: 7px 6px;
      border: 1px solid #e0e0e0;
      vertical-align: top;
      page-break-inside: avoid;
      page-break-before: auto;
      background: #ffffff;
    }

    table tbody tr {
      page-break-inside: avoid;
      page-break-after: auto;
    }

    table tbody tr:nth-child(even) {
      background: #ffffff;
    }

    /* GROUP ROW UNTUK NASABAH SAMA - TIDAK BISA TERPOTONG */
    .nasabah-group {
      border-top: 2px solid #0033a0;
      page-break-inside: avoid;
      page-break-before: auto;
    }

    .nasabah-header-row td {
      background: #ffffff;
      font-weight: bold;
      border-bottom: 1px solid #0033a0;
      page-break-inside: avoid;
    }

    /* KEEP WITH NEXT UNTUK HEADER NASABAH */
    .keep-with-next {
      page-break-after: avoid;
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
      word-wrap: break-word;
      white-space: normal;
    }

    .col-ktp {
      width: 110px;
    }

    .col-alamat {
      width: 150px;
      word-wrap: break-word;
    }

    .col-jenis {
      width: 100px;
    }

    .col-tanggal {
      width: 70px;
      text-align: center;
    }

    .col-expired {
      width: 80px;
      text-align: center;
    }

    .col-status {
      width: 80px;
      text-align: center;
    }

    .col-upload {
      width: 80px;
      text-align: center;
    }

    /* STATUS BADGES - TEKS BIASA TANPA BACKGROUND */
    .status-badge {
      display: inline-block;
      padding: 3px 6px;
      font-size: 8pt;
      font-weight: normal;
      text-align: center;
      min-width: 60px;
      border-radius: 0;
      background: none !important;
    }

    .status-pending {
      color: #000000;
    }

    .status-verified {
      color: #000000;
    }

    .status-rejected {
      color: #000000;
    }

    .status-expired {
      color: #000000;
    }

    /* EXPIRY INDICATORS */
    .expired-tag {
      background: #dc3545;
      color: white;
      padding: 1px 4px;
      border-radius: 2px;
      font-size: 7pt;
      font-weight: bold;
      margin-left: 3px;
    }

    .soon-tag {
      background: #ffc107;
      color: #000;
      padding: 1px 4px;
      border-radius: 2px;
      font-size: 7pt;
      font-weight: bold;
      margin-left: 3px;
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
      background: #ffffff;
      page-break-inside: avoid;
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
      page-break-before: avoid;
    }

    /* UTILITY */
    .text-center {
      text-align: center;
    }

    .small-text {
      font-size: 7pt;
      color: #666;
      display: block;
    }

    /* PAGE BREAK CONTROL */
    .page-break {
      page-break-before: always;
    }

    .no-break {
      page-break-inside: avoid;
    }

    .break-before {
      page-break-before: always;
    }

    .break-after {
      page-break-after: always;
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
      <div class="report-title">LAPORAN DOKUMEN PER NASABAH</div>
      <div class="report-subtitle">Sistem Arsip Digital Administrasi Kredit</div>
    </div>

    <!-- TABLE -->
    <div class="table-container">
      @if (count($nasabahData) > 0)
        <table>
          <thead>
            <tr>
              <th class="col-no">No</th>
              <th class="col-nasabah">Nasabah</th>
              <th class="col-rekening">No. Rekening</th>
              <th class="col-ktp">No. KTP</th>
              <th class="col-alamat">Alamat</th>
              <th class="col-jenis">Jenis Dokumen</th>
              <th class="col-tanggal">Tgl Dokumen</th>
              <th class="col-expired">Expired</th>
              <th class="col-status">Status</th>
              <th class="col-upload">Tgl Upload</th>
            </tr>
          </thead>
          <tbody>
            @php
              $globalIndex = 1;
              $rowCount = 0;
            @endphp

            @foreach ($nasabahData as $nasabah)
              <!-- HEADER ROW UNTUK NASABAH - TIDAK BOLEH TERPOTONG -->
              <tr class="nasabah-group keep-with-next">
                <td colspan="10" class="nasabah-header-row">
                  {{ $globalIndex }}. {{ $nasabah['nama_nasabah'] }}
                  @if ($nasabah['kategori_kredit'])
                    <span style="color: #666; font-weight: normal;"> | Kategori:
                      {{ $nasabah['kategori_kredit'] }}</span>
                  @endif
                </td>
              </tr>

              <!-- DOKUMEN UNTUK NASABAH INI -->
              @if ($nasabah['dokumen']->count() > 0)
                @foreach ($nasabah['dokumen'] as $docIndex => $doc)
                  @php
                    $expiredDate = $doc->expired_date ? \Carbon\Carbon::parse($doc->expired_date) : null;
                    $isExpired = $expiredDate ? $expiredDate->isPast() : false;
                    $isExpiringSoon = $expiredDate ? $expiredDate->diffInDays(now()) <= 30 : false;
                    $rowCount++;
                  @endphp

                  <!-- CEK JIKA PERLU PAGE BREAK (setiap ~25 baris) -->
                  @if ($rowCount % 25 == 0 && !$loop->first)
          </tbody>
        </table>
        <!-- PAGE BREAK -->
        <div class="page-break"></div>
        <!-- TABEL BARU DENGAN HEADER -->
        <table>
          <thead>
            <tr>
              <th class="col-no">No</th>
              <th class="col-nasabah">Nasabah</th>
              <th class="col-rekening">No. Rekening</th>
              <th class="col-ktp">No. KTP</th>
              <th class="col-alamat">Alamat</th>
              <th class="col-jenis">Jenis Dokumen</th>
              <th class="col-tanggal">Tgl Dokumen</th>
              <th class="col-expired">Expired</th>
              <th class="col-status">Status</th>
              <th class="col-upload">Tgl Upload</th>
            </tr>
          </thead>
          <tbody>
            <!-- ULANGI HEADER NASABAH JIKA TERPOTONG -->
            <tr class="nasabah-group">
              <td colspan="10" class="nasabah-header-row">
                {{ $globalIndex }}. {{ $nasabah['nama_nasabah'] }} (lanjutan)
                @if ($nasabah['kategori_kredit'])
                  <span style="color: #666; font-weight: normal;"> | Kategori: {{ $nasabah['kategori_kredit'] }}</span>
                @endif
              </td>
            </tr>
      @endif

      <tr>
        <td class="col-no text-center">{{ $globalIndex }}</td>
        <td class="col-nasabah">
          @if ($docIndex === 0)
            {{ $nasabah['nama_nasabah'] }}
          @endif
        </td>
        <td class="col-rekening">
          @if ($docIndex === 0)
            {{ $nasabah['no_rekening'] }}
          @endif
        </td>
        <td class="col-ktp">
          @if ($docIndex === 0)
            {{ $nasabah['no_ktp'] }}
          @endif
        </td>
        <td class="col-alamat">
          @if ($docIndex === 0 && $nasabah['alamat'])
            {{ Str::limit($nasabah['alamat'], 40) }}
          @endif
        </td>
        <td class="col-jenis">{{ $doc->jenis_dokumen }}</td>
        <td class="col-tanggal">
          {{ $doc->tanggal_dokumen ? \Carbon\Carbon::parse($doc->tanggal_dokumen)->format('d/m/Y') : '-' }}
        </td>
        <td class="col-expired">
          @if ($expiredDate)
            {{ $expiredDate->format('d/m/Y') }}
            @if ($isExpired)
              <span class="expired-tag">EXP</span>
            @elseif($isExpiringSoon)
              <span class="soon-tag">SOON</span>
            @endif
          @else
            -
          @endif
        </td>
        <td class="col-status">
          <span class="status-badge status-{{ $doc->status }}">
            {{ strtoupper($doc->status) }}
          </span>
        </td>
        <td class="col-upload">{{ $doc->created_at->format('d/m/Y') }}</td>
      </tr>
      @php $globalIndex++; @endphp
      @endforeach
    @else
      <tr>
        <td colspan="10" class="text-center" style="color: #999; font-style: italic; padding: 15px;">
          Tidak ada dokumen untuk nasabah ini
        </td>
      </tr>
      @endif
      @endforeach
      </tbody>
      </table>
    @else
      <div class="empty-state">
        Tidak ada data nasabah yang ditemukan
      </div>
      @endif
    </div>

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
