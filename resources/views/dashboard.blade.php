@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
  <!-- Info boxes -->
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Dokumen</span>
          <span class="info-box-number">{{ $totalDocuments ?? 0 }}</span>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Pending Verification</span>
          <span class="info-box-number">{{ $pendingDocuments ?? 0 }}</span>
        </div>
      </div>
    </div>

    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Verified</span>
          <span class="info-box-number">{{ $verifiedDocuments ?? 0 }}</span>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Rejected</span>
          <span class="info-box-number">{{ $rejectedDocuments ?? 0 }}</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-7">
      <!-- Dokumen Terbaru -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-file-alt mr-1"></i>
            Dokumen Terbaru
          </h3>
          <div class="card-tools">
            <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i> Upload Baru
            </a>
          </div>
        </div>
        <div class="card-body">
          @if (isset($recentDocuments) && $recentDocuments->count() > 0)
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Nasabah</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($recentDocuments as $document)
                    <tr>
                      <td>
                        <strong>{{ $document->nama_nasabah }}</strong><br>
                        <small>{{ $document->no_rekening }}</small>
                      </td>
                      <td>
                        <span class="badge badge-light">
                          <i class="fas {{ $document->document_type_icon }}"></i>
                          {{ $document->jenis_dokumen }}
                        </span>
                      </td>
                      <td>{!! $document->status_badge !!}</td>
                      <td>{{ $document->created_at->format('d/m/Y') }}</td>
                      <td>
                        <a href="{{ route('documents.show', $document) }}" class="btn btn-xs btn-info">
                          <i class="fas fa-eye"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="empty-state">
              <i class="fas fa-folder-open"></i>
              <h4>Belum ada dokumen</h4>
              <p>Mulai dengan mengupload dokumen nasabah pertama Anda</p>
              <a href="{{ route('documents.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Upload Dokumen Pertama
              </a>
            </div>
          @endif
        </div>
      </div>
    </section>

    <!-- Right col -->
    <section class="col-lg-5">
      <!-- Welcome Card -->
      <div class="card bg-gradient-primary">
        <div class="card-header">
          <h3 class="card-title" style="color: black;">
            <i class="fas fa-user-circle mr-1" style="color: black;"></i>
            Selamat Datang
          </h3>
        </div>
        <div class="card-body">
          <h4 class="text-white">{{ Auth::user()->name }}!</h4>
          <p class="text-white-50">
            Anda login sebagai <strong class="text-white">
              {{ Auth::user()->isAdmin() ? 'Administrator' : 'Verifikator' }}
            </strong><br>
            <small><i class="far fa-clock"></i> Login terakhir: {{ now()->format('d/m/Y H:i:s') }}</small>
          </p>
          <a href="{{ route('documents.create') }}" class="btn btn-light">
            <i class="fas fa-upload"></i> Upload Dokumen
          </a>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-tasks mr-1"></i>
            Quick Actions
          </h3>
        </div>
        <div class="card-body">
          <div class="list-group">
            <a href="{{ route('documents.create') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-upload mr-2"></i> Upload Dokumen Baru
            </a>
            <a href="{{ route('documents.index') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-list mr-2"></i> Lihat Semua Dokumen
            </a>
            @if (Auth::user()->isAdmin())
              <a href="#" class="list-group-item list-group-item-action">
                <i class="fas fa-users mr-2"></i> Management User
              </a>
            @endif
            <a href="#" class="list-group-item list-group-item-action">
              <i class="fas fa-chart-bar mr-2"></i> Generate Laporan
            </a>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
