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

    /* HEADER */
    .header {
      text-align: center;
      margin-bottom: 15px;
      padding-bottom: 8px;
    }

    .bank-name {
      color: #0033a0;
      font-size: 12pt;
      font-weight: bold;
      margin-bottom: 2px;
    }

    .branch-name {
      color: #0033a0;
      font-size: 11pt;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .report-title {
      color: #333;
      font-size: 10pt;
      font-weight: bold;
      margin-top: 8px;
      padding-top: 8px;
      border-top: 1px solid #eee;
    }

    .system-name {
      color: #666;
      font-size: 8pt;
      margin-top: 2px;
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
  </style>
</head>

<body>

  <!-- HEADER -->
  <div class="header">
    <div class="bank-name">BANK RAKYAT INDONESIA</div>
    <div class="branch-name">KC TANJUNG TABALONG</div>
    <div class="report-title">LAPORAN DAFTAR DOKUMEN</div>
    <div class="system-name">Sistem Arsip Digital Administrasi Kredit</div>
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
