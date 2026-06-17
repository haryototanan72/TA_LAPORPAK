<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center me-auto text-decoration-none">
      <img src="{{ asset('assets/img/logo.png') }}" alt="Logo LaporPak" class="me-2" style="max-height: 40px; width: auto; object-fit: contain;">
      <h1 class="sitename">LaporPak!</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard', 'dashboard') ? 'active' : '' }}">Dashboard</a></li>
        <li><a href="{{ request()->is('/') ? '#statistik' : route('dashboard').'#statistik' }}">Statistik</a></li>
        
        <!-- Layanan Dropdown -->
        <li class="dropdown">
          <a href="javascript:void(0)">
            <span>Layanan</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
          </a>
          <ul>
            <li><a href="{{ route('petakondisi.index') }}"><i class="bi bi-map me-2"></i> Peta Kondisi Jalan</a></li>
            <li><a href="{{ route('track.show') }}"><i class="bi bi-search me-2"></i> Lacak Laporan</a></li>
            <li><a href="{{ route('leaderboard.index') }}"><i class="bi bi-graph-up me-2"></i> Leaderboard Pelapor</a></li>
            <li><a href="{{ route('laporan.index') }}"><i class="bi bi-clipboard-data me-2"></i> Aktivitas Laporan</a></li>
          </ul>
        </li>

        <li><a href="{{ route('news.index') }}" class="{{ request()->routeIs('news.*') ? 'active' : '' }}">Berita</a></li>
        <li><a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a></li>
        
        <!-- Notifikasi -->
        <li>
          @if(request()->routeIs('user.dashboard', 'dashboard'))
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#notificationModal" class="position-relative d-flex align-items-center">
              <i class="bi bi-bell-fill" style="font-size: 1.2rem;"></i>
              <span class="d-xl-none ms-2">Notifikasi</span>
              @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                <span class="position-absolute translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 2px 4px; top: 12px; left: 24px;">
                  {{ $unreadNotificationsCount }}
                </span>
              @endif
            </a>
          @else
            <a href="{{ route('notifikasi.index') }}" class="position-relative d-flex align-items-center {{ request()->routeIs('notifikasi.*') ? 'active' : '' }}">
              <i class="bi bi-bell-fill" style="font-size: 1.2rem;"></i>
              <span class="d-xl-none ms-2">Notifikasi</span>
              @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                <span class="position-absolute translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 2px 4px; top: 12px; left: 24px;">
                  {{ $unreadNotificationsCount }}
                </span>
              @endif
            </a>
          @endif
        </li>

        <!-- LAPOR! CTA Button -->
        <li>
          <a href="{{ route('laporan.form_laporan') }}" class="btn-lapor-nav ms-xl-3">LAPOR!</a>
        </li>
        
        @auth
          <!-- Desktop Profile Dropdown -->
          <li class="dropdown d-none d-xl-block">
            <a href="javascript:void(0)">
                @if(auth()->user()->profile_picture)
                  <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                       class="rounded-circle" 
                       style="width: 25px; height: 25px; object-fit: cover; margin-right: 5px;">
                @else
                  <i class="bi bi-person-circle"></i>
                @endif
                <span>{{ auth()->user()->name }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
            </a>
            <ul>
              <li><a href="{{ route('profile.index') }}">Profile</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                  @csrf
                  <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();" class="logout-link text-danger">Logout</a>
                </form>
              </li>
            </ul>
          </li>

          <!-- Mobile Profile Links -->
          <li class="d-xl-none border-top-mobile">
            <a href="{{ route('profile.index') }}" class="mobile-user-link">
              <div class="user-icon-bg"><i class="bi bi-person"></i></div>
              <span>Profile</span>
            </a>
          </li>
          <li class="d-xl-none">
            <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
              @csrf
              <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="mobile-user-link logout-danger">
                <div class="user-icon-bg bg-danger-light"><i class="bi bi-box-arrow-right"></i></div>
                <span>Logout</span>
              </a>
            </form>
          </li>
        @else
          <!-- If not logged in, show Login link -->
          <li>
            <a href="{{ route('login') }}" class="btn-login-nav ms-xl-2">Login</a>
          </li>
        @endauth
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

  </div>
</header>

<style>
  /* --- REVISI: WARNA NAVY & EFEK SCROLL --- */
  .header {
      height: 70px;
      background: #232b44; 
      transition: all 0.4s ease;
      z-index: 997;
      border-bottom: 2px solid #ffb300; 
  }

  .sitename {
      font-size: 24px;
      font-weight: 700;
      color: #ffffff;
      margin: 0;
  }

  .header.header-scrolled {
      height: 60px;
      background: rgba(35, 43, 68, 0.9); 
      backdrop-filter: blur(10px);
  }

  body {
      padding-top: 70px !important;
  }

  .navmenu a {
      color: rgba(255, 255, 255, 0.85);
      font-size: 15px;
      font-weight: 500;
      padding: 10px 15px;
      text-decoration: none;
  }

  .navmenu a:hover, .navmenu .active {
      color: #ffb300 !important; 
  }

  /* LAPOR! CTA Button inside Nav */
  .btn-lapor-nav {
      background: linear-gradient(135deg, #ff8c42 0%, #ff3c3c 100%);
      color: #fff !important;
      font-weight: 700;
      border: none;
      border-radius: 50px;
      padding: 8px 20px !important;
      margin-left: 15px;
      box-shadow: 0 4px 12px rgba(255, 60, 60, 0.25);
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
  }
  .btn-lapor-nav:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(255, 60, 60, 0.4);
      background: linear-gradient(135deg, #ff9e5e 0%, #ff5252 100%);
  }

  /* Login button in nav */
  .btn-login-nav {
      border: 1px solid rgba(255, 255, 255, 0.4);
      border-radius: 50px;
      padding: 8px 20px !important;
      color: #fff !important;
      font-weight: 500;
      transition: all 0.3s;
  }
  .btn-login-nav:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: #ffb300;
      color: #ffb300 !important;
  }

  /* Desktop Logout */
  .logout-link {
      color: #dc3545 !important; /* Merah tegas */
      font-weight: 600 !important;
  }

  .logout-link:hover {
      background-color: #fff5f5 !important;
      color: #a71d2a !important;
  }

  /* --- MOBILE MENU POP-UP (FIT CONTENT & NO COLLISION) --- */
  @media (max-width: 1199px) {
      .mobile-nav-toggle {
          color: #ffffff;
          font-size: 28px;
          cursor: pointer;
      }

      .mobile-nav-active .navmenu {
          position: fixed;
          inset: 0;
          background: rgba(0, 0, 0, 0.6);
          z-index: 9997;
      }

      /* Only target the direct child ul of .navmenu to avoid styling nested uls */
      .mobile-nav-active .navmenu > ul {
          display: block;
          position: absolute;
          top: 80px; 
          right: 20px;
          left: 20px;
          bottom: auto; 
          background: #ffffff;
          padding: 10px 0;
          border-radius: 15px;
          box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
          max-height: calc(100vh - 120px);
          overflow-y: auto;
      }

      /* Style for mobile nav menu links */
      .mobile-nav-active .navmenu ul a {
          color: #232b44 !important;
          padding: 12px 20px;
          border-bottom: 1px solid #eee;
          display: flex;
          align-items: center;
      }

      .mobile-nav-active .navmenu ul li:last-child a {
          border-bottom: none;
      }

      /* LAPOR! Nav Button on Mobile */
      .mobile-nav-active .navmenu ul .btn-lapor-nav {
          margin: 10px 20px !important;
          padding: 12px 20px !important;
          border-radius: 10px;
          display: flex !important;
          justify-content: center;
          background: linear-gradient(135deg, #ff8c42 0%, #ff3c3c 100%) !important;
          color: #ffffff !important;
      }

      /* Dropdown submenu container on Mobile */
      .mobile-nav-active .navmenu .dropdown ul {
          position: static;
          display: none;
          margin: 5px 15px 10px 15px;
          padding: 0;
          background: #f8f9fa;
          border-radius: 10px;
          border: 1px solid #eee;
          box-shadow: none;
          max-height: none;
          overflow-y: visible;
      }

      /* Display active dropdown on Mobile */
      .mobile-nav-active .navmenu .dropdown ul.dropdown-active {
          display: block;
      }

      /* Submenu links style on Mobile */
      .mobile-nav-active .navmenu .dropdown ul a {
          color: #495057 !important;
          padding: 10px 20px;
          font-size: 15px;
          font-weight: 500;
          border-bottom: 1px solid #f1f3f5;
          background: transparent !important;
      }

      .mobile-nav-active .navmenu .dropdown ul li:last-child a {
          border-bottom: none;
      }

      /* User Profile Mobile links styling */
      .user-icon-bg {
          width: 35px;
          height: 35px;
          background-color: #f0f4ff; /* Biru sangat muda */
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          margin-right: 12px;
          color: #232b44;
          font-size: 1.1rem;
      }

      .bg-danger-light {
          background-color: #fff0f0 !important; /* Merah sangat muda */
          color: #dc3545 !important;
      }

      .mobile-user-link {
          display: flex !important;
          align-items: center !important;
          padding: 12px 20px !important;
          text-decoration: none;
      }

      .mobile-user-link span {
          font-size: 16px;
          font-weight: 500;
          color: #232b44;
      }

      .logout-danger span {
          color: #dc3545 !important;
          font-weight: 700;
      }

      .border-top-mobile {
          border-top: 1px solid #eee;
          margin-top: 8px;
      }
  }
</style>

<script>
  /* class header-scrolled saat layar digeser */
  document.addEventListener('scroll', function() {
      const header = document.querySelector('#header');
      if (window.scrollY > 50) {
          header.classList.add('header-scrolled');
      } else {
          header.classList.remove('header-scrolled');
      }
  });

  // Handlers for mobile menu dropdown toggles (makes clicking the text also open the menu on mobile)
  document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.navmenu .dropdown > a');
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        if (window.innerWidth < 1200) {
          e.preventDefault();
          e.stopPropagation();
          
          // Toggle active class on link
          this.classList.toggle('active');
          
          // Toggle dropdown-active class on submenu
          const submenu = this.nextElementSibling;
          if (submenu) {
            submenu.classList.toggle('dropdown-active');
          }
        }
      });
    });
  });
</script>