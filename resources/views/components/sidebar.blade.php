<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link text-center">
    <img src="{{ asset('adminlte/dist/img/LogoBankBRI.png') }}" alt="BRI Logo"
      style="width: 100%; max-width: 100px; height: auto; filter: brightness(0) invert(1);">
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img
          src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin+BRI' }}&background=ffffff&color=0033a0&size=128"
          class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"
          style="word-break: break-word; white-space: normal; vertical-align: middle; margin-top: -5px;">
          {{ Auth::user()->name ?? 'Admin BRI' }}
        </a>
        <small class="text-light">
          {{ Auth::user()->isAdmin() ? 'Administrator' : 'Verifikator' }}
        </small>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Dokumen -->
        <li class="nav-item {{ request()->routeIs('documents.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-folder"></i>
            <p>
              Dokumen
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('documents.index') }}"
                class="nav-link {{ request()->routeIs('documents.index') ? 'active' : '' }}">
                <i class="fas fa-list nav-icon"></i>
                <p>Daftar Dokumen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('documents.create') }}"
                class="nav-link {{ request()->routeIs('documents.create') ? 'active' : '' }}">
                <i class="fas fa-upload nav-icon"></i>
                <p>Upload Dokumen</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Laporan -->
        <li class="nav-item {{ request()->routeIs('reports.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
              Laporan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('reports.daftar-dokumen') }}"
                class="nav-link {{ request()->routeIs('reports.daftar-dokumen') ? 'active' : '' }}">
                <i class="fas fa-file-alt nav-icon"></i>
                <p>Daftar Dokumen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.statistik-dokumen') }}"
                class="nav-link {{ request()->routeIs('reports.statistik-dokumen') ? 'active' : '' }}">
                <i class="fas fa-chart-pie nav-icon"></i>
                <p>Statistik Dokumen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.per-nasabah') }}"
                class="nav-link {{ request()->routeIs('reports.per-nasabah') ? 'active' : '' }}">
                <i class="fas fa-user-friends nav-icon"></i>
                <p>Per Nasabah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.aktivitas-pengguna') }}"
                class="nav-link {{ request()->routeIs('reports.aktivitas-pengguna') ? 'active' : '' }}">
                <i class="fas fa-history nav-icon"></i>
                <p>Aktivitas Pengguna</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.dokumen-bermasalah') }}"
                class="nav-link {{ request()->routeIs('reports.dokumen-bermasalah') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle nav-icon"></i>
                <p>Dokumen Bermasalah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.dokumen-per-kategori') }}"
                class="nav-link {{ request()->routeIs('reports.dokumen-per-kategori') ? 'active' : '' }}">
                <i class="fas fa-filter nav-icon"></i>
                <p>Per Kategori Kredit</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Management User (Admin only) -->
        @if (auth()->check() && auth()->user()->isAdmin())
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Management User</p>
            </a>
          </li>
        @endif

        <!-- Settings -->
        <li class="nav-item {{ request()->routeIs('settings.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('settings.profile') }}"
                class="nav-link {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
                <i class="fas fa-user nav-icon"></i>
                <p>Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('settings.about') }}"
                class="nav-link {{ request()->routeIs('settings.about') ? 'active' : '' }}">
                <i class="fas fa-info-circle nav-icon"></i>
                <p>About System</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link text-danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </nav>
  </div>
</aside>
