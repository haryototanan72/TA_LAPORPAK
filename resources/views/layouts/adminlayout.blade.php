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
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f9f9f9;
    }
    .main-wrapper {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 220px;
      background-color: #ffffff;
      height: 100vh;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
      padding: 20px 0 0 0;
      position: fixed;
      left: 0; top: 0;
      z-index: 100;
      display: flex;
      flex-direction: column;
    }
    .sidebar h2 {
      color: #2d7ff9;
      font-weight: bold;
      margin-bottom: 36px;
      margin-left: 24px;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .sidebar ul li {
      margin-bottom: 10px;
    }
    .sidebar ul li a {
      display: flex;
      align-items: center;
      color: #444;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 8px 0 0 8px;
      font-size: 1rem;
      transition: background 0.2s, color 0.2s;
    }
    .sidebar ul li a.active, .sidebar ul li a:hover {
      background: #fbb03b;
      color: #fff;
    }
    .sidebar ul li a i {
      margin-right: 10px;
      font-size: 1.2rem;
    }
    .header {
      padding: 18px 36px 18px 240px;
      background: #fff;
      border-bottom: 1px solid #eee;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 90;
      position: sticky;
      top: 0;
      left: 0;
      right: 0;
      min-height: 70px;
    }
    .header .search-bar {
      flex: 1;
      margin-left: 36px;
      margin-right: 36px;
      max-width: 400px;
    }
    .header .search-bar input {
      width: 100%;
      border: 1px solid #eee;
      border-radius: 20px;
      padding: 8px 18px;
      font-size: 1rem;
      background: #fafbfc;
    }
    .header .profile {
      display: flex;
      align-items: center;
      gap: 18px;
    }
    .header .profile .avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fbb03b;
    }
    .header .profile .name {
      font-weight: 600;
      color: #222;
    }
    .header .profile .role {
      font-size: 0.95em;
      color: #888;
    }
    .header .profile .dropdown {
      margin-left: 10px;
    }
    .content {
      margin-left: 220px;
      padding: 40px 30px 30px 30px;
    }
    @media (max-width: 991px) {
      .sidebar { width: 70px; padding-left: 0; }
      .sidebar h2 { display: none; }
      .sidebar ul li a { padding: 12px 10px; justify-content: center; }
      .sidebar ul li a span { display: none; }
      .header { padding-left: 90px; }
      .content { margin-left: 70px; }
    }
  </style>
  @yield('head')
</head>
<body>
  <div class="main-wrapper">
    <div class="sidebar">
      <h2>LaporPak</h2>
      <ul>
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
        <li><a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}"><i class="bi bi-chat-left-text"></i> <span>Laporan</span></a></li>
        <li><a href="{{ route('admin.gamification.index') }}" class="{{ request()->routeIs('admin.gamification.index') ? 'active' : '' }}"><i class="bi bi-graph-up text-purple"></i> <span>Gamifikasi</span></a></li>
        <li><a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.index') ? 'active' : '' }}"><i class="bi bi-people"></i> <span>Pengguna</span></a></li>
        <li class="dropdown">
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
</li>
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
        <div class="search-bar">
          {{-- <input type="text" class="form-control" placeholder="Search" style="width:100%;"> --}}
        </div>
        <div class="profile">
          <i class="bi bi-bell" style="font-size:1.3rem;margin-right:18px;position:relative;"><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.7em;">6</span></i>
          <span class="dropdown">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" class="avatar" alt="avatar">
            <span class="name">{{ Auth::user()->name }}</span>
            <span class="role">Admin</span>
          </span>
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
