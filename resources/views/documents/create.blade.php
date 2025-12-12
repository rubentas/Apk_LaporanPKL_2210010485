@extends('layouts.app')

@section('title', 'Upload Dokumen Baru')
@section('page-title', 'Upload Dokumen Baru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
  <li class="breadcrumb-item active">Upload Baru</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-upload mr-2"></i>
              Form Upload Dokumen Nasabah
            </h3>
          </div>
          <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama_nasabah">Nama Nasabah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_nasabah') is-invalid @enderror"
                      id="nama_nasabah" name="nama_nasabah" value="{{ old('nama_nasabah') }}" required
                      placeholder="Masukkan nama nasabah">
                    @error('nama_nasabah')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="no_rekening">No Rekening <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_rekening') is-invalid @enderror" id="no_rekening"
                      name="no_rekening" value="{{ old('no_rekening') }}" required placeholder="Masukkan nomor rekening">
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
                      name="no_ktp" value="{{ old('no_ktp') }}" required placeholder="Masukkan nomor KTP">
                    @error('no_ktp')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="telepon">Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                      name="telepon" value="{{ old('telepon') }}" required placeholder="Masukkan nomor telepon">
                    @error('telepon')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                  required placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
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
                      <option value="KTP" {{ old('jenis_dokumen') == 'KTP' ? 'selected' : '' }}>KTP</option>
                      <option value="Kartu Keluarga" {{ old('jenis_dokumen') == 'Kartu Keluarga' ? 'selected' : '' }}>
                        Kartu Keluarga</option>
                      <option value="Slip Gaji" {{ old('jenis_dokumen') == 'Slip Gaji' ? 'selected' : '' }}>Slip Gaji
                      </option>
                      <option value="NPWP" {{ old('jenis_dokumen') == 'NPWP' ? 'selected' : '' }}>NPWP</option>
                      <option value="Sertifikat Tanah"
                        {{ old('jenis_dokumen') == 'Sertifikat Tanah' ? 'selected' : '' }}>Sertifikat Tanah</option>
                      <option value="BPKB Kendaraan" {{ old('jenis_dokumen') == 'BPKB Kendaraan' ? 'selected' : '' }}>
                        BPKB Kendaraan</option>
                      <option value="Rekening Koran" {{ old('jenis_dokumen') == 'Rekening Koran' ? 'selected' : '' }}>
                        Rekening Koran</option>
                      <option value="Lainnya" {{ old('jenis_dokumen') == 'Lainnya' ? 'selected' : '' }}>Lainnya
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
                        {{ old('kategori_kredit') == 'KUR (Kredit Usaha Rakyat)' ? 'selected' : '' }}>KUR (Kredit
                        Usaha Rakyat)</option>
                      <option value="KPR (Kredit Pemilikan Rumah)"
                        {{ old('kategori_kredit') == 'KPR (Kredit Pemilikan Rumah)' ? 'selected' : '' }}>KPR (Kredit
                        Pemilikan Rumah)</option>
                      <option value="KKB (Kredit Kendaraan Bermotor)"
                        {{ old('kategori_kredit') == 'KKB (Kredit Kendaraan Bermotor)' ? 'selected' : '' }}>KKB
                        (Kredit Kendaraan Bermotor)</option>
                      <option value="Kredit Modal Kerja"
                        {{ old('kategori_kredit') == 'Kredit Modal Kerja' ? 'selected' : '' }}>Kredit Modal Kerja
                      </option>
                      <option value="Kredit Investasi"
                        {{ old('kategori_kredit') == 'Kredit Investasi' ? 'selected' : '' }}>Kredit Investasi
                      </option>
                      <option value="Kredit Konsumsi"
                        {{ old('kategori_kredit') == 'Kredit Konsumsi' ? 'selected' : '' }}>Kredit Konsumsi</option>
                      <option value="Lainnya" {{ old('kategori_kredit') == 'Lainnya' ? 'selected' : '' }}>Lainnya
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
                      id="tanggal_dokumen" name="tanggal_dokumen" value="{{ old('tanggal_dokumen') }}" required>
                    @error('tanggal_dokumen')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="expired_date">Expired Date (Opsional)</label>
                    <input type="date" class="form-control @error('expired_date') is-invalid @enderror"
                      id="expired_date" name="expired_date" value="{{ old('expired_date') }}">
                    <small class="text-muted">Kosongkan jika tidak ada expired date</small>
                    @error('expired_date')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="document_file">File Dokumen <span class="text-danger">*</span></label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input @error('document_file') is-invalid @enderror"
                    id="document_file" name="document_file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                  <label class="custom-file-label" for="document_file">Pilih file (PDF, JPG, PNG, DOC, DOCX, max
                    5MB)</label>
                  @error('document_file')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
                <small class="text-muted">Maksimal ukuran file: 5MB</small>
              </div>

              <div class="form-group">
                <label for="catatan">Catatan (Opsional)</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                  placeholder="Masukkan catatan tambahan jika perlu">{{ old('catatan') }}</textarea>
                @error('catatan')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload Dokumen
              </button>
              <a href="{{ route('documents.index') }}" class="btn btn-default">
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
