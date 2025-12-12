<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan per Nasabah - BRI</title>
  <style>
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 10px;
      line-height: 1.3;
    }

    .header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 3px solid #2c3e50;
      padding-bottom: 10px;
    }

    .header h1 {
      margin: 0;
      color: #2c3e50;
      font-size: 18px;
    }

    .header h2 {
      margin: 3px 0;
      color: #3498db;
      font-size: 14px;
    }

    .header h3 {
      margin: 3px 0;
      color: #7f8c8d;
      font-size: 12px;
    }

    .summary-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 8px;
      margin: 15px 0;
    }

    .summary-box {
      text-align: center;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f8f9fa;
    }

    .summary-value {
      font-size: 18px;
      font-weight: bold;
      color: #2c3e50;
      display: block;
    }

    .summary-label {
      font-size: 10px;
      color: #7f8c8d;
      text-transform: uppercase;
      display: block;
    }

    .nasabah-card {
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 12px;
      margin-bottom: 15px;
      page-break-inside: avoid;
    }

    .nasabah-header {
      background-color: #ecf0f1;
      padding: 8px;
      border-radius: 3px;
      margin-bottom: 8px;
    }

    .nasabah-name {
      font-weight: bold;
      color: #2c3e50;
      font-size: 13px;
      margin: 0 0 3px 0;
    }

    .nasabah-info {
      color: #7f8c8d;
      font-size: 9px;
      line-height: 1.4;
    }

    .nasabah-stats {
      margin: 8px 0;
    }

    .stat-badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 3px;
      font-size: 9px;
      font-weight: bold;
      margin-right: 5px;
      margin-bottom: 3px;
    }

    .stat-total {
      background-color: #3498db;
      color: white;
    }

    .stat-pending {
      background-color: #f39c12;
      color: white;
    }

    .stat-verified {
      background-color: #27ae60;
      color: white;
    }

    .stat-rejected {
      background-color: #e74c3c;
      color: white;
    }

    .stat-expired {
      background-color: #7f8c8d;
      color: white;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 9px;
    }

    table th {
      background-color: #2c3e50;
      color: white;
      padding: 6px 8px;
      text-align: left;
      font-weight: bold;
    }

    table td {
      padding: 5px 7px;
      border-bottom: 1px solid #eee;
    }

    table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .status-pending {
      color: #f39c12;
      font-weight: bold;
    }

    .status-verified {
      color: #27ae60;
      font-weight: bold;
    }

    .status-rejected {
      color: #e74c3c;
      font-weight: bold;
    }

    .status-expired {
      color: #7f8c8d;
      font-weight: bold;
    }

    .text-warning {
      color: #f39c12;
    }

    .text-danger {
      color: #e74c3c;
    }

    .footer {
      margin-top: 20px;
      padding-top: 8px;
      border-top: 1px solid #ddd;
      font-size: 8px;
      color: #7f8c8d;
      text-align: right;
    }

    .page-break {
      page-break-before: always;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .mb-1 {
      margin-bottom: 5px;
    }

    .mb-2 {
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <h1>PT BANK RAKYAT INDONESIA (PERSERO) Tbk</h1>
    <h2>KC TANJUNG TABALONG</h2>
    <h3>LAPORAN DOKUMEN PER NASABAH</h3>
    <p>Periode: {{ date('d/m/Y') }}</p>
  </div>

  <!-- Summary -->
  <div class="summary-grid">
    <div class="summary-box">
      <span class="summary-value">{{ count($nasabahData) }}</span>
      <span class="summary-label">Total Nasabah</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ array_sum(array_column($nasabahData, 'total_dokumen')) }}</span>
      <span class="summary-label">Total Dokumen</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ array_sum(array_column($nasabahData, 'verified')) }}</span>
      <span class="summary-label">Terverifikasi</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ array_sum(array_column($nasabahData, 'pending')) }}</span>
      <span class="summary-label">Pending</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ array_sum(array_column($nasabahData, 'rejected')) }}</span>
      <span class="summary-label">Ditolak</span>
    </div>
  </div>

  <!-- Data Nasabah -->
  @foreach ($nasabahData as $index => $nasabah)
    <div class="nasabah-card">
      <div class="nasabah-header">
        <div class="nasabah-name">
          {{ $index + 1 }}. {{ $nasabah['nama_nasabah'] }}
        </div>
        <div class="nasabah-info">
          <div class="mb-1">
            <strong>No. Rekening:</strong> {{ $nasabah['no_rekening'] }} |
            <strong>No. KTP:</strong> {{ $nasabah['no_ktp'] }} |
            <strong>Telp:</strong> {{ $nasabah['telepon'] }}
          </div>
          <div class="mb-1">
            <strong>Alamat:</strong> {{ $nasabah['alamat'] }}
          </div>
          @if ($nasabah['kategori_kredit'])
            <div>
              <strong>Kategori Kredit:</strong> {{ $nasabah['kategori_kredit'] }}
            </div>
          @endif
        </div>
      </div>

      <!-- Stats -->
      <div class="nasabah-stats">
        <span class="stat-badge stat-total">Total: {{ $nasabah['total_dokumen'] }}</span>
        <span class="stat-badge stat-pending">Pending: {{ $nasabah['pending'] }}</span>
        <span class="stat-badge stat-verified">Verified: {{ $nasabah['verified'] }}</span>
        <span class="stat-badge stat-rejected">Rejected: {{ $nasabah['rejected'] }}</span>
        <span class="stat-badge stat-expired">Expired: {{ $nasabah['expired'] }}</span>
      </div>

      <!-- Dokumen List -->
      @if ($nasabah['dokumen']->count() > 0)
        <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Jenis Dokumen</th>
              <th>Tgl. Dokumen</th>
              <th>Tgl. Expired</th>
              <th>Status</th>
              <th>Kategori</th>
              <th>Tgl. Upload</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($nasabah['dokumen'] as $docIndex => $doc)
              @php
                $expiredDate = $doc->expired_date ? \Carbon\Carbon::parse($doc->expired_date) : null;
                $isExpired = $expiredDate ? $expiredDate->isPast() : false;
                $isExpiringSoon = $expiredDate ? $expiredDate->diffInDays(now()) <= 30 : false;
              @endphp
              <tr>
                <td class="text-center">{{ $docIndex + 1 }}</td>
                <td>{{ $doc->jenis_dokumen }}</td>
                <td>{{ $doc->tanggal_dokumen ? \Carbon\Carbon::parse($doc->tanggal_dokumen)->format('d/m/Y') : '-' }}
                </td>
                <td>
                  @if ($expiredDate)
                    {{ $expiredDate->format('d/m/Y') }}
                    @if ($isExpired)
                      <span class="text-danger"> (EXPIRED)</span>
                    @elseif($isExpiringSoon)
                      <span class="text-warning"> (Soon)</span>
                    @endif
                  @else
                    -
                  @endif
                </td>
                <td class="status-{{ $doc->status }}">
                  {{ strtoupper($doc->status) }}
                </td>
                <td>{{ $doc->kategori_kredit }}</td>
                <td>{{ $doc->created_at->format('d/m/Y') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div style="text-align: center; padding: 15px; color: #7f8c8d;">
          Tidak ada dokumen untuk nasabah ini
        </div>
      @endif
    </div>

    @if (($index + 1) % 2 == 0 && !$loop->last)
      <div class="page-break"></div>
    @endif
  @endforeach

  <!-- Footer -->
  <div class="footer">
    <div>Dicetak pada: {{ $tanggal_cetak }}</div>
    <div>Oleh: Sistem Manajemen Arsip Digital BRI</div>
    <div>Halaman <span class="page-number"></span></div>
  </div>
</body>

</html>
