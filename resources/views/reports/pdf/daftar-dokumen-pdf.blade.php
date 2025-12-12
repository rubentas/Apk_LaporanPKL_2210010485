<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Daftar Dokumen - BRI KC Tanjung Tabalong</title>

  <style>
    /* CSS untuk PDF - LANDSCAPE MODE */
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 10px;
      line-height: 1.3;
      margin: 0;
      padding: 10px;
    }

    .header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 2px solid #0033a0;
      padding-bottom: 8px;
    }

    .header h1 {
      color: #0033a0;
      margin: 0;
      font-size: 16px;
    }

    .header h2 {
      color: #333;
      margin: 3px 0;
      font-size: 13px;
    }

    .header h3 {
      color: #666;
      margin: 3px 0;
      font-size: 11px;
    }

    .info-box {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 3px;
      padding: 8px;
      margin-bottom: 12px;
      font-size: 9px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      /* PENTING: biar kolom tidak melebar */
      margin-top: 8px;
    }

    /* ATUR LEBAR KOLOM SECARA PROPORSI */
    .table th:nth-child(1),
    .table td:nth-child(1) {
      width: 3%;
    }

    /* No */

    .table th:nth-child(2),
    .table td:nth-child(2) {
      width: 5%;
    }

    /* ID Dokumen */

    .table th:nth-child(3),
    .table td:nth-child(3) {
      width: 16%;
    }

    /* Nama Nasabah */

    .table th:nth-child(4),
    .table td:nth-child(4) {
      width: 10%;
    }

    /* No Rekening */

    .table th:nth-child(5),
    .table td:nth-child(5) {
      width: 10%;
    }

    /* Jenis Dokumen */

    .table th:nth-child(6),
    .table td:nth-child(6) {
      width: 16%;
    }

    /* Kategori Kredit */

    .table th:nth-child(7),
    .table td:nth-child(7) {
      width: 8%;
    }

    /* Status */

    .table th:nth-child(8),
    .table td:nth-child(8) {
      width: 10%;
    }

    /* Tgl. Upload */

    .table th:nth-child(9),
    .table td:nth-child(9) {
      width: 12%;
    }

    /* Expired Date */

    .table th {
      background-color: #0033a0;
      color: white;
      padding: 5px 3px;
      text-align: left;
      border: 1px solid #ddd;
      font-size: 9px;
      font-weight: bold;
    }

    .table td {
      padding: 4px 3px;
      border: 1px solid #ddd;
      font-size: 8px;
      word-break: break-word;
      /* Potong kata panjang */
      overflow-wrap: break-word;
      /* Bungkus teks */
      vertical-align: top;
    }

    .table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .status-badge {
      display: inline-block;
      padding: 1px 4px;
      border-radius: 2px;
      font-size: 8px;
      font-weight: bold;
      white-space: nowrap;
    }

    .status-pending {
      background-color: #ffc107;
      color: #000;
    }

    .status-verified {
      background-color: #28a745;
      color: white;
    }

    .status-rejected {
      background-color: #dc3545;
      color: white;
    }

    .status-expired {
      background-color: #6c757d;
      color: white;
    }

    .footer {
      margin-top: 20px;
      padding-top: 8px;
      border-top: 1px solid #ddd;
      text-align: center;
      font-size: 8px;
      color: #666;
    }

    .filter-info {
      font-size: 9px;
      margin-bottom: 10px;
    }

    /* Untuk teks kecil dalam cell */
    small {
      font-size: 7px;
      color: #666;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <h1>PT BANK RAKYAT INDONESIA (PERSERO) Tbk.</h1>
    <h2>KC TANJUNG TABALONG</h2>
    <h3>SISTEM ARSIP DIGITAL ADMINISTRASI KREDIT</h3>
    <h3>LAPORAN DAFTAR DOKUMEN</h3>
  </div>

  <!-- Info Box -->
  <div class="info-box">
    <table width="100%">
      <tr>
        <td width="50%">
          <strong>Tanggal Cetak:</strong> {{ $tanggal_cetak }}<br>
          <strong>Jumlah Dokumen:</strong> {{ $documents->count() }}

          @if (isset($is_selected_report) && $is_selected_report)
            <br><strong>Tipe Laporan:</strong> <span style="color: #0033a0;">Dokumen Terpilih</span>
          @endif
        </td>
        <td width="50%">
          @if (isset($filter['status']) && $filter['status'])
            <strong>Status Filter:</strong> {{ ucfirst($filter['status']) }}<br>
          @endif
          @if (isset($filter['kategori_kredit']) && $filter['kategori_kredit'])
            <strong>Kategori Filter:</strong> {{ $filter['kategori_kredit'] }}
          @endif
        </td>
      </tr>
    </table>
  </div>

  <!-- Tabel Data -->
  <table class="table">
    <thead>
      <tr>
        <th width="30">No</th>
        <th width="100">ID Dokumen</th>
        <th>Nama Nasabah</th>
        <th width="100">No Rekening</th>
        <th width="90">Jenis Dokumen</th>
        <th width="120">Kategori Kredit</th>
        <th width="70">Status</th>
        <th width="80">Tgl. Upload</th>
        <th width="80">Expired Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($documents as $index => $document)
        <tr>
          <td align="center">{{ $loop->iteration }}</td>
          <td align="center">{{ $document->id }}</td>
          <td>{{ $document->nama_nasabah }}<br>
            <small>KTP: {{ $document->no_ktp }}</small>
          </td>
          <td>{{ $document->no_rekening }}</td>
          <td>{{ $document->jenis_dokumen }}</td>
          <td>{{ $document->kategori_kredit }}</td>
          <td>
            @php
              $statusClass = 'status-' . $document->status;
              $statusLabel = ucfirst($document->status);
            @endphp
            <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
          </td>
          <td>{{ $document->created_at->format('d/m/Y') }}</td>
          <td>
            @if ($document->expired_date)
              {{ $document->expired_date->format('d/m/Y') }}
              @if ($document->expired_date->isPast())
                <br><small class="status-badge status-expired">EXPIRED</small>
              @endif
            @else
              -
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Footer -->
  <div class="footer">
    <p>
      Laporan ini dibuat secara otomatis oleh Sistem Arsip Digital Administrasi Kredit<br>
      PT Bank Rakyat Indonesia (Persero) Tbk. KC Tanjung Tabalong
    </p>
    <p>
      Jl. A. Yani No. 123, Tanjung, Tabalong - Kalimantan Selatan<br>
      Telp: (0526) 123456 | Email: kctanjungtabalong@bri.co.id
    </p>
  </div>
</body>

</html>
