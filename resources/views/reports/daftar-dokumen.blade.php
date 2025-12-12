@extends('layouts.app')

@section('title', 'Laporan Daftar Dokumen')
@section('page-title', 'Laporan Daftar Dokumen')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Laporan Daftar Dokumen</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-file-pdf mr-2"></i>
              Laporan Daftar Dokumen
            </h3>
          </div>

          <!-- Filter Section -->
          <div class="card-body">
            <h5><i class="fas fa-filter mr-2"></i> Filter Laporan</h5>
            <form method="GET" action="{{ route('reports.daftar-dokumen') }}" class="mb-4">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Status Dokumen</label>
                    <select name="status" class="form-control">
                      <option value="">Semua Status</option>
                      @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                          {{ ucfirst($status) }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Kategori Kredit</label>
                    <select name="kategori_kredit" class="form-control">
                      <option value="">Semua Kategori</option>
                      @foreach ($kategories as $kategori)
                        <option value="{{ $kategori }}"
                          {{ request('kategori_kredit') == $kategori ? 'selected' : '' }}>
                          {{ $kategori }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search mr-2"></i> Terapkan Filter
                  </button>
                  <a href="{{ route('reports.daftar-dokumen') }}" class="btn btn-secondary">
                    <i class="fas fa-redo mr-2"></i> Reset Filter
                  </a>
                </div>
              </div>
            </form>

            <!-- Summary Info -->
            <div class="alert alert-info">
              <i class="fas fa-info-circle mr-2"></i>
              Menampilkan <strong>{{ $documents->count() }}</strong> dokumen
              @if (request()->anyFilled(['status', 'kategori_kredit', 'start_date', 'end_date']))
                berdasarkan filter yang diterapkan
              @endif
            </div>

            <!-- Action Buttons SIMPLE -->
            <div class="mb-3">
              <a href="{{ route('reports.daftar-dokumen.pdf', array_merge(request()->query(), ['preview' => 1])) }}"
                class="btn btn-danger" target="_blank">
                <i class="fas fa-eye mr-2"></i> Preview PDF
              </a>

              <a href="{{ route('reports.daftar-dokumen.pdf', request()->query()) }}" class="btn btn-primary">
                <i class="fas fa-download mr-2"></i> Download PDF
              </a>
            </div>

            <!-- Data Table TANPA CHECKBOX -->
            @if ($documents->count() > 0)
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead class="thead-light">
                    <tr>
                      <th width="50">ID</th>
                      <th>Nasabah</th>
                      <th>No Rekening</th>
                      <th>Jenis Dokumen</th>
                      <th>Kategori</th>
                      <th>Status</th>
                      <th>Tanggal Upload</th>
                      <th>Expired Date</th>
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
                        <td>
                          @if ($document->expired_date)
                            {{ $document->expired_date->format('d/m/Y') }}
                            @if ($document->expired_date->isPast())
                              <span class="badge badge-danger ml-1">Expired</span>
                            @endif
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Tidak ada data dokumen yang ditemukan berdasarkan filter yang diterapkan.
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    // Simple DataTable initialization (optional)
    $(document).ready(function() {
      $('table').DataTable({
        "paging": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "responsive": true
      });
    });
  </script>
@endsection
