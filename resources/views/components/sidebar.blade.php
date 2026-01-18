<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo - SIMPLE CENTERED -->
  <div class="text-center py-2" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
    <a href="{{ route('dashboard') }}">
      <img src="{{ asset('adminlte/dist/img/LogoBankBRI.png') }}" alt="BRI Logo"
        style="height: 40px; width: auto; filter: brightness(0) invert(1);">
    </a>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <img
          src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin BRI') }}&background=0033a0&color=fff&size=128"
          class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('settings.profile') }}" class="d-block user-name">
          {{ Auth::user()->name ?? 'Admin BRI' }}
        </a>
        <span class="badge badge-info badge-sm">
          <i class="fas fa-shield-alt mr-1"></i>
          {{ Auth::user()->isAdmin() ? 'Admin' : 'Verifikator' }}
        </span>
      </div>
    </div>

    <!-- Search Form -->
    <div class="form-inline px-3 pb-3">
      <div class="input-group input-group-sm w-100">
        <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..." aria-label="Search"
          id="sidebar-search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu"
        data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <span class="badge badge-primary right d-none d-lg-inline">Home</span>
            </p>
          </a>
        </li>

        <!-- Divider -->
        <li class="nav-header">DOKUMEN MANAGEMENT</li>

        <!-- Dokumen -->
        <li class="nav-item {{ request()->routeIs('documents.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-folder-open"></i>
            <p>
              Dokumen
              <i class="right fas fa-angle-left"></i>
              @php
                $pendingCount = App\Models\Document::where('status', 'pending')->count();
              @endphp
              @if ($pendingCount > 0)
                <span class="badge badge-warning right">{{ $pendingCount }}</span>
              @endif
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('documents.index') }}"
                class="nav-link {{ request()->routeIs('documents.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Daftar Dokumen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('documents.create') }}"
                class="nav-link {{ request()->routeIs('documents.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Upload Dokumen</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Analisis  -->
        <li class="nav-item {{ request()->routeIs('analysis.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('analysis.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
              Analisis
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('analysis.rekomendasi') }}"
                class="nav-link {{ request()->routeIs('analysis.rekomendasi') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Rekomendasi Nasabah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('analysis.kategori') }}"
                class="nav-link {{ request()->routeIs('analysis.kategori') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Analisis Kategori</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Divider -->
        <li class="nav-header">LAPORAN & STATISTIK</li>

        <!-- Laporan -->
        <li class="nav-item {{ request()->routeIs('reports.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>
              Laporan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('reports.daftar-dokumen') }}"
                class="nav-link {{ request()->routeIs('reports.daftar-dokumen') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Daftar Dokumen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.statistik-dokumen') }}"
                class="nav-link {{ request()->routeIs('reports.statistik-dokumen') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Statistik Dokumen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.per-nasabah') }}"
                class="nav-link {{ request()->routeIs('reports.per-nasabah') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Per Nasabah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.aktivitas-pengguna') }}"
                class="nav-link {{ request()->routeIs('reports.aktivitas-pengguna') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Aktivitas Pengguna</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.dokumen-bermasalah') }}"
                class="nav-link {{ request()->routeIs('reports.dokumen-bermasalah') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Dok. Bermasalah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.dokumen-per-kategori') }}"
                class="nav-link {{ request()->routeIs('reports.dokumen-per-kategori') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Per Kategori Kredit</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.kredit-akan-selesai') }}"
                class="nav-link {{ request()->routeIs('reports.kredit-akan-selesai') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Kredit Akan Selesai</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Divider -->
        <li class="nav-header">SISTEM</li>

        <!-- Management User -->
        <li class="nav-item">
          <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Management User</p>
          </a>
        </li>

        <!-- Settings -->
        <li class="nav-item {{ request()->routeIs('settings.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Pengaturan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('settings.profile') }}"
                class="nav-link {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Profil</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('settings.about') }}"
                class="nav-link {{ request()->routeIs('settings.about') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon text-sm"></i>
                <p>Tentang Sistem</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Divider -->
        <li class="nav-header"></li>

        <!-- Logout -->
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link nav-link-logout"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Logout
              <span class="right d-none d-lg-inline">
                <i class="fas fa-arrow-right"></i>
              </span>
            </p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

@push('styles')
  <style>
    /* ============================================
                         CUSTOM SIDEBAR STYLES (Compatible with AdminLTE)
                         ============================================ */

    /* Logo Container - Simple Center */
    .text-center.py-2 {
      text-align: center !important;
      padding-top: 0.8rem !important;
      padding-bottom: 0.8rem !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    .text-center.py-2 img {
      height: 40px;
      width: auto;
      filter: brightness(0) invert(1);
      display: inline-block !important;
    }

    /* User Panel Responsive */
    .user-panel .info {
      overflow: hidden;
    }

    .user-name {
      font-size: 0.95rem;
      font-weight: 600;
      word-break: break-word;
      white-space: normal;
      line-height: 1.3;
      display: block;
      margin-bottom: 0.25rem;
    }

    .badge-sm {
      font-size: 0.65rem;
      padding: 0.2rem 0.4rem;
    }

    /* Search Sidebar */
    .form-control-sidebar {
      background-color: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .form-control-sidebar::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }

    .form-control-sidebar:focus {
      background-color: rgba(255, 255, 255, 0.15);
      border-color: rgba(255, 255, 255, 0.3);
      color: #fff;
    }

    .btn-sidebar {
      background-color: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    /* Nav Headers */
    .nav-header {
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      padding: 0.5rem 1rem;
      margin-top: 0.5rem;
    }

    /* Nav Items */
    .nav-sidebar .nav-item {
      margin-bottom: 0.1rem;
    }

    .nav-sidebar .nav-link {
      padding: 0.6rem 1rem;
      border-radius: 0.25rem;
      margin: 0 0.5rem;
      transition: all 0.2s ease;
    }

    .nav-sidebar .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateX(3px);
    }

    .nav-sidebar .nav-link.active {
      background-color: #007bff !important;
      box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
    }

    /* Nav Icons */
    .nav-icon {
      width: 1.6rem;
      text-align: center;
    }

    /* Treeview */
    .nav-treeview>.nav-item>.nav-link {
      padding-left: 2.5rem;
      font-size: 0.9rem;
    }

    .nav-treeview .nav-icon {
      font-size: 0.7rem;
    }

    /* Badges in Sidebar */
    .nav-link .badge {
      font-size: 0.65rem;
      padding: 0.2rem 0.5rem;
      margin-left: 0.25rem;
    }

    /* Logout Link */
    .nav-link-logout {
      background-color: rgba(220, 53, 69, 0.1) !important;
      color: #dc3545 !important;
    }

    .nav-link-logout:hover {
      background-color: #dc3545 !important;
      color: #fff !important;
      transform: translateX(3px);
    }

    /* Compact Navigation (Optional) */
    .nav-compact .nav-link {
      padding: 0.5rem 1rem;
    }

    .nav-compact .nav-link p {
      font-size: 0.9rem;
    }

    /* ============================================
                         RESPONSIVE BREAKPOINTS
                         ============================================ */

    /* Tablet & Mobile */
    @media (max-width: 991.98px) {
      .text-center.py-2 img {
        height: 35px !important;
      }

      .user-name {
        font-size: 0.85rem;
      }

      .nav-sidebar .nav-link p {
        font-size: 0.85rem;
      }

      .nav-header {
        font-size: 0.65rem;
        padding: 0.4rem 0.8rem;
      }

      .nav-treeview>.nav-item>.nav-link {
        padding-left: 2rem;
      }
    }

    /* Mobile Only */
    @media (max-width: 767.98px) {
      .text-center.py-2 {
        padding-top: 0.6rem !important;
        padding-bottom: 0.6rem !important;
      }

      .text-center.py-2 img {
        height: 32px !important;
      }

      .sidebar {
        padding-top: 0;
      }

      .user-panel {
        margin-top: 1rem !important;
        padding-bottom: 1rem !important;
        margin-bottom: 1rem !important;
      }

      .nav-sidebar .nav-link {
        padding: 0.5rem 0.8rem;
        margin: 0 0.3rem;
      }

      .form-inline {
        padding: 0 0.8rem 1rem !important;
      }
    }

    /* Sidebar Collapsed State */
    .sidebar-collapse .brand-text {
      display: none !important;
    }

    .sidebar-collapse .main-sidebar:hover .brand-text {
      display: block !important;
      opacity: 1;
    }

    .sidebar-collapse .user-panel .info {
      display: none;
    }

    .sidebar-collapse .nav-sidebar .nav-link p {
      width: 0;
      opacity: 0;
      overflow: hidden;
    }

    .sidebar-collapse .nav-header {
      opacity: 0;
      height: 0;
      padding: 0;
      margin: 0;
    }

    .sidebar-collapse .form-inline {
      display: none;
    }

    /* Hover effect when collapsed */
    .sidebar-collapse .main-sidebar:hover .user-panel .info,
    .sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-link p,
    .sidebar-collapse .main-sidebar:hover .nav-header,
    .sidebar-collapse .main-sidebar:hover .form-inline {
      display: block;
      opacity: 1;
      width: auto;
      height: auto;
      padding: inherit;
      margin: inherit;
    }

    /* Smooth Scrollbar */
    .sidebar {
      overflow-y: auto;
      overflow-x: hidden;
      scrollbar-width: thin;
      scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }

    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
      background-color: rgba(255, 255, 255, 0.3);
    }

    /* Animation for menu open/close */
    .nav-treeview {
      animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      // Sidebar Search Functionality
      $('#sidebar-search').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();

        $('.nav-sidebar .nav-item').each(function() {
          var menuText = $(this).text().toLowerCase();

          if (menuText.indexOf(searchText) > -1) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });

        // Show all if search is empty
        if (searchText === '') {
          $('.nav-sidebar .nav-item').show();
        }
      });

      // Auto collapse sidebar on mobile after click
      if ($(window).width() < 992) {
        $('.nav-sidebar .nav-link').on('click', function() {
          if (!$(this).parent().hasClass('nav-item') || !$(this).next('.nav-treeview').length) {
            $('body').removeClass('sidebar-open').addClass('sidebar-collapse sidebar-closed');
          }
        });
      }

      // Smooth scroll to active menu
      var activeMenu = $('.nav-sidebar .nav-link.active');
      if (activeMenu.length) {
        setTimeout(function() {
          activeMenu[0].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
        }, 500);
      }
    });
  </script>
@endpush
