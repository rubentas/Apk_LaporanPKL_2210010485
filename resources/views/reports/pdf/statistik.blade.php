<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Statistik Dokumen - BRI</title>
  <style>
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 12px;
      line-height: 1.4;
    }

    .header {
      text-align: center;
      margin-bottom: 25px;
      border-bottom: 3px solid #2c3e50;
      padding-bottom: 15px;
    }

    .header h1 {
      margin: 0;
      color: #2c3e50;
      font-size: 22px;
    }

    .header h2 {
      margin: 5px 0;
      color: #3498db;
      font-size: 16px;
    }

    .header h3 {
      margin: 5px 0;
      color: #7f8c8d;
      font-size: 14px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin-bottom: 25px;
    }

    .stat-card {
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 15px;
      text-align: center;
      background: #f8f9fa;
    }

    .stat-card h4 {
      margin: 0 0 5px 0;
      font-size: 24px;
      color: #2c3e50;
    }

    .stat-card p {
      margin: 0;
      color: #7f8c8d;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .section-title {
      background-color: #ecf0f1;
      padding: 8px 12px;
      margin: 20px 0 10px;
      border-left: 4px solid #3498db;
      font-weight: bold;
      color: #2c3e50;
      font-size: 14px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table th {
      background-color: #34495e;
      color: white;
      padding: 10px;
      text-align: left;
      font-size: 11px;
      text-transform: uppercase;
    }

    table td {
      padding: 8px 10px;
      border-bottom: 1px solid #ddd;
    }

    table tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .badge {
      padding: 3px 8px;
      border-radius: 3px;
      font-size: 10px;
      font-weight: bold;
    }

    .badge-pending {
      background: #f39c12;
      color: white;
    }

    .badge-verified {
      background: #27ae60;
      color: white;
    }

    .badge-rejected {
      background: #e74c3c;
      color: white;
    }

    .badge-expired {
      background: #7f8c8d;
      color: white;
    }

    .footer {
      margin-top: 40px;
      padding-top: 15px;
      border-top: 1px solid #ddd;
      font-size: 10px;
      color: #7f8c8d;
      text-align: right;
    }

    .page-break {
      page-break-before: always;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <h1>PT BANK RAKYAT INDONESIA (PERSERO) Tbk</h1>
    <h2>KC TANJUNG TABALONG</h2>
    <h3>LAPORAN STATISTIK DOKUMEN ADMINISTRASI KREDIT</h3>
    <p>Periode: {{ date('d/m/Y') }}</p>
  </div>

  <!-- Statistik Cards -->
  <div class="section-title">Ringkasan Statistik</div>
  <div class="stats-grid">
    <div class="stat-card">
      <h4>{{ number_format($stats->total) }}</h4>
      <p>Total Dokumen</p>
    </div>
    <div class="stat-card">
      <h4>{{ number_format($stats->pending) }}</h4>
      <p>Pending</p>
    </div>
    <div class="stat-card">
      <h4>{{ number_format($stats->verified) }}</h4>
      <p>Terverifikasi</p>
    </div>
    <div class="stat-card">
      <h4>{{ number_format($stats->rejected) }}</h4>
      <p>Ditolak</p>
    </div>
    <div class="stat-card">
      <h4>{{ number_format($stats->expired) }}</h4>
      <p>Expired</p>
    </div>
    <div class="stat-card">
      <h4>{{ number_format($stats->expiring_soon) }}</h4>
      <p>Hampir Expired</p>
    </div>
  </div>

  <!-- Distribusi Status -->
  <div class="section-title">Distribusi Status Dokumen</div>
  <table>
    <thead>
      <tr>
        <th>Status</th>
        <th>Jumlah</th>
        <th class="text-right">Persentase</th>
      </tr>
    </thead>
    <tbody>
      @php
        $total = $stats->total;
        $statuses = [
            ['label' => 'Pending', 'value' => $stats->pending, 'class' => 'badge-pending'],
            ['label' => 'Verified', 'value' => $stats->verified, 'class' => 'badge-verified'],
            ['label' => 'Rejected', 'value' => $stats->rejected, 'class' => 'badge-rejected'],
            ['label' => 'Expired', 'value' => $stats->expired, 'class' => 'badge-expired'],
        ];
      @endphp
      @foreach ($statuses as $status)
        <tr>
          <td>
            <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
          </td>
          <td>{{ number_format($status['value']) }}</td>
          <td class="text-right">
            @if ($total > 0)
              {{ number_format(($status['value'] / $total) * 100, 1) }}%
            @else
              0%
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Trend Bulanan -->
  <div class="section-title">Trend Dokumen (6 Bulan Terakhir)</div>
  <table>
    <thead>
      <tr>
        <th>Bulan</th>
        <th>Total Dokumen</th>
        <th>Terverifikasi</th>
        <th class="text-right">% Verifikasi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($monthlyData as $month)
        <tr>
          <td>{{ $month->month }}</td>
          <td class="text-center">{{ $month->total }}</td>
          <td class="text-center">{{ $month->verified }}</td>
          <td class="text-right">
            @if ($month->total > 0)
              {{ number_format(($month->verified / $month->total) * 100, 1) }}%
            @else
              0%
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Top Kategori -->
  <div class="section-title">Top 5 Kategori Kredit</div>
  <table>
    <thead>
      <tr>
        <th>Rank</th>
        <th>Kategori Kredit</th>
        <th>Jumlah Dokumen</th>
        <th class="text-right">Persentase</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($topKategori as $index => $kategori)
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          <td>{{ $kategori->kategori_kredit ?? 'Tidak Terkategori' }}</td>
          <td class="text-center">{{ number_format($kategori->total) }}</td>
          <td class="text-right">
            @if ($stats->total > 0)
              {{ number_format(($kategori->total / $stats->total) * 100, 1) }}%
            @else
              0%
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Dokumen Hampir Expired -->
  @if ($expiringSoon->count() > 0)
    <div class="section-title">Dokumen Hampir Expired (30 Hari)</div>
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Nasabah</th>
          <th>No. Rekening</th>
          <th>Jenis Dokumen</th>
          <th>Tgl Expired</th>
          <th>Sisa Hari</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expiringSoon as $doc)
          @php
            $daysLeft = \Carbon\Carbon::parse($doc->expired_date)->diffInDays(now(), false) * -1;
          @endphp
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $doc->nama_nasabah }}</td>
            <td>{{ $doc->no_rekening }}</td>
            <td>{{ $doc->jenis_dokumen }}</td>
            <td>{{ \Carbon\Carbon::parse($doc->expired_date)->format('d/m/Y') }}</td>
            <td class="text-center">
              @if ($daysLeft > 0)
                {{ $daysLeft }} hari
              @else
                <strong>EXPIRED</strong>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <!-- Footer -->
  <div class="footer">
    <div>Dicetak pada: {{ $tanggal_cetak }}</div>
    <div>Oleh: Sistem Manajemen Arsip Digital BRI</div>
    <div>Halaman 1/1</div>
  </div>
</body>

</html>
