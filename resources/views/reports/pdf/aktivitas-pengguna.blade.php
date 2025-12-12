<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Aktivitas Pengguna - BRI</title>
  <style>
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 9px;
      line-height: 1.2;
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

    .filter-info {
      background-color: #f8f9fa;
      padding: 8px;
      border-radius: 3px;
      margin-bottom: 10px;
      font-size: 8px;
    }

    .summary-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 5px;
      margin: 10px 0;
    }

    .summary-box {
      text-align: center;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 3px;
      background-color: #f8f9fa;
    }

    .summary-value {
      font-size: 14px;
      font-weight: bold;
      color: #2c3e50;
      display: block;
    }

    .summary-label {
      font-size: 8px;
      color: #7f8c8d;
      text-transform: uppercase;
      display: block;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 8px;
    }

    table th {
      background-color: #2c3e50;
      color: white;
      padding: 6px 8px;
      text-align: left;
      font-weight: bold;
    }

    table td {
      padding: 5px 6px;
      border-bottom: 1px solid #eee;
    }

    table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .badge {
      padding: 2px 6px;
      border-radius: 2px;
      font-size: 7px;
      font-weight: bold;
    }

    .badge-upload {
      background-color: #28a745;
      color: white;
    }

    .badge-download {
      background-color: #17a2b8;
      color: white;
    }

    .badge-verify {
      background-color: #007bff;
      color: white;
    }

    .badge-reject {
      background-color: #dc3545;
      color: white;
    }

    .badge-edit {
      background-color: #ffc107;
      color: black;
    }

    .badge-delete {
      background-color: #6c757d;
      color: white;
    }

    .badge-login {
      background-color: #6f42c1;
      color: white;
    }

    .badge-logout {
      background-color: #e83e8c;
      color: white;
    }

    .badge-login_failed {
      background-color: #dc3545;
      color: white;
    }

    .text-muted {
      color: #6c757d;
    }

    .footer {
      margin-top: 20px;
      padding-top: 8px;
      border-top: 1px solid #ddd;
      font-size: 7px;
      color: #6c757d;
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
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <h1>PT BANK RAKYAT INDONESIA (PERSERO) Tbk</h1>
    <h2>KC TANJUNG TABALONG</h2>
    <h3>LAPORAN AKTIVITAS PENGGUNA</h3>
    <p>Periode: {{ date('d/m/Y') }}</p>
  </div>

  <!-- Filter Info -->
  @if (!empty($filter['user_id']) && $filter['user_id'] != 'all')
    <div class="filter-info">
      <strong>Filter:</strong>
      User ID: {{ $filter['user_id'] }}
      @if (!empty($filter['action']) && $filter['action'] != 'all')
        | Aksi: {{ $filter['action'] }}
      @endif
      @if (!empty($filter['start_date']))
        | Dari: {{ $filter['start_date'] }}
      @endif
      @if (!empty($filter['end_date']))
        | Sampai: {{ $filter['end_date'] }}
      @endif
    </div>
  @endif

  <!-- Summary -->
  @php
    $total = $activities->count();
    $uploads = $activities->where('action', 'upload')->count();
    $downloads = $activities->where('action', 'download')->count();
    $verifies = $activities->where('action', 'verify')->count();
    $rejects = $activities->where('action', 'reject')->count();
    $logins = $activities->where('action', 'login')->count();
  @endphp
  <div class="summary-grid">
    <div class="summary-box">
      <span class="summary-value">{{ $total }}</span>
      <span class="summary-label">Total Aktivitas</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ $uploads }}</span>
      <span class="summary-label">Upload</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ $downloads }}</span>
      <span class="summary-label">Download</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ $verifies }}</span>
      <span class="summary-label">Verifikasi</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ $rejects }}</span>
      <span class="summary-label">Penolakan</span>
    </div>
    <div class="summary-box">
      <span class="summary-value">{{ $logins }}</span>
      <span class="summary-label">Login</span>
    </div>
  </div>

  <!-- Activities Table -->
  <table>
    <thead>
      <tr>
        <th>No.</th>
        <th>Tanggal/Waktu</th>
        <th>User</th>
        <th>Aksi</th>
        <th>Deskripsi</th>
        <th>Dokumen</th>
        <th>IP Address</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($activities as $index => $activity)
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          <td nowrap>
            {{ $activity->created_at->format('d/m/Y') }}<br>
            <small class="text-muted">{{ $activity->created_at->format('H:i:s') }}</small>
          </td>
          <td>
            @if ($activity->user)
              <strong>{{ $activity->user->name }}</strong><br>
              <small class="text-muted">
                {{ $activity->user->isAdmin() ? 'Admin' : 'Verifikator' }}
              </small>
            @else
              <span class="text-muted">System</span>
            @endif
          </td>
          <td>
            <span class="badge badge-{{ $activity->action }}">
              {{ strtoupper($activity->action) }}
            </span>
          </td>
          <td>{{ $activity->description }}</td>
          <td>
            @if ($activity->document)
              <small>
                {{ $activity->document->nama_nasabah }}<br>
                <span class="text-muted">{{ $activity->document->no_rekening }}</span>
              </small>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td>{{ $activity->ip_address ?? '-' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @if ($activities->count() == 0)
    <div style="text-align: center; padding: 30px; color: #6c757d;">
      <p>Tidak ada data aktivitas untuk periode ini</p>
    </div>
  @endif

  <!-- Footer -->
  <div class="footer">
    <div>Dicetak pada: {{ $tanggal_cetak }}</div>
    <div>Oleh: Sistem Manajemen Arsip Digital BRI</div>
    <div>Halaman 1/1</div>
  </div>
</body>

</html>
