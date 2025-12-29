<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Document;

class DashboardController extends Controller
{
  public function index()
  {
    $data = Cache::remember('dashboard_stats', 60, function () {
      return [
        'totalDocuments' => Document::count(),
        'pendingDocuments' => Document::where('status', 'pending')->count(),
        'verifiedDocuments' => Document::where('status', 'verified')->count(),
        'rejectedDocuments' => Document::where('status', 'rejected')->count(),
        'recentDocuments' => Document::latest()->limit(5)->get(),
        'nasabahBerpotensi' => Document::where('status_riwayat', 'bersih')
          ->where('status', 'verified')
          ->where('estimasi_selesai', '<=', date('Y'))
          ->distinct('no_rekening')
          ->count('no_rekening'),
      ];
    });

    return view('dashboard', $data);
  }
}