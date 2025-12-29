<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Kredit Akan Selesai - BRI</title>
  <style>
    @page {
      margin: 15px 20px;
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 10px;
    }

    .header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 3px solid #0033a0;
      padding-bottom: 8px;
    }

    .header h1 {
      color: #0033a0;
      font-size: 16px;
      margin: 3px 0;
      font-weight: bold;
    }

    .header h2 {
      color: #333;
      font-size: 12px;
      margin: 2px 0;
    }

    .summary-box {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      padding: 8px;
      margin-bottom: 10px;
    }

    .summary-item {
      display: inline-block;
      width: 24%;
      text-align: center;
    }

    .summary-value {
      font-size: 13px;
      font-weight: bold;
      color: #0033a0;
    }

    .summary-label {
      font-size: 9px;
      color: #6c757d;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
      font-size: 9px;
    }

    table th {
      background-color: #0033a0;
      color: white;
      text-align: left;
      padding: 5px;
      border: 1px solid #dee2e6;
    }

    table td {
      padding: 4px 5px;
      border: 1px solid #dee2e6;
    }

    .badge {
      display: inline-block;
      padding: 1px 5px;
      font-size: 8px;
      border-radius: 3px;
    }

    .badge-success {
      background-color: #28a745;
      color: white;
    }

    .badge-warning {
      background-color: #ffc107;
      color: #212529;
    }

    .badge-danger {
      background-color: #dc3545;
      color: white;
    }

    .badge-info {
      background-color: #17a2b8;
      color: white;
    }

    .footer {
      margin-top: 15px;
      padding-top: 8px;
      border-top: 1px solid #dee2e6;
      text-align: center;
      font-size: 8px;
      color: #6c757d;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <div><strong>PT BANK RAKYAT INDONESIA (PERSERO) Tbk</strong><br><small>KC TANJUNG TABALONG</small></div>
    <h1>LAPORAN KREDIT AKAN SELESAI</h1>
    <h2>Periode: {{ $tahun_ini }} - {{ $tahun_depan }}</h2>
  </div>

  <!-- Summary -->
  <div class="summary-box">
    <div class="summary-item">
      <div class="summary-value">{{ $stats['total'] }}</div>
      <div class="summary-label">Total Kredit</div>
    </div>
    <div class="summary-item">
      <div class="summary-value">{{ $stats['tahun_ini'] }}</div>
      <div class="summary-label">Selesai {{ $tahun_ini }}</div>
    </div>
    <div class="summary-item">
      <div class="summary-value">{{ $stats['tahun_depan'] }}</div>
      <div class="summary-label">Selesai {{ $tahun_depan }}</div>
    </div>
    <div class="summary-item">
      <div class="summary-value">Rp {{ number_format($stats['total_nominal'], 0, ',', '.') }}</div>
      <div class="summary-label">Total Nominal</div>
    </div>
  </div>

  <!-- Filter Info -->
  @if (isset($filter['kategori']) && $filter['kategori'])
    <div style="background-color: #fff3cd; padding: 4px 8px; margin-bottom: 8px; border-radius: 3px; font-size: 9px;">
      <strong>Filter:</strong> Kategori: {{ $filter['kategori'] }}
      @if (isset($filter['tahun']) && $filter['tahun'])
        | Tahun: {{ $filter['tahun'] }}
      @endif
    </div>
  @endif

  <!-- Table -->
  @if ($documents->count() > 0)
    <table>
      <thead>
        <tr>
          <th width="3%">No</th>
          <th width="15%">Nasabah</th>
          <th width="10%">No Rekening</th>
          <th width="12%">Kategori Kredit</th>
          <th width="12%">Nominal Kredit</th>
          <th width="8%">Tahun Pengajuan</th>
          <th width="6%">Tenor</th>
          <th width="8%">Estimasi Selesai</th>
          <th width="10%">Sisa Waktu</th>
          <th width="8%">Status Riwayat</th>
          <th width="8%">Suku Bunga</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($documents as $doc)
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $doc->nama_nasabah }}</td>
            <td>{{ $doc->no_rekening }}</td>
            <td>{{ $doc->kategori_kredit }}</td>
            <td>Rp {{ number_format($doc->nominal_kredit, 0, ',', '.') }}</td>
            <td class="text-center">{{ $doc->tahun_pengajuan }}</td>
            <td class="text-center">{{ $doc->tenor }} bln</td>
            <td class="text-center">
              <span class="badge {{ $doc->estimasi_selesai == $tahun_ini ? 'badge-success' : 'badge-warning' }}">
                {{ $doc->estimasi_selesai }}
              </span>
            </td>
            <td class="text-center">
              @php $sisa = $doc->estimasi_selesai - $tahun_ini; @endphp
              @if ($sisa == 0)
                <span class="badge badge-danger">Tahun ini</span>
              @else
                <span class="badge badge-info">{{ $sisa }} tahun</span>
              @endif
            </td>
            <td class="text-center">
              @if ($doc->status_riwayat == 'bersih')
                <span class="badge badge-success">Bersih</span>
              @elseif($doc->status_riwayat == 'pernah_telat')
                <span class="badge badge-warning">P.Telat</span>
              @else
                <span class="badge badge-danger">Masalah</span>
              @endif
            </td>
            <td class="text-center">{{ $doc->suku_bunga }}%</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <div style="text-align: center; padding: 20px; color: #666; font-size: 11px;">
      <i>Tidak ada data kredit yang akan selesai dalam periode {{ $tahun_ini }} - {{ $tahun_depan }}</i>
    </div>
  @endif

  <!-- Footer -->
  <div class="footer">
    Laporan ini digunakan untuk monitoring kredit yang akan selesai dalam 2 tahun ke depan.
  </div>
</body>

</html>
