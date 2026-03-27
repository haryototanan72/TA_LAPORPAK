<!-- HEADER PWA STYLE -->
<header class="top-navbar">
    <!-- LOGO -->
    <div class="navbar-left">
        <a href="{{ route('landing') }}" class="brand">
            LaporPak!
        </a>
    </div>

    <!-- MENU -->
    <div class="navbar-right">
        <button class="menu-btn" onclick="toggleMenu()">⋮</button>

        <div id="dropdownMenu" class="dropdown-menu">
            <a href="{{ route('user.dashboard') }}">🏠 Beranda</a>
            <a href="{{ route('laporan.form_laporan') }}">📄 Buat Laporan</a>
            <a href="{{ route('laporan.index') }}">📋 Laporan Saya</a>
            <a href="{{ route('leaderboard.index') }}">🏆 Leaderboard</a>
            <a href="{{ route('faq') }}">❓ FAQ</a>
            <a href="{{ route('notifikasi.index') }}">🔔 Notifikasi</a>
            <a href="{{ route('profile.index') }}">👤 Profile</a>

            <hr>

            <!-- USER INFO (opsional tapi bagus UX) -->
            <div class="user-info px-3 py-2">
                <small class="text-muted">Login sebagai</small><br>
                <strong>{{ auth()->user()->name }}</strong>
            </div>

            <hr>

            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">🚪 Logout</button>
            </form>
        </div>
    </div>
</header>

<!-- STYLE -->
<style>
/* NAVBAR */
.top-navbar {
    position: sticky;
    top: 0;
    z-index: 999;
    background: #1c1c1e;
    color: white;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* LOGO */
.brand {
    font-weight: bold;
    font-size: 18px;
    color: #fbb03b;
    text-decoration: none;
}

/* BUTTON */
.menu-btn {
    background: none;
    border: none;
    font-size: 22px;
    color: white;
    cursor: pointer;
}

/* DROPDOWN */
.dropdown-menu {
    display: none;
    position: absolute;
    right: 16px;
    top: 55px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.25);
    overflow: hidden;
    min-width: 220px;
    animation: fadeIn 0.2s ease;
    z-index: 1000;
}

/* ITEM */
.dropdown-menu a,
.dropdown-menu button {
    display: block;
    width: 100%;
    padding: 12px 14px;
    text-align: left;
    background: none;
    border: none;
    font-size: 14px;
    color: #333;
    text-decoration: none;
    cursor: pointer;
}

/* HOVER */
.dropdown-menu a:hover,
.dropdown-menu button:hover {
    background: #f5f5f5;
}

/* USER INFO */
.user-info {
    font-size: 13px;
    color: #555;
}

/* DIVIDER */
.dropdown-menu hr {
    margin: 5px 0;
    border: 0;
    border-top: 1px solid #eee;
}

/* ANIMASI */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* MOBILE FIX */
@media (max-width: 768px) {
    .top-navbar {
        padding: 10px 12px;
    }

    .brand {
        font-size: 16px;
    }

    .dropdown-menu {
        right: 10px;
        top: 50px;
        min-width: 200px;
    }
}
</style>

<!-- SCRIPT -->
<script>
function toggleMenu() {
    const menu = document.getElementById('dropdownMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// AUTO CLOSE
document.addEventListener('click', function(e) {
    const menu = document.getElementById('dropdownMenu');
    if (!e.target.closest('.navbar-right')) {
        menu.style.display = 'none';
    }
});
</script>