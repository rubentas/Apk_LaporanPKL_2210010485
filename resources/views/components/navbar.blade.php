<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user mr-1"></i>
        <span class="d-none d-sm-inline">{{ auth()->user()->name ?? 'Guest' }}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <span class="dropdown-item dropdown-header">
          <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
        </span>
        <div class="dropdown-divider"></div>
        <span class="dropdown-item text-muted">
          <i class="fas fa-shield-alt mr-2"></i>
          @auth
            {{ auth()->user()->isAdmin() ? 'Administrator' : 'Verifikator' }}
          @else
            Guest
          @endauth
        </span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" class="dropdown-item text-danger"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>

    <!-- Fullscreen toggle -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>
