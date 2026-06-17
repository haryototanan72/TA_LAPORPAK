<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LaporPak Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/css/admin-custom.css">
  <link href="{{ asset('public/assets/css/main.css') }}" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png">
  <style>
    *, *::before, *::after {
      box-sizing: border-box;
    }
    body {
      font-family: 'Poppins', 'Segoe UI', Roboto, sans-serif;
      margin: 0;
      background-color: #eef2f7;
      color: #334155;
    }
    .main-wrapper {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 240px;
      background-color: #ffffff;
      height: 100vh;
      box-shadow: 2px 0 15px rgba(0,0,0,0.05);
      border-right: 1px solid #e2e8f0;
      position: fixed;
      left: 0; top: 0;
      z-index: 100;
      display: flex;
      flex-direction: column;
      transition: all 0.3s ease;
    }
    .sidebar-profile {
      text-align: center;
      padding: 30px 15px 20px 15px;
      border-bottom: 1px solid #f1f5f9;
      margin-bottom: 15px;
    }
    .sidebar-profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #3b82f6;
      box-shadow: 0 4px 10px rgba(59, 130, 246, 0.15);
    }
    .sidebar-profile h6 {
      font-size: 0.9rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 2px;
    }
    .sidebar-profile p {
      font-size: 0.75rem;
      color: #64748b;
      font-weight: 500;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .sidebar ul li {
      margin-bottom: 5px;
      padding: 0 12px;
    }
    .sidebar ul li a {
      display: flex;
      align-items: center;
      color: #475569;
      text-decoration: none;
      padding: 12px 16px;
      border-radius: 8px;
      font-size: 0.95rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }
    .sidebar ul li a.active, .sidebar ul li a:hover {
      background: rgba(59, 130, 246, 0.08);
      color: #2563eb;
    }
    .sidebar ul li a.active {
      background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
      color: #ffffff !important;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    .sidebar ul li a i {
      margin-right: 12px;
      font-size: 1.25rem;
      transition: color 0.2s;
    }
    .sidebar ul li a.active i {
      color: #ffffff !important;
    }
    .sidebar ul li a:hover i {
      color: #2563eb;
    }
    .header {
      padding: 0 40px 0 280px;
      background: linear-gradient(135deg, rgba(255,255,255,0.08) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.08) 75%, transparent 75%, transparent), linear-gradient(135deg, #0076f6 0%, #00c6ff 100%);
      background-size: 40px 40px, 100% 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 90;
      position: sticky;
      top: 0;
      left: 0;
      right: 0;
      height: 90px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .header .logo-title {
      font-size: 1.15rem;
      letter-spacing: 0.5px;
    }
    .header .profile {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .header .profile .avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255, 255, 255, 0.6);
    }
    .header .profile .name {
      font-weight: 600;
      color: #ffffff;
      font-size: 0.95rem;
    }
    .header .profile .role {
      font-size: 0.8rem;
      color: #2563eb;
      background: #ffffff;
      padding: 2px 8px;
      border-radius: 12px;
      font-weight: 600;
    }
    .content {
      margin-left: 240px;
      padding: 40px;
      background-color: #eef2f7;
      min-height: calc(100vh - 90px);
    }
    
    .dropdown-menu {
      border: 1px solid #e2e8f0;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
      border-radius: 8px;
      padding: 6px;
    }
    .dropdown-item {
      border-radius: 6px;
      padding: 8px 12px;
      font-size: 0.9rem;
      color: #64748b;
    }
    .dropdown-item:hover, .dropdown-item.active {
      background: rgba(37, 99, 235, 0.08);
      color: #2563eb;
    }

    @media (max-width: 991px) {
      .sidebar { width: 70px; }
      .sidebar-profile { padding: 20px 5px; }
      .sidebar-profile img { width: 44px; height: 44px; }
      .sidebar-profile h6, .sidebar-profile p, .sidebar-profile .menu-label { display: none; }
      .sidebar ul li { padding: 0 6px; }
      .sidebar ul li a { padding: 12px 10px; justify-content: center; }
      .sidebar ul li a span { display: none; }
      .sidebar ul li a i { margin-right: 0; }
      .header { padding-left: 90px; }
      .content { margin-left: 70px; }
    }

    /* Reset global Bootstrap .card override from main.css for Admin Portal */
    .card, .custom-card {
      background-color: #ffffff !important;
      color: #334155 !important;
      border: 1px solid #e2e8f0 !important;
      box-shadow: 0 4px 15px rgba(0,0,0,0.02) !important;
      transform: none !important;
      transition: none !important;
    }
    .card:hover, .custom-card:hover {
      transform: none !important;
      box-shadow: 0 4px 15px rgba(0,0,0,0.02) !important;
    }
    .card-body {
      background-color: #ffffff !important;
      color: #334155 !important;
    }
    .card-title-custom, .card-title {
      color: #1e293b !important;
    }
    .card-subtitle-custom, .card-subtitle {
      color: #64748b !important;
    }
    .table th, .table td {
      color: #334155 !important;
    }
    .text-dark {
      color: #1e293b !important;
    }
  </style>
  @yield('head')
</head>
<body>
  <div class="main-wrapper">
    <div class="sidebar">
      <!-- Profile Widget matching screenshot -->
      <div class="sidebar-profile">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=ffffff" alt="avatar">
        <h6 class="mt-2">{{ Auth::user()->name }}</h6>
        <p class="mb-0 text-muted">102022480007</p>
      </div>

      <div class="px-4 py-2 text-uppercase fw-bold text-primary menu-label" style="font-size: 0.75rem; letter-spacing: 0.5px; opacity: 0.8; margin-bottom: 5px;">Menu</div>

      <ul>
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
        <li><a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}"><i class="bi bi-chat-left-text"></i> <span>Laporan</span></a></li>
        <li><a href="{{ route('admin.gamification.index') }}" class="{{ request()->routeIs('admin.gamification.index') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> <span>Gamifikasi</span></a></li>
        <li><a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.index') ? 'active' : '' }}"><i class="bi bi-people"></i> <span>Pengguna</span></a></li>
        {{-- <li class="dropdown">
          <a href="#" class="dropdown-toggle d-flex align-items-center {{ request()->routeIs('admin.petugas.*') || request()->routeIs('admin.petugas.laporan-tugas.*') ? 'active' : '' }}" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-badge"></i> <span>Petugas</span>
          </a>
          <ul class="dropdown-menu w-100">
            <li>
              <a class="dropdown-item {{ request()->routeIs('admin.petugas.index') ? 'active' : '' }}" href="{{ route('admin.petugas.index') }}">
                <i class="bi bi-person-lines-fill"></i> Data Petugas
              </a>
            </li>
            <li>
              <a class="dropdown-item {{ request()->routeIs('admin.petugas.laporan-tugas.*') ? 'active' : '' }}" href="{{ route('admin.petugas.laporan-tugas.index') }}">
                <i class="bi bi-clipboard-check"></i> Verifikasi Lapangan
              </a>
            </li>
          </ul>
        </li> --}}
        <li><a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}"><i class="bi bi-newspaper"></i> <span>Berita</span></a></li>
        <li>
            <a href="{{ route('admin.faq.index') }}" class="{{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i> <span>FAQ</span>
            </a>
        </li>
        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-power"></i> <span>Logout</span></a></li>
      </ul>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>
    <div style="flex:1;display:flex;flex-direction:column;min-height:100vh;">
      <div class="header">
        <div class="logo-title fw-bold text-white d-flex align-items-center gap-2">
            <img src="{{ asset('assets/img/logo-admin.png') }}" alt="Logo LaporPak Admin" style="max-height: 32px; width: auto;">
            <span>LAPORPAK ADMIN </span>
        </div>
        <div class="profile text-white d-flex align-items-center gap-3">
          <span class="fw-semibold opacity-75 d-none d-md-inline" style="font-size: 0.85rem;">2025/2026-2</span>
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-white text-decoration-none dropdown-toggle" id="adminProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
              <i class="bi bi-person-circle fs-5"></i>
              <span class="name text-white">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="adminProfileDropdown" style="background-color: #ffffff; min-width: 180px;">
              <li class="px-3 py-2 border-bottom">
                <span class="d-block fw-bold text-dark" style="font-size: 0.85rem; text-transform: none;">{{ Auth::user()->name }}</span>
                <span class="d-block text-muted" style="font-size: 0.75rem; text-transform: none;">{{ Auth::user()->email }}</span>
              </li>
              <li>
                <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-weight: 500;">
                  <i class="bi bi-box-arrow-right"></i> Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="content">
        @yield('content')
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
@stack('scripts')
</body>
</html>
</html>
