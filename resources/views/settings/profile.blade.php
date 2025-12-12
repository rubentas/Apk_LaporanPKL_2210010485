@extends('layouts.app')

@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Profile Settings</li>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-user mr-1"></i>
              Profile Information
            </h3>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('settings.profile.update') }}">
              @csrf
              @method('PUT')

              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name"
                  value="{{ old('name', $user->name) }}" required>
                @error('name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                <small class="text-muted">Email tidak dapat diubah</small>
              </div>

              <div class="form-group">
                <label for="role">Role</label>
                <input type="text" class="form-control"
                  value="{{ $user->isAdmin() ? 'Administrator' : 'Verifikator' }}" disabled>
              </div>

              <hr>

              <h5 class="mb-3"><i class="fas fa-key mr-1"></i> Ubah Password</h5>

              <div class="form-group">
                <label for="current_password">Password Saat Ini</label>
                <input type="password" class="form-control" id="current_password" name="current_password">
                @error('current_password')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="new_password">Password Baru</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
                @error('new_password')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="new_password_confirmation"
                  name="new_password_confirmation">
              </div>

              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Update Profile
              </button>
              <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-times mr-1"></i> Batal
              </a>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-info-circle mr-1"></i>
              Informasi Akun
            </h3>
          </div>
          <div class="card-body">
            <table class="table table-sm">
              <tr>
                <th width="40%">Tanggal Registrasi</th>
                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
              </tr>
              <tr>
                <th>Terakhir Login</th>
                <td>
                  @if ($user->last_login_at)
                    {{ $user->last_login_at->format('d/m/Y H:i') }}
                  @else
                    <span class="text-muted">Belum pernah login</span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Total Dokumen Diupload</th>
                <td>
                  {{ $user->documentsUploaded()->count() }} dokumen
                </td>
              </tr>
              <tr>
                <th>Total Aktivitas</th>
                <td>
                  {{ $user->activityLogs()->count() }} aktivitas
                </td>
              </tr>
            </table>

            <div class="alert alert-info mt-3">
              <h6><i class="fas fa-lightbulb mr-1"></i> Tips Keamanan</h6>
              <small>
                • Gunakan password yang kuat (minimal 6 karakter)<br>
                • Jangan bagikan password ke siapapun<br>
                • Logout setelah selesai menggunakan sistem
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
