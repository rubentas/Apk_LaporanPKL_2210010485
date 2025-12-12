<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $query = Document::query();

    // Filter by status
    if ($request->filled('status') && $request->status !== 'all') {
      $query->where('status', $request->status);
    }

    // Filter by jenis dokumen
    if ($request->filled('jenis_dokumen') && $request->jenis_dokumen !== 'all') {
      $query->where('jenis_dokumen', $request->jenis_dokumen);
    }

    // Filter by kategori kredit
    if ($request->filled('kategori_kredit') && $request->kategori_kredit !== 'all') {
      $query->where('kategori_kredit', $request->kategori_kredit);
    }

    // Search
    if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('nama_nasabah', 'like', '%' . $request->search . '%')
          ->orWhere('no_rekening', 'like', '%' . $request->search . '%')
          ->orWhere('no_ktp', 'like', '%' . $request->search . '%');
      });
    }

    // Expiring soon (30 hari lagi)
    if ($request->has('expiring_soon')) {
      $query->whereNotNull('expired_date')
        ->where('expired_date', '<=', now()->addDays(30))
        ->where('expired_date', '>=', now());
    }

    // Sort
    $sortBy = $request->get('sort_by', 'created_at');
    $sortDir = $request->get('sort_dir', 'desc');
    $query->orderBy($sortBy, $sortDir);

    // Pagination
    $perPage = $request->get('per_page', 15);
    $documents = $query->paginate($perPage);

    // Get filter options for dropdowns
    $jenisDokumenOptions = Document::distinct()->pluck('jenis_dokumen');
    $kategoriKreditOptions = Document::distinct()->pluck('kategori_kredit');

    return view('documents.index', compact('documents', 'jenisDokumenOptions', 'kategoriKreditOptions'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('documents.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'nama_nasabah' => 'required|string|max:100',
      'no_rekening' => 'required|string|max:50',
      'no_ktp' => 'required|string|max:20',
      'alamat' => 'required|string',
      'telepon' => 'required|string|max:15',
      'jenis_dokumen' => 'required|string|max:50',
      'kategori_kredit' => 'required|string|max:50',
      'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
      'tanggal_dokumen' => 'required|date',
      'expired_date' => 'nullable|date|after:tanggal_dokumen',
      'catatan' => 'nullable|string|max:500',
    ]);

    try {
      // Upload file
      $file = $request->file('document_file');
      $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
      $filePath = $file->storeAs('documents', $fileName, 'public');

      // Create document
      $document = Document::create([
        'nama_nasabah' => $request->nama_nasabah,
        'no_rekening' => $request->no_rekening,
        'no_ktp' => $request->no_ktp,
        'alamat' => $request->alamat,
        'telepon' => $request->telepon,
        'jenis_dokumen' => $request->jenis_dokumen,
        'kategori_kredit' => $request->kategori_kredit,
        'nama_file' => $file->getClientOriginalName(),
        'document_file' => $filePath,
        'path_file' => $filePath,
        'mime_type' => $file->getMimeType(),
        'file_size' => $file->getSize(),
        'status' => 'pending',
        'catatan' => $request->catatan,
        'tanggal_dokumen' => $request->tanggal_dokumen,
        'expired_date' => $request->expired_date,
        'uploaded_by' => Auth::id(),
      ]);

      // Log activity
      ActivityLog::log('upload', "Upload dokumen {$request->nama_nasabah} ({$document->id})", Auth::id(), $document->id);

      return redirect()->route('documents.index')
        ->with('success', 'Dokumen berhasil diupload! Status: Pending verification.');
    } catch (\Exception $e) {
      // Rollback file upload if error
      if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
        Storage::disk('public')->delete($filePath);
      }

      return redirect()->back()
        ->withInput()
        ->with('error', 'Gagal upload dokumen: ' . $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Document $document)
  {
    return view('documents.show', compact('document'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Document $document)
  {
    // Tidak bisa edit jika status verified atau expired
    if (in_array($document->status, ['verified', 'expired'])) {
      return redirect()->route('documents.show', $document)
        ->with('warning', 'Dokumen yang sudah diverifikasi atau expired tidak dapat diubah.');
    }

    return view('documents.edit', compact('document'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Document $document)
  {
    // Tidak bisa update jika status verified atau expired
    if (in_array($document->status, ['verified', 'expired'])) {
      return redirect()->route('documents.show', $document)
        ->with('error', 'Dokumen yang sudah diverifikasi atau expired tidak dapat diubah.');
    }

    $request->validate([
      'nama_nasabah' => 'required|string|max:100',
      'no_rekening' => 'required|string|max:50',
      'no_ktp' => 'required|string|max:20',
      'alamat' => 'required|string',
      'telepon' => 'required|string|max:15',
      'jenis_dokumen' => 'required|string|max:50',
      'kategori_kredit' => 'required|string|max:50',
      'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
      'tanggal_dokumen' => 'required|date',
      'expired_date' => 'nullable|date|after:tanggal_dokumen',
      'catatan' => 'nullable|string|max:500',
    ]);

    try {
      $data = $request->only([
        'nama_nasabah',
        'no_rekening',
        'no_ktp',
        'alamat',
        'telepon',
        'jenis_dokumen',
        'kategori_kredit',
        'tanggal_dokumen',
        'expired_date',
        'catatan'
      ]);

      // Jika dokumen rejected dan diedit, reset status ke pending
      if ($document->status === 'rejected') {
        $data['status'] = 'pending';
      }

      // Jika upload file baru
      if ($request->hasFile('document_file')) {
        // Hapus file lama
        if ($document->path_file && Storage::disk('public')->exists($document->path_file)) {
          Storage::disk('public')->delete($document->path_file);
        }

        // Upload file baru
        $file = $request->file('document_file');
        $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $filePath = $file->storeAs('documents', $fileName, 'public');

        // Update file data
        $data['path_file'] = $filePath;
        $data['nama_file'] = $file->getClientOriginalName();
        $data['file_size'] = $file->getSize();
        $data['mime_type'] = $file->getMimeType();
      }

      $document->update($data);

      // Log activity
      ActivityLog::log('edit', "Edit dokumen {$document->nama_nasabah} ({$document->id})", Auth::id(), $document->id);

      return redirect()->route('documents.show', $document)
        ->with('success', 'Dokumen berhasil diperbarui!');
    } catch (\Exception $e) {
      return redirect()->back()
        ->withInput()
        ->with('error', 'Gagal update dokumen: ' . $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Document $document)
  {
    try {
      // Hanya bisa hapus jika status pending
      if ($document->status !== 'pending') {
        return redirect()->route('documents.show', $document)
          ->with('error', 'Dokumen yang sudah diverifikasi tidak dapat dihapus.');
      }

      // Log activity SEBELUM dihapus
      ActivityLog::log('delete', "Hapus dokumen {$document->nama_nasabah} ({$document->id})", Auth::id(), $document->id);

      // Hapus file fisik
      if ($document->path_file && Storage::disk('public')->exists($document->path_file)) {
        Storage::disk('public')->delete($document->path_file);
      }

      $document->delete();

      return redirect()->route('documents.index')
        ->with('success', 'Dokumen berhasil dihapus!');
    } catch (\Exception $e) {
      return redirect()->route('documents.show', $document)
        ->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
    }
  }

  /**
   * Download document file
   */
  public function download(Document $document)
  {
    if (!$document->path_file) {
      return redirect()->back()
        ->with('error', 'File tidak ditemukan!');
    }

    if (!Storage::disk('public')->exists($document->path_file)) {
      return redirect()->back()
        ->with('error', 'File tidak ditemukan!');
    }

    $filePath = storage_path('app/public/' . $document->path_file);

    if (!file_exists($filePath)) {
      return redirect()->back()
        ->with('error', 'File tidak ditemukan!');
    }

    // Log activity
    ActivityLog::log('download', "Download dokumen {$document->nama_nasabah} ({$document->id})", Auth::id(), $document->id);

    return response()->download($filePath, $document->nama_file ?? 'document.pdf');
  }

  /**
   * Verify document (for verifikator only)
   */
  public function showVerifyForm(Document $document)
  {
    return view('documents.verify', compact('document'));
  }

  public function verify(Request $request, Document $document)
  {
    $request->validate([
      'status' => 'required|in:verified,rejected',
      'catatan' => 'required_if:status,rejected|nullable|string|max:500',
    ]);

    try {
      $oldStatus = $document->status;
      $document->update([
        'status' => $request->status,
        'verified_by' => Auth::id(),
        'verified_at' => now(),
        'catatan' => $request->catatan ?: $document->catatan,
      ]);

      // Log activity
      $action = $request->status == 'verified' ? 'verify' : 'reject';
      ActivityLog::log($action, "{$action} dokumen {$document->nama_nasabah} ({$document->id}) dari {$oldStatus} ke {$request->status}", Auth::id(), $document->id);

      $statusText = $request->status == 'verified' ? 'diverifikasi' : 'ditolak';

      return redirect()->route('documents.show', $document)
        ->with('success', "Dokumen berhasil $statusText!");
    } catch (\Exception $e) {
      return redirect()->back()
        ->with('error', 'Gagal memverifikasi dokumen: ' . $e->getMessage());
    }
  }
}
