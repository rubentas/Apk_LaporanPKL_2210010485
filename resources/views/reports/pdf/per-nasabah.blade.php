<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Nasabah - BRI KC Tanjung Tabalong</title>
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
      color: #0033a0;
      font-size: 11pt;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .header h3 {
      color: #333;
      font-size: 10pt;
      margin-top: 8px;
    }

    /* NASABAH CARD - CLEAN */
    .nasabah-card {
      border: 1px solid #e0e0e0;
      border-radius: 4px;
      padding: 10px;
      margin-bottom: 15px;
      page-break-inside: avoid;
    }

    .nasabah-header {
      margin-bottom: 8px;
      padding-bottom: 8px;
      border-bottom: 1px solid #eee;
    }

    .nasabah-name {
      font-weight: bold;
      color: #0033a0;
      font-size: 10pt;
      margin-bottom: 3px;
    }

    .nasabah-info {
      font-size: 8pt;
      color: #666;
      line-height: 1.4;
    }

    .info-row {
      margin-bottom: 2px;
    }

    /* STATS BADGES - COMPACT */
    .stats-row {
      display: flex;
      gap: 6px;
      margin: 8px 0;
      flex-wrap: wrap;
    }

    .stat-badge {
      padding: 3px 6px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: bold;
    }

    .stat-total {
      background: #0033a0;
      color: white;
    }

    .stat-pending {
      background: #ffc107;
      color: #000;
    }

    .stat-verified {
      background: #28a745;
      color: white;
    }

    .stat-rejected {
      background: #dc3545;
      color: white;
    }

    .stat-expired {
      background: #6c757d;
      color: white;
    }

    /* TABLE - CLEAN */
    .table-container {
      margin-top: 8px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
    }

    table th {
      background: #0033a0;
      color: white;
      padding: 6px 5px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
    }

    table td {
      padding: 5px 5px;
      border: 1px solid #e0e0e0;
    }

    table tr:nth-child(even) {
      background: #f9f9f9;
    }

    /* COLUMN ALIGNMENT */
    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    /* STATUS COLORS */
    .status-pending {
      color: #ffc107;
      font-weight: bold;
    }

    .status-verified {
      color: #28a745;
      font-weight: bold;
    }

    .status-rejected {
      color: #dc3545;
      font-weight: bold;
    }

    .status-expired {
      color: #6c757d;
      font-weight: bold;
    }

    /* EXPIRY INDICATORS */
    .expired-badge {
      background: #dc3545;
      color: white;
      padding: 1px 4px;
      border-radius: 2px;
      font-size: 7pt;
      font-weight: bold;
      margin-left: 3px;
    }

    .soon-badge {
      background: #ffc107;
      color: #000;
      padding: 1px 4px;
      border-radius: 2px;
      font-size: 7pt;
      font-weight: bold;
      margin-left: 3px;
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
    .no-data {
      text-align: center;
      padding: 15px;
      color: #999;
      font-style: italic;
      font-size: 9pt;
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <div class="header">
    <h1>BRI KC TANJUNG TABALONG</h1>
    <h2>Laporan Dokumen per Nasabah</h2>
    <h3>Sistem Arsip Digital Administrasi Kredit</h3>
  </div>

  <!-- NASABAH LIST -->
  @foreach ($nasabahData as $index => $nasabah)
    <div class="nasabah-card">
      <!-- NASABAH HEADER -->
      <div class="nasabah-header">
        <div class="nasabah-name">
          {{ $index + 1 }}. {{ $nasabah['nama_nasabah'] }}
        </div>
        <div class="nasabah-info">
          <div class="info-row">
            <strong>No. Rekening:</strong> {{ $nasabah['no_rekening'] }} |
            <strong>No. KTP:</strong> {{ $nasabah['no_ktp'] }}
          </div>
          <div class="info-row">
            <strong>Alamat:</strong> {{ $nasabah['alamat'] }}
          </div>
          @if ($nasabah['kategori_kredit'])
            <div class="info-row">
              <strong>Kategori:</strong> {{ $nasabah['kategori_kredit'] }}
            </div>
          @endif
        </div>
      </div>

      <!-- STATS -->
      <div class="stats-row">
        <span class="stat-badge stat-total">Total: {{ $nasabah['total_dokumen'] }}</span>
        <span class="stat-badge stat-pending">Pending: {{ $nasabah['pending'] }}</span>
        <span class="stat-badge stat-verified">Verified: {{ $nasabah['verified'] }}</span>
        <span class="stat-badge stat-rejected">Rejected: {{ $nasabah['rejected'] }}</span>
        <span class="stat-badge stat-expired">Expired: {{ $nasabah['expired'] }}</span>
      </div>

      <!-- DOKUMEN LIST -->
      @if ($nasabah['dokumen']->count() > 0)
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th width="30">#</th>
                <th>Jenis Dokumen</th>
                <th width="70">Tgl Dokumen</th>
                <th width="80">Expired</th>
                <th width="70">Status</th>
                <th width="80">Tgl Upload</th>
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
                  <td class="text-center">
                    {{ $doc->tanggal_dokumen ? \Carbon\Carbon::parse($doc->tanggal_dokumen)->format('d/m/Y') : '-' }}
                  </td>
                  <td class="text-center">
                    @if ($expiredDate)
                      {{ $expiredDate->format('d/m/Y') }}
                      @if ($isExpired)
                        <span class="expired-badge">EXP</span>
                      @elseif($isExpiringSoon)
                        <span class="soon-badge">SOON</span>
                      @endif
                    @else
                      -
                    @endif
                  </td>
                  <td class="text-center status-{{ $doc->status }}">
                    {{ strtoupper($doc->status) }}
                  </td>
                  <td class="text-center">{{ $doc->created_at->format('d/m/Y') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="no-data">
          Tidak ada dokumen untuk nasabah ini
        </div>
      @endif
    </div>
  @endforeach

  <!-- FOOTER -->
  <div class="footer">
    <div>Dokumen ini dicetak secara otomatis dari sistem</div>
    <div style="margin-top: 5px; color: #999; font-size: 7pt;">
      {{ $tanggal_cetak }} • BRI KC Tanjung Tabalong
    </div>
  </div>

</body>

</html>
