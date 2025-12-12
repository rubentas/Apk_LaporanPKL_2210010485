@extends('layouts.app')

@section('title', 'Edit Dokumen')
@section('page-title', 'Edit Dokumen #' . $document->id)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
  <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit mr-2"></i>
              Form Edit Dokumen
            </h3>
          </div>
          <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama_nasabah">Nama Nasabah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_nasabah') is-invalid @enderror"
                      id="nama_nasabah" name="nama_nasabah" value="{{ old('nama_nasabah', $document->nama_nasabah) }}"
                      required>
                    @error('nama_nasabah')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="no_rekening">No Rekening <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_rekening') is-invalid @enderror" id="no_rekening"
                      name="no_rekening" value="{{ old('no_rekening', $document->no_rekening) }}" required>
                    @error('no_rekening')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="no_ktp">No KTP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" id="no_ktp"
                      name="no_ktp" value="{{ old('no_ktp', $document->no_ktp) }}" required>
                    @error('no_ktp')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="telepon">Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                      name="telepon" value="{{ old('telepon', $document->telepon) }}" required>
                    @error('telepon')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2"
                  required>{{ old('alamat', $document->alamat) }}</textarea>
                @error('alamat')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="jenis_dokumen">Jenis Dokumen <span class="text-danger">*</span></label>
                    <select class="form-control @error('jenis_dokumen') is-invalid @enderror" id="jenis_dokumen"
                      name="jenis_dokumen" required>
                      <option value="">-- Pilih Jenis Dokumen --</option>
                      <option value="KTP"
                        {{ old('jenis_dokumen', $document->jenis_dokumen) == 'KTP' ? 'selected' : '' }}>KTP</option>
                      <option value="Kartu Keluarga"
                        {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Kartu Keluarga' ? 'selected' : '' }}>Kartu
                        Keluarga</option>
                      <option value="Slip Gaji"
                        {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Slip Gaji' ? 'selected' : '' }}>Slip Gaji
                      </option>
                      <option value="NPWP"
                        {{ old('jenis_dokumen', $document->jenis_dokumen) == 'NPWP' ? 'selected' : '' }}>NPWP</option>
                      <option value="Sertifikat Tanah"
                        {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Sertifikat Tanah' ? 'selected' : '' }}>
                        Sertifikat Tanah</option>
                      <option value="BPKB Kendaraan"
                        {{ old('jenis_dokumen', $document->jenis_dokumen) == 'BPKB Kendaraan' ? 'selected' : '' }}>BPKB
                        Kendaraan</option>
                      <option value="Rekening Koran"
                        {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Rekening Koran' ? 'selected' : '' }}>
                        Rekening Koran</option>
                      <option value="Lainnya"
                        {{ old('jenis_dokumen', $document->jenis_dokumen) == 'Lainnya' ? 'selected' : '' }}>Lainnya
                      </option>
                    </select>
                    @error('jenis_dokumen')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="kategori_kredit">Kategori Kredit <span class="text-danger">*</span></label>
                    <select class="form-control @error('kategori_kredit') is-invalid @enderror" id="kategori_kredit"
                      name="kategori_kredit" required>
                      <option value="">-- Pilih Kategori --</option>
                      <option value="KUR (Kredit Usaha Rakyat)"
                        {{ old('kategori_kredit', $document->kategori_kredit) == 'KUR (Kredit Usaha Rakyat)' ? 'selected' : '' }}>
                        KUR (Kredit Usaha Rakyat)</option>
                      <option value="KPR (Kredit Pemilikan Rumah)"
                        {{ old('kategori_kredit', $document->kategori_kredit) == 'KPR (Kredit Pemilikan Rumah)' ? 'selected' : '' }}>
                        KPR (Kredit Pemilikan Rumah)</option>
                      <option value="KKB (Kredit Kendaraan Bermotor)"
                        {{ old('kategori_kredit', $document->kategori_kredit) == 'KKB (Kredit Kendaraan Bermotor)' ? 'selected' : '' }}>
                        KKB (Kredit Kendaraan Bermotor)</option>
                      <option value="Kredit Modal Kerja"
                        {{ old('kategori_kredit', $document->kategori_kredit) == 'Kredit Modal Kerja' ? 'selected' : '' }}>
                        Kredit Modal Kerja</option>
                      <option value="Kredit Investasi"
                        {{ old('kategori_kredit', $document->kategori_kredit) == 'Kredit Investasi' ? 'selected' : '' }}>
                        Kredit Investasi</option>
                      <option value="Kredit Konsumsi"
                        {{ old('kategori_kredit', $document->kategori_kredit) == 'Kredit Konsumsi' ? 'selected' : '' }}>
                        Kredit Konsumsi</option>
                      <option value="Lainnya"
                        {{ old('kategori_kredit', $document->kategori_kredit) == 'Lainnya' ? 'selected' : '' }}>Lainnya
                      </option>
                    </select>
                    @error('kategori_kredit')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="tanggal_dokumen">Tanggal Dokumen <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_dokumen') is-invalid @enderror"
                      id="tanggal_dokumen" name="tanggal_dokumen"
                      value="{{ old('tanggal_dokumen', $document->tanggal_dokumen->format('Y-m-d')) }}" required>
                    @error('tanggal_dokumen')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="expired_date">Expired Date (Opsional)</label>
                    <input type="date" class="form-control @error('expired_date') is-invalid @enderror"
                      id="expired_date" name="expired_date"
                      value="{{ old('expired_date', $document->expired_date ? $document->expired_date->format('Y-m-d') : '') }}">
                    <small class="text-muted">Kosongkan jika tidak ada expired date</small>
                    @error('expired_date')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="document_file">File Dokumen</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input @error('document_file') is-invalid @enderror"
                    id="document_file" name="document_file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                  <label class="custom-file-label" for="document_file">
                    {{ basename($document->document_file) }} (File saat ini)
                  </label>
                  <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file. Maks 5MB</small>
                  @error('document_file')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="form-group">
                <label for="catatan">Catatan (Opsional)</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $document->catatan) }}</textarea>
                @error('catatan')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <!-- Status hanya bisa diubah oleh admin/verifikator -->
              @if (auth()->user()->role === 'verifikator')
                <!-- HANYA verifikator bisa ubah status -->
                <div class="form-group">
                  <label for="status">Status Verifikasi</label>
                  <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="pending" {{ old('status', $document->status) == 'pending' ? 'selected' : '' }}>
                      Pending</option>
                    <option value="verified" {{ old('status', $document->status) == 'verified' ? 'selected' : '' }}>
                      Verified</option>
                    <option value="rejected" {{ old('status', $document->status) == 'rejected' ? 'selected' : '' }}>
                      Rejected</option>
                    <option value="expired" {{ old('status', $document->status) == 'expired' ? 'selected' : '' }}>
                      Expired</option>
                  </select>
                </div>
              @else
                <!-- Untuk admin/staff, status tetap hidden -->
                <input type="hidden" name="status" value="{{ $document->status }}">
              @endif
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Dokumen
              </button>
              <a href="{{ route('documents.show', $document) }}" class="btn btn-default">
                <i class="fas fa-times"></i> Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      // Untuk menampilkan nama file di input file
      if (typeof bsCustomFileInput !== 'undefined') {
        bsCustomFileInput.init();
      }
    });
  </script>
@endsection
