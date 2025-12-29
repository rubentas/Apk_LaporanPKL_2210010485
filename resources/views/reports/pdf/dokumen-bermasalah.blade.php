<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Dokumen Bermasalah - BRI KC Tanjung Tabalong</title>
  <style>
    /* RESET & BASE */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      font-size: 9pt;
      line-height: 1.3;
      color: #333;
      margin: 0;
      padding: 15mm;
      background: #fff;
    }

    /* HEADER - CLEAN */
    .header {
      text-align: center;
      margin-bottom: 15px;
      padding-bottom: 10px;
    }

    .header h1 {
      color: #0033a0;
      font-size: 12pt;
      font-weight: bold;
      margin-bottom: 2px;
    }

    .header h2 {
      color: #dc3545;
      font-size: 11pt;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .header h3 {
      color: #333;
      font-size: 10pt;
      margin-top: 8px;
    }

    /* SECTION - CLEAN */
    .section {
      margin: 20px 0;
      page-break-inside: avoid;
    }

    .section-title {
      padding: 8px;
      margin-bottom: 10px;
      font-weight: bold;
      font-size: 10pt;
      border-left: 4px solid;
    }

    .section-expired {
      border-left-color: #dc3545;
      background: #f8d7da;
      color: #721c24;
    }

    .section-rejected {
      border-left-color: #ffc107;
      background: #fff3cd;
      color: #856404;
    }

    .section-pending {
      border-left-color: #17a2b8;
      background: #d1ecf1;
      color: #0c5460;
    }

    .section-nik {
      border-left-color: #6f42c1;
      background: #e2d9f3;
      color: #4a3c6e;
    }

    /* TABLE - CLEAN */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
      font-size: 8pt;
    }

    table th {
      background: #0033a0;
      color: white;
      padding: 7px 6px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
    }

    table td {
      padding: 6px 6px;
      border: 1px solid #e0e0e0;
    }

    table tr:nth-child(even) {
      background: #f9f9f9;
    }

    /* BADGES - SIMPLE */
    .badge {
      padding: 3px 6px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: bold;
      display: inline-block;
    }

    .badge-expired {
      background: #dc3545;
      color: white;
    }

    .badge-rejected {
      background: #ffc107;
      color: #000;
    }

    .badge-pending {
      background: #17a2b8;
      color: white;
    }

    /* NIK DUPLIKAT - SIMPLIFIED */
    .nik-section {
      background: #f8f9fa;
      padding: 10px;
      margin: 15px 0;
      border-radius: 4px;
      border-left: 4px solid #6f42c1;
    }

    .nik-title {
      font-weight: bold;
      color: #6f42c1;
      margin-bottom: 8px;
      font-size: 10pt;
    }

    .nik-item {
      margin-bottom: 10px;
      padding: 8px;
      background: white;
      border-radius: 3px;
      border: 1px solid #e0e0e0;
    }

    .nik-nik {
      font-weight: bold;
      color: #333;
      margin-bottom: 3px;
    }

    .nik-info {
      font-size: 8pt;
      color: #666;
    }

    /* EMPTY STATE */
    .empty-state {
      text-align: center;
      padding: 40px;
      color: #28a745;
      font-weight: bold;
      font-size: 10pt;
    }

    /* FOOTER - MINIMAL */
    .footer {
      margin-top: 20px;
      padding-top: 8px;
      border-top: 1px solid #ddd;
      text-align: center;
      font-size: 8pt;
      color: #666;
    }

    /* UTILITY */
    .text-center {
      text-align: center;
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <div class="header">
    <h1>BRI KC TANJUNG TABALONG</h1>
    <h2>Laporan Dokumen Bermasalah</h2>
    <h3>Sistem Arsip Digital Administrasi Kredit</h3>
  </div>

  @if ($summary['total'] == 0 && count($nikDuplikat) == 0)
    <div class="empty-state">
      ✓ TIDAK ADA DOKUMEN BERMASALAH<br>
      <span style="font-size: 8pt; color: #666;">Semua dokumen dalam kondisi normal</span>
    </div>
  @endif

  <!-- DOKUMEN EXPIRED -->
  @if ($expired->count() > 0)
    <div class="section">
      <div class="section-title section-expired">
        DOKUMEN EXPIRED ({{ $expired->count() }})
      </div>
      <table>
        <thead>
          <tr>
            <th width="30">No</th>
            <th>Nasabah</th>
            <th width="80">No. Rekening</th>
            <th>Jenis Dokumen</th>
            <th width="70">Expired</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($expired as $doc)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td>{{ $doc->nama_nasabah }}</td>
              <td>{{ $doc->no_rekening }}</td>
              <td>{{ $doc->jenis_dokumen }}</td>
              <td class="text-center">
                <span class="badge badge-expired">
                  {{ $doc->expired_date->format('d/m/Y') }}
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <!-- DOKUMEN REJECTED -->
  @if ($rejected->count() > 0)
    <div class="section">
      <div class="section-title section-rejected">
        DOKUMEN DITOLAK ({{ $rejected->count() }})
      </div>
      <table>
        <thead>
          <tr>
            <th width="30">No</th>
            <th>Nasabah</th>
            <th width="80">No. Rekening</th>
            <th>Jenis Dokumen</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rejected as $doc)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td>{{ $doc->nama_nasabah }}</td>
              <td>{{ $doc->no_rekening }}</td>
              <td>{{ $doc->jenis_dokumen }}</td>
              <td>{{ $doc->catatan ? Str::limit($doc->catatan, 30) : '-' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <!-- PENDING LAMA -->
  @if ($pendingLama->count() > 0)
    <div class="section">
      <div class="section-title section-pending">
        PENDING >7 HARI ({{ $pendingLama->count() }})
      </div>
      <table>
        <thead>
          <tr>
            <th width="30">No</th>
            <th>Nasabah</th>
            <th width="80">No. Rekening</th>
            <th>Jenis Dokumen</th>
            <th width="70">Tgl Upload</th>
            <th width="50">Hari</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pendingLama as $doc)
            @php
              $daysPending = $doc->created_at->diffInDays(now());
            @endphp
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td>{{ $doc->nama_nasabah }}</td>
              <td>{{ $doc->no_rekening }}</td>
              <td>{{ $doc->jenis_dokumen }}</td>
              <td class="text-center">{{ $doc->created_at->format('d/m/Y') }}</td>
              <td class="text-center">
                <span class="badge badge-pending">{{ $daysPending }}</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <!-- NIK DUPLIKAT -->
  @if (count($nikDuplikat) > 0)
    <div class="nik-section">
      <div class="nik-title">
        NIK DUPLIKAT ({{ count($nikDuplikat) }})
      </div>
      @foreach ($nikDuplikat as $index => $data)
        <div class="nik-item">
          <div class="nik-nik">NIK: {{ $data['nik'] }} • {{ $data['count'] }} dokumen</div>
          <div class="nik-info">
            <strong>Nama:</strong> {{ implode(', ', $data['names']) }}
          </div>
        </div>
      @endforeach
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
