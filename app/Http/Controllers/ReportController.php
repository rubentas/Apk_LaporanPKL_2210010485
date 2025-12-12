<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
  /**
   * Tampilan laporan daftar dokumen (web view)
   */
  public function daftarDokumen(Request $request)
  {
    // Ambil filter dari request
    $status = $request->input('status');
    $kategori = $request->input('kategori_kredit');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    // Query dasar
    $query = Document::query();

    // Apply filters
    if ($status) {
      $query->where('status', $status);
    }

    if ($kategori) {
      $query->where('kategori_kredit', $kategori);
    }

    // PERBAIKAN FILTER TANGGAL
    if ($start_date && $end_date) {
      // Format: YYYY-MM-DD -> tambah waktu untuk include seluruh hari
      $query->whereBetween('created_at', [
        $start_date . ' 00:00:00',
        $end_date . ' 23:59:59'
      ]);
    } elseif ($start_date) {
      // Jika hanya start date
      $query->whereDate('created_at', '>=', $start_date);
    } elseif ($end_date) {
      // Jika hanya end date
      $query->whereDate('created_at', '<=', $end_date);
    }

    $documents = $query->latest()->get();

    // Untuk dropdown filter
    $statuses = ['pending', 'verified', 'rejected', 'expired'];
    $kategories = Document::distinct()->pluck('kategori_kredit');

    return view('reports.daftar-dokumen', compact('documents', 'statuses', 'kategories'));
  }

  /**
   * Generate PDF laporan daftar dokumen (SEMUA)
   */

  public function daftarDokumenPdf(Request $request)
  {
    // Filter sama seperti web view
    $query = Document::query();

    if ($request->status) {
      $query->where('status', $request->status);
    }

    if ($request->kategori_kredit) {
      $query->where('kategori_kredit', $request->kategori_kredit);
    }

    // FILTER TANGGAL YANG SAMA (tambahkan di sini)
    if ($request->start_date && $request->end_date) {
      $query->whereBetween('created_at', [
        $request->start_date . ' 00:00:00',
        $request->end_date . ' 23:59:59'
      ]);
    } elseif ($request->start_date) {
      $query->whereDate('created_at', '>=', $request->start_date);
    } elseif ($request->end_date) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    $documents = $query->latest()->get();

    $data = [
      'documents' => $documents,
      'filter' => $request->all(),
      'tanggal_cetak' => now()->format('d/m/Y H:i:s'),
    ];

    $pdf = Pdf::loadView('reports.pdf.daftar-dokumen-pdf', $data)
      ->setPaper('a4', 'landscape');

    if ($request->has('preview') && $request->preview == 1) {
      return $pdf->stream('laporan-daftar-dokumen-' . date('Y-m-d') . '.pdf');
    }

    return $pdf->download('laporan-daftar-dokumen-' . date('Y-m-d') . '.pdf');
  }

  /**
   * Laporan Statistik Dokumen - Tampilan Web
   */

  public function statistikDokumen()
  {
    // 1. Single query untuk semua statistik
    $stats = Document::selectRaw("
        COUNT(*) as total,
        SUM(status = 'pending') as pending,
        SUM(status = 'verified') as verified,
        SUM(status = 'rejected') as rejected,
        SUM(status = 'expired' OR (expired_date < NOW() AND status != 'expired')) as expired,
        SUM(expired_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)) as expiring_soon
    ")->first();

    // 2. Data bulanan pakai scope baru
    $monthlyData = Document::monthlyStats(6)->get();

    // 3. Top kategori pakai scope baru
    $topKategori = Document::topCategories(5)->get();

    // 4. Dokumen hampir expired
    $expiringSoon = Document::expiringSoon()
      ->with('uploader')
      ->orderBy('expired_date', 'asc')
      ->limit(10)
      ->get();

    return view('reports.statistik', compact('stats', 'monthlyData', 'topKategori', 'expiringSoon'));
  }

  /**
   * Export PDF Statistik Dokumen
   */
  /**
   * Export PDF Statistik Dokumen
   */
  public function statistikDokumenPdf(Request $request)
  {
    // 1. Single query untuk semua statistik
    $stats = Document::selectRaw("
        COUNT(*) as total,
        SUM(status = 'pending') as pending,
        SUM(status = 'verified') as verified,
        SUM(status = 'rejected') as rejected,
        SUM(status = 'expired' OR (expired_date < NOW() AND status != 'expired')) as expired,
        SUM(expired_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)) as expiring_soon
    ")->first();

    // 2. Data bulanan
    $monthlyData = Document::monthlyStats(6)->get();

    // 3. Top kategori
    $topKategori = Document::topCategories(5)->get();

    // 4. Dokumen hampir expired
    $expiringSoon = Document::expiringSoon()
      ->orderBy('expired_date', 'asc')
      ->limit(10)
      ->get();

    $data = [
      'stats' => $stats,
      'monthlyData' => $monthlyData,
      'topKategori' => $topKategori,
      'expiringSoon' => $expiringSoon,
      'tanggal_cetak' => now()->format('d/m/Y H:i:s'),
    ];

    $pdf = Pdf::loadView('reports.pdf.statistik', $data)
      ->setPaper('a4', 'portrait');

    // Cek apakah request untuk preview
    if ($request->has('preview') && $request->preview == 1) {
      return $pdf->stream('laporan-statistik-dokumen-' . date('Y-m-d') . '.pdf');
    }

    // Default download
    return $pdf->download('laporan-statistik-dokumen-' . date('Y-m-d') . '.pdf');
  }

  /**
   * Laporan per Nasabah
   */
  public function laporanPerNasabah(Request $request)
  {
    // Query dokumen group by nasabah
    $documents = Document::query();

    // Filter jika ada
    if ($request->filled('search_nasabah')) {
      $documents->where('nama_nasabah', 'like', '%' . $request->search_nasabah . '%');
    }

    if ($request->filled('kategori_kredit')) {
      $documents->where('kategori_kredit', $request->kategori_kredit);
    }

    // Group by NIK KTP (harusnya unik)
    $grouped = $documents->get()->groupBy('no_ktp');

    // Siapkan data untuk view
    $nasabahData = [];
    foreach ($grouped as $ktp => $docs) {
      $uniqueNames = $docs->pluck('nama_nasabah')->unique();
      $firstDoc = $docs->first();

      $nasabahData[] = [
        'nama_nasabah' => $uniqueNames->first(),
        'no_rekening' => $firstDoc->no_rekening,
        'no_ktp' => $ktp,
        'alamat' => $firstDoc->alamat,
        'telepon' => $firstDoc->telepon,
        'total_dokumen' => $docs->count(),
        'pending' => $docs->where('status', 'pending')->count(),
        'verified' => $docs->where('status', 'verified')->count(),
        'rejected' => $docs->where('status', 'rejected')->count(),
        'expired' => $docs->where('status', 'expired')->count(),
        'dokumen' => $docs->sortByDesc('created_at')->take(10),
        'kategori_kredit' => $docs->pluck('kategori_kredit')->unique()->implode(', '),
        'has_issue' => $uniqueNames->count() > 1,
        'issue_message' => $uniqueNames->count() > 1
          ? 'PERHATIAN: NIK ' . $ktp . ' terdaftar untuk ' . $uniqueNames->count() . ' nama berbeda: ' . $uniqueNames->implode(', ')
          : null,
        'all_names' => $uniqueNames->values()->toArray(),
      ];
    }

    // Sort by nama nasabah
    usort($nasabahData, function ($a, $b) {
      return strcmp($a['nama_nasabah'], $b['nama_nasabah']);
    });

    $kategoriOptions = Document::distinct()->pluck('kategori_kredit');

    return view('reports.per-nasabah', compact('nasabahData', 'kategoriOptions'));
  }

  /**
   * Export PDF Laporan per Nasabah
   */
  public function laporanPerNasabahPdf(Request $request)
  {
    // Query sama seperti web view
    $documents = Document::query();

    if ($request->filled('search_nasabah')) {
      $documents->where('nama_nasabah', 'like', '%' . $request->search_nasabah . '%');
    }

    if ($request->filled('kategori_kredit')) {
      $documents->where('kategori_kredit', $request->kategori_kredit);
    }

    // Filter untuk single nasabah jika ada parameter
    if ($request->filled('nasabah')) {
      $documents->where('no_rekening', $request->nasabah);
    }

    // Group by KTP
    $grouped = $documents->get()->groupBy('no_ktp');

    // Siapkan data
    $nasabahData = [];
    foreach ($grouped as $ktp => $docs) {
      $firstDoc = $docs->first();
      $nasabahData[] = [
        'nama_nasabah' => $firstDoc->nama_nasabah,
        'no_rekening' => $firstDoc->no_rekening,
        'no_ktp' => $firstDoc->no_ktp,
        'alamat' => $firstDoc->alamat,
        'telepon' => $firstDoc->telepon,
        'total_dokumen' => $docs->count(),
        'pending' => $docs->where('status', 'pending')->count(),
        'verified' => $docs->where('status', 'verified')->count(),
        'rejected' => $docs->where('status', 'rejected')->count(),
        'expired' => $docs->where('status', 'expired')->count(),
        'dokumen' => $docs->sortByDesc('created_at'),
        'kategori_kredit' => $docs->pluck('kategori_kredit')->unique()->implode(', '),
      ];
    }

    // Sort
    usort($nasabahData, function ($a, $b) {
      return strcmp($a['nama_nasabah'], $b['nama_nasabah']);
    });

    $data = [
      'nasabahData' => $nasabahData,
      'filter' => $request->all(),
      'tanggal_cetak' => now()->format('d/m/Y H:i:s'),
      'is_single' => $request->filled('nasabah'), // apakah cetak single nasabah
    ];

    $pdf = Pdf::loadView('reports.pdf.per-nasabah', $data)
      ->setPaper('a4', 'landscape');

    // Preview atau download
    if ($request->has('preview') && $request->preview == 1) {
      return $pdf->stream('laporan-per-nasabah-' . date('Y-m-d') . '.pdf');
    }

    $filename = $request->filled('nasabah')
      ? 'laporan-nasabah-' . $request->nasabah . '-' . date('Y-m-d') . '.pdf'
      : 'laporan-per-nasabah-' . date('Y-m-d') . '.pdf';

    return $pdf->download($filename);
  }

  /**
   * Detail Dokumen per Nasabah
   */
  public function detailNasabah($noRekening)
  {
    $documents = Document::where('no_rekening', $noRekening)
      ->orderBy('created_at', 'desc')
      ->get();

    if ($documents->isEmpty()) {
      return redirect()->route('reports.per-nasabah')
        ->with('error', 'Data nasabah tidak ditemukan');
    }

    $nasabah = $documents->first();
    $stats = [
      'total' => $documents->count(),
      'pending' => $documents->where('status', 'pending')->count(),
      'verified' => $documents->where('status', 'verified')->count(),
      'rejected' => $documents->where('status', 'rejected')->count(),
      'expired' => $documents->where('status', 'expired')->count(),
    ];

    return view('reports.detail-nasabah', compact('documents', 'nasabah', 'stats'));
  }

  /**
   * Laporan Aktivitas Pengguna
   */
  public function aktivitasPengguna(Request $request)
  {
    $query = ActivityLog::with(['user', 'document'])
      ->orderBy('created_at', 'desc');

    // Filter by user
    if ($request->filled('user_id') && $request->user_id != 'all') {
      $query->where('user_id', $request->user_id);
    }

    // Filter by action
    if ($request->filled('action') && $request->action != 'all') {
      $query->where('action', $request->action);
    }

    // Filter by date range
    if ($request->filled('start_date')) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Filter by document (if ada document_id)
    if ($request->filled('document_id')) {
      $query->where('document_id', $request->document_id);
    }

    // Pagination
    $perPage = $request->get('per_page', 20);
    $activities = $query->paginate($perPage);

    // Get filter options
    $users = User::orderBy('name')->get();
    $actions = ActivityLog::distinct()->pluck('action');
    $documents = Document::orderBy('nama_nasabah')->get();

    return view('reports.aktivitas-pengguna', compact('activities', 'users', 'actions', 'documents'));
  }

  /**
   * Export PDF Aktivitas Pengguna
   */
  public function aktivitasPenggunaPdf(Request $request)
  {
    $query = ActivityLog::with(['user', 'document'])
      ->orderBy('created_at', 'desc');

    // Apply same filters as web view
    if ($request->filled('user_id') && $request->user_id != 'all') {
      $query->where('user_id', $request->user_id);
    }

    if ($request->filled('action') && $request->action != 'all') {
      $query->where('action', $request->action);
    }

    if ($request->filled('start_date')) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->filled('document_id')) {
      $query->where('document_id', $request->document_id);
    }

    $activities = $query->get();

    $data = [
      'activities' => $activities,
      'filter' => $request->all(),
      'tanggal_cetak' => now()->format('d/m/Y H:i:s'),
    ];

    $pdf = Pdf::loadView('reports.pdf.aktivitas-pengguna', $data)
      ->setPaper('a4', 'landscape');

    if ($request->has('preview') && $request->preview == 1) {
      return $pdf->stream('laporan-aktivitas-pengguna-' . date('Y-m-d') . '.pdf');
    }

    return $pdf->download('laporan-aktivitas-pengguna-' . date('Y-m-d') . '.pdf');
  }

  /**
   * Laporan Dokumen Bermasalah
   */
  public function dokumenBermasalah(Request $request)
  {
    // 1. Dokumen Expired
    $expired = Document::where(function ($query) {
      $query->where('status', 'expired')
        ->orWhere(function ($q) {
          $q->whereNotNull('expired_date')
            ->where('expired_date', '<', now())
            ->where('status', '!=', 'expired');
        });
    })
      ->orderBy('expired_date', 'desc')
      ->get();

    // 2. Dokumen Rejected
    $rejected = Document::where('status', 'rejected')
      ->orderBy('created_at', 'desc')
      ->get();

    // 3. Dokumen Pending Lama (>7 hari)
    $pendingLama = Document::where('status', 'pending')
      ->where('created_at', '<', now()->subDays(7))
      ->orderBy('created_at', 'asc')
      ->get();

    // 4. Data NIK Duplikat
    $nikDuplikat = [];
    $groupedByNik = Document::get()->groupBy('no_ktp');
    foreach ($groupedByNik as $nik => $docs) {
      if ($docs->count() > 1) {
        $uniqueNames = $docs->pluck('nama_nasabah')->unique();
        if ($uniqueNames->count() > 1) {
          $nikDuplikat[] = [
            'nik' => $nik,
            'count' => $docs->count(),
            'names' => $uniqueNames->values()->toArray(),
            'documents' => $docs->take(5),
          ];
        }
      }
    }

    // Summary counts
    $summary = [
      'expired' => $expired->count(),
      'rejected' => $rejected->count(),
      'pending_lama' => $pendingLama->count(),
      'nik_duplikat' => count($nikDuplikat),
      'total' => $expired->count() + $rejected->count() + $pendingLama->count(),
    ];

    return view('reports.dokumen-bermasalah', compact(
      'expired',
      'rejected',
      'pendingLama',
      'nikDuplikat',
      'summary'
    ));
  }

  /**
   * Export PDF Dokumen Bermasalah
   */
  public function dokumenBermasalahPdf(Request $request)
  {
    // 1. Dokumen Expired
    $expired = Document::where(function ($query) {
      $query->where('status', 'expired')
        ->orWhere(function ($q) {
          $q->whereNotNull('expired_date')
            ->where('expired_date', '<', now())
            ->where('status', '!=', 'expired');
        });
    })
      ->orderBy('expired_date', 'desc')
      ->get();

    // 2. Dokumen Rejected
    $rejected = Document::where('status', 'rejected')
      ->orderBy('created_at', 'desc')
      ->get();

    // 3. Dokumen Pending Lama (>7 hari)
    $pendingLama = Document::where('status', 'pending')
      ->where('created_at', '<', now()->subDays(7))
      ->orderBy('created_at', 'asc')
      ->get();

    // 4. Data NIK Duplikat
    $nikDuplikat = [];
    $groupedByNik = Document::get()->groupBy('no_ktp');
    foreach ($groupedByNik as $nik => $docs) {
      if ($docs->count() > 1) {
        $uniqueNames = $docs->pluck('nama_nasabah')->unique();
        if ($uniqueNames->count() > 1) {
          $nikDuplikat[] = [
            'nik' => $nik,
            'count' => $docs->count(),
            'names' => $uniqueNames->values()->toArray(),
            'documents' => $docs->take(5),
          ];
        }
      }
    }

    // Summary counts
    $summary = [
      'expired' => $expired->count(),
      'rejected' => $rejected->count(),
      'pending_lama' => $pendingLama->count(),
      'nik_duplikat' => count($nikDuplikat),
      'total' => $expired->count() + $rejected->count() + $pendingLama->count(),
    ];

    $data = [
      'expired' => $expired,
      'rejected' => $rejected,
      'pendingLama' => $pendingLama,
      'nikDuplikat' => $nikDuplikat,
      'summary' => $summary,
      'tanggal_cetak' => now()->format('d/m/Y H:i:s'),
    ];

    $pdf = Pdf::loadView('reports.pdf.dokumen-bermasalah', $data)
      ->setPaper('a4', 'portrait');

    if ($request->has('preview') && $request->preview == 1) {
      return $pdf->stream('laporan-dokumen-bermasalah-' . date('Y-m-d') . '.pdf');
    }

    return $pdf->download('laporan-dokumen-bermasalah-' . date('Y-m-d') . '.pdf');
  }
}