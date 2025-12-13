<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes (tanpa authentication)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
  // Dashboard & Home
  Route::get('/', function () {
    return redirect()->route('dashboard');
  });

  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Logout
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  // Documents routes
  Route::resource('documents', DocumentController::class);

  // Additional document routes
  Route::get('documents/{document}/download', [DocumentController::class, 'download'])
    ->name('documents.download');

  // Verifikasi dokumen
  Route::post('documents/{document}/verify', [DocumentController::class, 'verify'])
    ->name('documents.verify');

  // Settings routes
  Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/profile', [SettingController::class, 'profile'])->name('profile');
    Route::put('/profile', [SettingController::class, 'updateProfile'])->name('profile.update');
    Route::get('/about', [SettingController::class, 'about'])->name('about');
  });

  // Reports routes
  Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/daftar-dokumen', [ReportController::class, 'daftarDokumen'])->name('daftar-dokumen');
    Route::get('/daftar-dokumen/pdf', [ReportController::class, 'daftarDokumenPdf'])->name('daftar-dokumen.pdf');

    Route::get('/statistik-dokumen', [ReportController::class, 'statistikDokumen'])->name('statistik-dokumen');
    Route::get('/statistik-dokumen/pdf', [ReportController::class, 'statistikDokumenPdf'])->name('statistik-dokumen.pdf');

    Route::get('/per-nasabah', [ReportController::class, 'laporanPerNasabah'])->name('per-nasabah');
    Route::get('/per-nasabah/pdf', [ReportController::class, 'laporanPerNasabahPdf'])->name('per-nasabah.pdf');
    Route::get('/nasabah/{noRekening}', [ReportController::class, 'detailNasabah'])->name('detail-nasabah');

    Route::get('/aktivitas-pengguna', [ReportController::class, 'aktivitasPengguna'])->name('aktivitas-pengguna');
    Route::get('/aktivitas-pengguna/pdf', [ReportController::class, 'aktivitasPenggunaPdf'])->name('aktivitas-pengguna.pdf');

    Route::get('/dokumen-bermasalah', [ReportController::class, 'dokumenBermasalah'])->name('dokumen-bermasalah');
    Route::get('/dokumen-bermasalah/pdf', [ReportController::class, 'dokumenBermasalahPdf'])->name('dokumen-bermasalah.pdf');

    // Laporan Dokumen Per Kategori Kredit
    Route::get('/dokumen-per-kategori', [ReportController::class, 'dokumenPerKategori'])->name('dokumen-per-kategori');
    Route::get('/dokumen-per-kategori/pdf', [ReportController::class, 'dokumenPerKategoriPdf'])->name('dokumen-per-kategori.pdf');
  });

  // User Management routes (Admin only) - Middleware tambahan untuk admin
  Route::middleware(['admin'])->group(function () {
    Route::resource('users', UserController::class);
  });
});

// Fallback route untuk 404
Route::fallback(function () {
  if (app('auth')->check()) {
    return redirect()->route('dashboard');
  }
  return redirect()->route('login');
});