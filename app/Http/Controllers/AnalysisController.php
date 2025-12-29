<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
  /**
   * Menampilkan rekomendasi nasabah berpotensi
   */
  public function rekomendasiNasabah(Request $request)
  {
    // Query nasabah berpotensi (kriteria: riwayat bersih & estimasi selesai)
    $query = Document::query()
      ->where('status_riwayat', 'bersih')
      ->where('status', 'verified')
      ->where('estimasi_selesai', '<=', date('Y')) // kredit sudah selesai
      ->select('nama_nasabah', 'no_rekening', 'no_ktp', 'kategori_kredit')
      ->selectRaw('COUNT(*) as total_kredit')
      ->selectRaw('MAX(estimasi_selesai) as tahun_selesai_terakhir')
      ->selectRaw('SUM(nominal_kredit) as total_nominal')
      ->groupBy('nama_nasabah', 'no_rekening', 'no_ktp', 'kategori_kredit')
      ->orderBy('total_kredit', 'desc');

    // Filter kategori
    if ($request->filled('kategori')) {
      $query->where('kategori_kredit', $request->kategori);
    }

    $nasabah = $query->paginate(20);

    // Statistik
    $totalNasabah = $nasabah->total();
    $totalKredit = Document::where('status_riwayat', 'bersih')
      ->where('status', 'verified')
      ->sum('nominal_kredit');

    return view('analysis.rekomendasi', compact('nasabah', 'totalNasabah', 'totalKredit'));
  }

  /**
   * Menampilkan detail per kategori kredit (KUR, KPR, KKB, dll)
   */
  public function detailKategori(Request $request)
  {
    // Statistik per kategori
    $kategoriStats = Document::query()
      ->whereNotNull('kategori_kredit')
      ->select('kategori_kredit')
      ->selectRaw('COUNT(*) as total_dokumen')
      ->selectRaw('SUM(CASE WHEN status = "verified" THEN 1 ELSE 0 END) as verified')
      ->selectRaw('SUM(CASE WHEN status_riwayat = "bersih" THEN 1 ELSE 0 END) as bersih')
      ->selectRaw('AVG(nominal_kredit) as rata_nominal')
      ->selectRaw('AVG(suku_bunga) as rata_bunga')
      ->selectRaw('AVG(tenor) as rata_tenor')
      ->groupBy('kategori_kredit')
      ->orderBy('total_dokumen', 'desc')
      ->get();

    // Detail untuk kategori tertentu (jika dipilih)
    $selectedKategori = $request->get('kategori');
    $detailKategori = null;

    if ($selectedKategori) {
      $detailKategori = Document::where('kategori_kredit', $selectedKategori)
        ->select('jenis_bunga', 'status_riwayat')
        ->selectRaw('COUNT(*) as jumlah')
        ->selectRaw('MIN(suku_bunga) as bunga_min')
        ->selectRaw('MAX(suku_bunga) as bunga_max')
        ->selectRaw('MIN(nominal_kredit) as nominal_min')
        ->selectRaw('MAX(nominal_kredit) as nominal_max')
        ->selectRaw('MIN(tenor) as tenor_min')
        ->selectRaw('MAX(tenor) as tenor_max')
        ->groupBy('jenis_bunga', 'status_riwayat')
        ->get();
    }

    return view('analysis.kategori', compact('kategoriStats', 'selectedKategori', 'detailKategori'));
  }
}
