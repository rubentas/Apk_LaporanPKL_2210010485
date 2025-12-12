@extends('layouts.app')

@section('title', 'Detail Dokumen')
@section('page-title', 'Detail Dokumen #' . $document->id)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
  <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-info-circle mr-2"></i>
              Informasi Dokumen
            </h3>
            <div class="card-tools">
              <a href="{{ route('documents.download', $document) }}" class="btn btn-success btn-sm">
                <i class="fas fa-download"></i> Download
              </a>
              <a href="{{ route('documents.index') }}" class="btn btn-default btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Kolom Kiri -->
              <div class="col-md-6">
                <table class="table table-bordered">
                  <tr>
                    <th width="40%">ID Dokumen</th>
                    <td>{{ $document->id }}</td>
                  </tr>
                  <tr>
                    <th>Nama Nasabah</th>
                    <td>{{ $document->nama_nasabah }}</td>
                  </tr>
                  <tr>
                    <th>No Rekening</th>
                    <td>{{ $document->no_rekening }}</td>
                  </tr>
                  <tr>
                    <th>No KTP</th>
                    <td>{{ $document->no_ktp }}</td>
                  </tr>
                  <tr>
                    <th>Telepon</th>
                    <td>{{ $document->telepon }}</td>
                  </tr>
                  <tr>
                    <th>Alamat</th>
                    <td>{{ $document->alamat }}</td>
                  </tr>
                </table>
              </div>

              <!-- Kolom Kanan -->
              <div class="col-md-6">
                <table class="table table-bordered">
                  <tr>
                    <th width="40%">Jenis Dokumen</th>
                    <td>
                      <i class="fas {{ $document->document_type_icon }}"></i>
                      {{ $document->jenis_dokumen }}
                    </td>
                  </tr>
                  <tr>
                    <th>Kategori Kredit</th>
                    <td>
                      <span class="badge badge-{{ $document->kategori_color }}">
                        {{ $document->kategori_kredit }}
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td>{!! $document->status_badge !!}</td>
                  </tr>
                  <tr>
                    <th>Tanggal Dokumen</th>
                    <td>{{ $document->tanggal_dokumen->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <th>Expired Date</th>
                    <td>
                      @if ($document->expired_date)
                        {{ $document->expired_date->format('d/m/Y') }}
                        @if ($document->expired_date->isPast())
                          <span class="badge badge-danger ml-2">Expired</span>
                        @elseif($document->expired_date->diffInDays(now()) <= 30)
                          <span class="badge badge-warning ml-2">Segera Expired</span>
                        @endif
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>File</th>
                    <td>
                      <i class="fas fa-file mr-1"></i>
                      <a href="{{ route('documents.download', $document) }}" class="text-primary">
                        Download Dokumen
                      </a>
                      <br>
                      <small class="text-muted">
                        {{ basename($document->document_file) }}
                      </small>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <!-- Catatan -->
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-sticky-note mr-2"></i>
                      Catatan
                    </h3>
                  </div>
                  <div class="card-body">
                    @if ($document->catatan)
                      <p>{{ $document->catatan }}</p>
                    @else
                      <p class="text-muted">Tidak ada catatan</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <!-- Form Verifikasi (hanya untuk verifikator & admin) -->
            @if ($document->status == 'pending' && in_array(auth()->user()->role, ['admin', 'verifikator']))
              <div class="row mt-4">
                <div class="col-md-12">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-check-circle mr-2"></i>
                        Verifikasi Dokumen
                      </h3>
                    </div>
                    <div class="card-body">
                      <form action="{{ route('documents.verify', $document) }}" method="POST">
                        @csrf

                        <div class="form-group">
                          <label for="status">Status Verifikasi</label>
                          <select name="status" id="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="verified">Setujui (Verified)</option>
                            <option value="rejected">Tolak (Rejected)</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="catatan">Catatan Verifikasi</label>
                          <textarea name="catatan" id="catatan" class="form-control" rows="3"
                            placeholder="Masukkan catatan verifikasi..."></textarea>
                          <small class="text-muted">Wajib diisi jika menolak dokumen</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                          <i class="fas fa-check"></i> Submit Verifikasi
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endif

            <!-- Informasi Sistem -->
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="alert alert-info">
                  <h5><i class="fas fa-info-circle mr-2"></i> Informasi Sistem</h5>
                  <p class="mb-1">
                    <strong>Diupload oleh:</strong>
                    {{ $document->uploadedBy->name ?? 'Sistem' }}
                  </p>
                  <p class="mb-1">
                    <strong>Tanggal Upload:</strong>
                    {{ $document->created_at->format('d/m/Y H:i:s') }}
                  </p>
                  <p class="mb-0">
                    <strong>Terakhir diupdate:</strong>
                    {{ $document->updated_at->format('d/m/Y H:i:s') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      // Validasi form verifikasi
      $('form').submit(function() {
        const status = $('#status').val();
        const catatan = $('#catatan').val();

        if (status === 'rejected' && catatan.trim() === '') {
          alert('Catatan wajib diisi jika menolak dokumen!');
          $('#catatan').focus();
          return false;
        }

        if (!status) {
          alert('Pilih status verifikasi!');
          return false;
        }

        return confirm('Apakah Anda yakin ingin ' +
          (status === 'verified' ? 'menyetujui' : 'menolak') +
          ' dokumen ini?');
      });
    });
  </script>
@endsection
