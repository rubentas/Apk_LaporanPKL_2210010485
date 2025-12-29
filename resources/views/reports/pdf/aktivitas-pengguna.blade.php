<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Aktivitas - BRI KC Tanjung Tabalong</title>
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

    /* SUMMARY - SIMPLE */
    .summary-box {
      background: #f8f9fa;
      padding: 10px;
      margin: 10px 0 15px 0;
      border-radius: 4px;
      border-left: 4px solid #0033a0;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 4px;
      font-size: 9pt;
    }

    .summary-label {
      font-weight: bold;
      color: #0033a0;
      min-width: 100px;
    }

    .summary-value {
      color: #333;
      font-weight: bold;
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
    }

    table th {
      background: #0033a0;
      color: white;
      padding: 8px 6px;
      border: 1px solid #ddd;
      font-weight: bold;
      text-align: left;
    }

    table td {
      padding: 7px 6px;
      border: 1px solid #e0e0e0;
      vertical-align: top;
    }

    table tr:nth-child(even) {
      background: #f9f9f9;
    }

    /* COLUMN WIDTHS */
    .col-no {
      width: 30px;
    }

    .col-user {
      width: 100px;
    }

    .col-action {
      width: 70px;
    }

    .col-description {
      width: auto;
    }

    .col-date {
      width: 80px;
    }

    /* ACTION BADGES */
    .badge {
      display: inline-block;
      padding: 3px 6px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: bold;
      text-align: center;
      min-width: 60px;
    }

    .badge-upload {
      background: #28a745;
      color: white;
    }

    .badge-download {
      background: #17a2b8;
      color: white;
    }

    .badge-edit {
      background: #ffc107;
      color: #000;
    }

    .badge-delete {
      background: #dc3545;
      color: white;
    }

    .badge-verify {
      background: #007bff;
      color: white;
    }

    .badge-reject {
      background: #6c757d;
      color: white;
    }

    .badge-login {
      background: #6610f2;
      color: white;
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

    .small {
      font-size: 7pt;
      color: #777;
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <div class="header">
    <h1>BRI KC TANJUNG TABALONG</h1>
    <h2>Laporan Aktivitas Pengguna</h2>
    <h3>Sistem Arsip Digital Administrasi Kredit</h3>
  </div>

  <!-- ACTIVITY SUMMARY -->
  <div class="summary-box">
    @php
      $actionCounts = [
          'upload' => 0,
          'download' => 0,
          'verify' => 0,
          'reject' => 0,
          'login' => 0,
          'edit' => 0,
          'delete' => 0,
      ];

      foreach ($activities as $activity) {
          $action = $activity->action;
          if (isset($actionCounts[$action])) {
              $actionCounts[$action]++;
          }
      }

      $totalActivities = count($activities);
    @endphp

    <div class="summary-row">
      <span class="summary-label">Total Aktivitas:</span>
      <span class="summary-value">{{ $totalActivities }}</span>
    </div>
    @if ($actionCounts['upload'] > 0)
      <div class="summary-row">
        <span class="summary-label">Upload:</span>
        <span class="summary-value">{{ $actionCounts['upload'] }}</span>
      </div>
    @endif
    @if ($actionCounts['download'] > 0)
      <div class="summary-row">
        <span class="summary-label">Download:</span>
        <span class="summary-value">{{ $actionCounts['download'] }}</span>
      </div>
    @endif
    @if ($actionCounts['verify'] > 0)
      <div class="summary-row">
        <span class="summary-label">Verifikasi:</span>
        <span class="summary-value">{{ $actionCounts['verify'] }}</span>
      </div>
    @endif
    @if ($actionCounts['reject'] > 0)
      <div class="summary-row">
        <span class="summary-label">Penolakan:</span>
        <span class="summary-value">{{ $actionCounts['reject'] }}</span>
      </div>
    @endif
    @if ($actionCounts['login'] > 0)
      <div class="summary-row">
        <span class="summary-label">Login:</span>
        <span class="summary-value">{{ $actionCounts['login'] }}</span>
      </div>
    @endif
  </div>

  <!-- ACTIVITY LIST -->
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th class="col-no text-center">No</th>
          <th class="col-user">Pengguna</th>
          <th class="col-action">Aksi</th>
          <th class="col-description">Deskripsi</th>
          <th class="col-date">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($activities as $index => $activity)
          @php
            $badgeClass = 'badge-' . $activity->action;
          @endphp
          <tr>
            <td class="col-no text-center">{{ $loop->iteration }}</td>
            <td>
              {{ $activity->user->name ?? 'System' }}
              @if ($activity->user)
                <br><span class="small">{{ $activity->user->email ?? '' }}</span>
              @endif
            </td>
            <td class="text-center">
              <span class="badge {{ $badgeClass }}">
                {{ strtoupper($activity->action) }}
              </span>
            </td>
            <td>
              {{ $activity->description }}
              @if ($activity->document)
                <br><span class="small">Dokumen: {{ $activity->document->nama_nasabah ?? '' }} (ID:
                  {{ $activity->document_id }})</span>
              @endif
            </td>
            <td class="text-center">
              {{ $activity->created_at->format('d/m/Y') }}<br>
              <span class="small">{{ $activity->created_at->format('H:i') }}</span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <div>Dokumen ini dicetak secara otomatis dari sistem</div>
    <div style="margin-top: 5px; color: #999; font-size: 7pt;">
      {{ $tanggal_cetak }} • BRI KC Tanjung Tabalong
    </div>
  </div>

</body>

</html>
