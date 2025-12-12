@extends('layouts.app')

@section('title', 'Daftar Dokumen')
@section('page-title', 'Daftar Dokumen Nasabah')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Dokumen</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-file-alt mr-2"></i>
              Daftar Dokumen
            </h3>
            <div class="card-tools">
              <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Upload Dokumen Baru
              </a>
            </div>
          </div>
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            @if ($documents->count() > 0)
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="documents-table">
                  <thead class="thead-light">
                    <tr>
                      <th width="50">ID</th>
                      <th>Nasabah</th>
                      <th>No Rekening</th>
                      <th>Jenis Dokumen</th>
                      <th>Kategori</th>
                      <th>Status</th>
                      <th>Tanggal Upload</th>
                      <th width="150" class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($documents as $document)
                      <tr>
                        <td class="text-center">{{ $document->id }}</td>
                        <td>
                          <strong>{{ $document->nama_nasabah }}</strong><br>
                          <small class="text-muted">KTP: {{ $document->no_ktp }}</small>
                        </td>
                        <td>{{ $document->no_rekening }}</td>
                        <td>
                          <i class="fas {{ $document->document_type_icon }} mr-1"></i>
                          {{ $document->jenis_dokumen }}
                        </td>
                        <td>
                          <span class="badge badge-{{ $document->kategori_color }}">
                            {{ $document->kategori_kredit }}
                          </span>
                        </td>
                        <td>{!! $document->status_badge !!}</td>
                        <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                          <div class="btn-group btn-group-sm">
                            <a href="{{ route('documents.show', $document) }}" class="btn btn-info" title="Detail">
                              <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('documents.download', $document) }}" class="btn btn-success"
                              title="Download">
                              <i class="fas fa-download"></i>
                            </a>

                            <!-- EDIT - hanya untuk dokumen pending atau admin -->
                            @if ($document->status == 'pending' || auth()->user()->isAdmin())
                              <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                              </a>
                            @endif

                            <!-- VERIFIKASI - hanya untuk verifikator & dokumen pending -->
                            @if (auth()->user()->isVerifikator() && $document->status === 'pending')
                              <a href="{{ route('documents.show', $document) }}" class="btn btn-primary"
                                title="Verifikasi">
                                <i class="fas fa-check"></i>
                              </a>
                            @endif

                            <!-- DELETE - dengan confirmation -->
                            <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="mt-3">
                {{ $documents->links() }}
              </div>
            @else
              <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h4>Belum ada dokumen</h4>
                <p>Mulai dengan mengupload dokumen nasabah pertama Anda</p>
                <a href="{{ route('documents.create') }}" class="btn btn-primary btn-lg">
                  <i class="fas fa-plus"></i> Upload Dokumen Pertama
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @if ($documents->count() > 0)
    <script>
      $(document).ready(function() {
        // Initialize DataTable
        $('#documents-table').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": false,
          "autoWidth": false,
          "responsive": true,
          "language": {
            "search": "Cari:",
            "emptyTable": "Tidak ada data"
          }
        });
      });
    </script>
  @endif
@endsection
