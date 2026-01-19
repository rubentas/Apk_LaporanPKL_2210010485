<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Kategori Kredit - BRI KC Tanjung Tabalong</title>
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

    /* COLUMN WIDTHS - PORTRAIT */
    .col-no {
      width: 30px;
      text-align: center;
    }

    .col-kategori {
      width: 120px;
      word-wrap: break-word;
    }

    .col-total {
      width: 50px;
      text-align: center;
    }

    .col-pending {
      width: 50px;
      text-align: center;
    }

    .col-verified {
      width: 50px;
      text-align: center;
    }

    .col-rejected {
      width: 50px;
      text-align: center;
    }

    .col-expired {
      width: 50px;
      text-align: center;
    }

    .col-percentage {
      width: 60px;
      text-align: center;
    }

    /* BADGES - SIMPLE */
    .badge {
      display: inline-block;
      padding: 3px 6px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: bold;
      text-align: center;
      min-width: 40px;
    }

    .badge-total {
      background: #0033a0;
      color: white;
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

    /* TOTAL ROW STYLE */
    .total-row {
      font-weight: bold;
      background: #f0f0f0 !important;
      border-top: 2px solid #0033a0;
    }

    .total-row td {
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
    <!-- HEADER RESMI BRI  -->
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
      <div class="report-title">LAPORAN DOKUMEN PER KATEGORI KREDIT</div>
      <div class="report-subtitle">Sistem Arsip Digital Administrasi Kredit</div>
    </div>

    <!-- KATEGORI TABEL -->
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th class="col-no">No</th>
            <th class="col-kategori">Kategori Kredit</th>
            <th class="col-total">Total</th>
            <th class="col-pending">Pending</th>
            <th class="col-verified">Verified</th>
            <th class="col-rejected">Rejected</th>
            <th class="col-expired">Expired</th>
            <th class="col-percentage">%</th>
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
              <td class="col-no text-center">{{ $loop->iteration }}</td>
              <td class="col-kategori">{{ $data['label'] }}</td>
              <td class="col-total text-center">
                <span class="badge badge-total">{{ $data['total'] }}</span>
              </td>
              <td class="col-pending text-center">
                @if ($data['pending'] > 0)
                  <span class="badge badge-pending">{{ $data['pending'] }}</span>
                @else
                  -
                @endif
              </td>
              <td class="col-verified text-center">
                @if ($data['verified'] > 0)
                  <span class="badge badge-verified">{{ $data['verified'] }}</span>
                @else
                  -
                @endif
              </td>
              <td class="col-rejected text-center">
                @if ($data['rejected'] > 0)
                  <span class="badge badge-rejected">{{ $data['rejected'] }}</span>
                @else
                  -
                @endif
              </td>
              <td class="col-expired text-center">
                @if ($data['expired'] > 0)
                  <span class="badge badge-expired">{{ $data['expired'] }}</span>
                @else
                  -
                @endif
              </td>
              <td class="col-percentage text-center">
                {{ $data['percentage'] }}%
              </td>
            </tr>
          @endforeach

          <!-- TOTAL ROW -->
          <tr class="total-row">
            <td colspan="2" class="text-right"><strong>TOTAL</strong></td>
            <td class="col-total text-center">
              <span class="badge badge-total">{{ $summary['total_documents'] }}</span>
            </td>
            <td class="col-pending text-center">
              @if ($totalPending > 0)
                <span class="badge badge-pending">{{ $totalPending }}</span>
              @else
                -
              @endif
            </td>
            <td class="col-verified text-center">
              @if ($totalVerified > 0)
                <span class="badge badge-verified">{{ $totalVerified }}</span>
              @else
                -
              @endif
            </td>
            <td class="col-rejected text-center">
              @if ($totalRejected > 0)
                <span class="badge badge-rejected">{{ $totalRejected }}</span>
              @else
                -
              @endif
            </td>
            <td class="col-expired text-center">
              @if ($totalExpired > 0)
                <span class="badge badge-expired">{{ $totalExpired }}</span>
              @else
                -
              @endif
            </td>
            <td class="col-percentage text-center">100%</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
      <div>Dokumen ini dicetak secara otomatis dari sistem</div>
      <div style="margin-top: 5px; color: #999; font-size: 6.5pt;">
        {{ $summary['tanggal_cetak'] }} • BRI KC Tanjung Tabalong
      </div>
    </div>
  </div>
</body>

</html>
