<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Kategori Kredit - BRI KC Tanjung Tabalong</title>
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

    /* CATEGORY TABLE - CLEAN */
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

    .col-kategori {
      width: 180px;
    }

    .col-total {
      width: 50px;
    }

    .col-pending {
      width: 50px;
    }

    .col-verified {
      width: 50px;
    }

    .col-rejected {
      width: 50px;
    }

    .col-expired {
      width: 50px;
    }

    .col-percentage {
      width: 90px;
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

    .text-right {
      text-align: right;
    }

    .total-row {
      font-weight: bold;
      background: #f0f0f0 !important;
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <div class="header">
    <h1>BRI KC TANJUNG TABALONG</h1>
    <h2>Laporan Dokumen per Kategori Kredit</h2>
    <h3>Sistem Arsip Digital Administrasi Kredit</h3>
  </div>

  <!-- CATEGORY TABLE -->
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th class="col-no text-center">No</th>
          <th class="col-kategori">Kategori Kredit</th>
          <th class="col-total text-center">Total</th>
          <th class="col-pending text-center">Pending</th>
          <th class="col-verified text-center">Verified</th>
          <th class="col-rejected text-center">Rejected</th>
          <th class="col-expired text-center">Expired</th>
          <th class="col-percentage text-center">%</th>
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
          <td class="text-center">
            <span class="badge badge-total">{{ $summary['total_documents'] }}</span>
          </td>
          <td class="text-center">
            @if ($totalPending > 0)
              <span class="badge badge-pending">{{ $totalPending }}</span>
            @else
              -
            @endif
          </td>
          <td class="text-center">
            @if ($totalVerified > 0)
              <span class="badge badge-verified">{{ $totalVerified }}</span>
            @else
              -
            @endif
          </td>
          <td class="text-center">
            @if ($totalRejected > 0)
              <span class="badge badge-rejected">{{ $totalRejected }}</span>
            @else
              -
            @endif
          </td>
          <td class="text-center">
            @if ($totalExpired > 0)
              <span class="badge badge-expired">{{ $totalExpired }}</span>
            @else
              -
            @endif
          </td>
          <td class="text-center">100%</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <div>Dokumen ini dicetak secara otomatis dari sistem</div>
    <div style="margin-top: 5px; color: #999; font-size: 7pt;">
      {{ $summary['tanggal_cetak'] }} • BRI KC Tanjung Tabalong
    </div>
  </div>

</body>

</html>
