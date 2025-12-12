@extends('layouts.app')

@section('title', 'Verifikasi Dokumen')
@section('page-title', 'Verifikasi Dokumen #' . $document->id)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
  <li class="breadcrumb-item"><a href="{{ route('documents.show', $document) }}">Detail</a></li>
  <li class="breadcrumb-item active">Verifikasi</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="card">
          <div class="card-header bg-info text-white">
            <h3 class="card-title">
              <i class="fas fa-check-circle mr-2"></i>
              Verifikasi Dokumen
            </h3>
          </div>

          <!-- Informasi Dokumen -->
          <div class="card-body">
            <div class="alert alert-info">
              <h5><i class="fas fa-info-circle mr-2"></i> Dokumen yang Akan Diverifikasi</h5>
              <p class="mb-1"><strong>Nasabah:</strong> {{ $document->nama_nasabah }}</p>
              <p class="mb-1"><strong>No Rekening:</strong> {{ $document->no_rekening }}</p>
              <p class="mb-1"><strong>Jenis Dokumen:</strong> {{ $document->jenis_dokumen }}</p>
              <p class="mb-0"><strong>Kategori:</strong> {{ $document->kategori_kredit }}</p>
            </div>

            <!-- Preview File -->
            <div class="text-center mb-4">
              @if (in_array(pathinfo($document->document_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                <img src="{{ asset('storage/' . $document->document_file) }}" alt="Preview Dokumen"
                  class="img-fluid rounded border" style="max-height: 400px;">
                <p class="text-muted mt-2">
                  <i class="fas fa-image mr-1"></i> Preview gambar dokumen
                </p>
              @else
                <div class="alert alert-warning">
                  <i class="fas fa-file-pdf mr-2"></i>
                  Dokumen berupa file {{ strtoupper(pathinfo($document->document_file, PATHINFO_EXTENSION)) }}.
                  <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-outline-primary ml-2">
                    <i class="fas fa-download mr-1"></i> Download untuk preview
                  </a>
                </div>
              @endif
            </div>

            <!-- Form Verifikasi -->
            <form action="{{ route('documents.verify.submit', $document) }}" method="POST">
              @csrf

              <div class="form-group">
                <label for="status"><strong>Status Verifikasi *</strong></label>
                <div class="row">
                  <div class="col-md-6">
                    <div class="custom-control custom-radio">
                      <input type="radio" id="verified" name="status" value="verified" class="custom-control-input"
                        required>
                      <label class="custom-control-label text-success" for="verified">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>APPROVE</strong> - Dokumen valid dan lengkap
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="custom-control custom-radio">
                      <input type="radio" id="rejected" name="status" value="rejected" class="custom-control-input"
                        required>
                      <label class="custom-control-label text-danger" for="rejected">
                        <i class="fas fa-times-circle mr-2"></i>
                        <strong>REJECT</strong> - Dokumen tidak valid/tidak lengkap
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Catatan untuk reject -->
              <div class="form-group" id="catatan-group" style="display: none;">
                <label for="catatan_verifikasi">
                  <strong>Alasan Penolakan *</strong>
                  <small class="text-muted">(Wajib diisi jika menolak)</small>
                </label>
                <textarea class="form-control" id="catatan_verifikasi" name="catatan_verifikasi" rows="4"
                  placeholder="Berikan alasan penolakan..."></textarea>
                <small class="text-muted">Contoh: Foto KTP buram, data tidak sesuai, dokumen expired, dll.</small>
              </div>

              <!-- Catatan umum (opsional) -->
              <div class="form-group">
                <label for="catatan_tambahan">
                  <strong>Catatan Tambahan</strong>
                  <small class="text-muted">(Opsional)</small>
                </label>
                <textarea class="form-control" id="catatan_tambahan" name="catatan_tambahan" rows="3"
                  placeholder="Tambahan catatan jika diperlukan..."></textarea>
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="confirm_verify" required>
                  <label class="custom-control-label" for="confirm_verify">
                    Saya telah memeriksa dokumen ini dengan teliti dan memastikan data sesuai.
                  </label>
                </div>
              </div>

              <div class="card-footer text-right">
                <a href="{{ route('documents.show', $document) }}" class="btn btn-secondary">
                  <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-check mr-2"></i> Submit Verifikasi
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      $('input[name="status"]').change(function() {
        if ($(this).val() === 'rejected') {
          $('#catatan-group').slideDown();
          $('#catatan_verifikasi').prop('required', true);
        } else {
          $('#catatan-group').slideUp();
          $('#catatan_verifikasi').prop('required', false);
        }
      });

      // Validasi form
      $('form').submit(function(e) {
        if ($('input[name="status"]:checked').val() === 'rejected' &&
          $('#catatan_verifikasi').val().trim() === '') {
          e.preventDefault();
          alert('Harap isi alasan penolakan!');
          $('#catatan_verifikasi').focus();
        }
      });
    });
  </script>
@endsection
