@extends('layouts.app')

@section('title', 'Detail Nasabah')
@section('page-title', 'Detail Nasabah: ' . $nasabah->nama_nasabah)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('reports.per-nasabah') }}">Laporan per Nasabah</a></li>
  <li class="breadcrumb-item active">Detail: {{ $nasabah->nama_nasabah }}</li>
@endsection

@section('content')
  <div class="container-fluid">
    <!-- Header Card -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
          <i class="fas fa-user mr-2"></i>Data Nasabah
        </h3>
        <div class="card-tools">
          <a href="{{ route('reports.per-nasabah.pdf', ['nasabah' => $nasabah->no_rekening, 'preview' => 1]) }}"
            class="btn btn-light btn-sm" target="_blank">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF
          </a>
          <a href="{{ route('reports.per-nasabah') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-sm">
              <tr>
                <th width="40%">Nama Nasabah</th>
                <td>{{ $nasabah->nama_nasabah }}</td>
              </tr>
              <tr>
                <th>No. Rekening</th>
                <td>{{ $nasabah->no_rekening }}</td>
              </tr>
              <tr>
                <th>No. KTP</th>
                <td>{{ $nasabah->no_ktp }}</td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td>{{ $nasabah->alamat }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-sm">
              <tr>
                <th width="40%">Telepon</th>
                <td>{{ $nasabah->telepon }}</td>
              </tr>
              <tr>
                <th>Total Dokumen</th>
                <td><span class="badge badge-primary">{{ $stats['total'] }}</span></td>
              </tr>
              <tr>
                <th>Status Dokumen</th>
                <td>
                  <span class="badge badge-warning">Pending: {{ $stats['pending'] }}</span>
                  <span class="badge badge-success">Verified: {{ $stats['verified'] }}</span>
                  <span class="badge badge-danger">Rejected: {{ $stats['rejected'] }}</span>
                  <span class="badge badge-secondary">Expired: {{ $stats['expired'] }}</span>
                </td>
              </tr>
              <tr>
                <th>Terakhir Update</th>
                <td>{{ $nasabah->updated_at->format('d/m/Y H:i') }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Dokumen List -->
    <div class="card mt-3">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-file-alt mr-1"></i>
          Dokumen Nasabah ({{ $documents->count() }})
        </h3>
      </div>
      <div class="card-body p-0">
        @if ($documents->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Jenis Dokumen</th>
                  <th>Kategori Kredit</th>
                  <th>Tanggal Dokumen</th>
                  <th>Expired Date</th>
                  <th>Status</th>
                  <th>Catatan</th>
                  <th>Tanggal Upload</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($documents as $doc)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                      <i class="fas {{ $doc->document_type_icon }} mr-1"></i>
                      {{ $doc->jenis_dokumen }}
                    </td>
                    <td>
                      <span class="badge badge-light">
                        {{ $doc->kategori_kredit }}
                      </span>
                    </td>
                    <td>{{ $doc->tanggal_dokumen_formatted }}</td>
                    <td>{!! $doc->expired_date_formatted !!}</td>
                    <td>{!! $doc->status_badge !!}</td>
                    <td>
                      @if ($doc->catatan)
                        <small>{{ Str::limit($doc->catatan, 30) }}</small>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                    <td>
                      <a href="{{ route('documents.show', $doc) }}" class="btn btn-xs btn-info">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="{{ route('documents.download', $doc) }}" class="btn btn-xs btn-success">
                        <i class="fas fa-download"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-4">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada dokumen</h5>
            <p class="text-muted">Nasabah ini belum memiliki dokumen</p>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
