<!-- Header Section -->
<header class="bg-white shadow-sm border-bottom mb-4">
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('landing') }}" class="text-decoration-none">
                    <h4 class="mb-0 fw-bold" style="color: #fbb03b; font-size: 1.5rem;">LaporPak!</h4>
                </a>
            </div>
            <div class="d-flex align-items-center gap-4">
            </a>
            <a href="{{ route('user.dashboard') }}" class="text-decoration-none text-dark fw-semibold {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Beranda</a>
            <a href="#" class="text-decoration-none text-dark fw-semibold">Statistik</a>
            <a href="#" class="text-decoration-none text-dark fw-semibold">Kategori</a>
            <a href="{{ route('faq') }}" class="text-decoration-none text-dark fw-semibold">FAQ</a>
            <a href="{{ route('notifikasi.index') }}" class="text-decoration-none text-dark fw-semibold {{ request()->routeIs('notifikasi.index') ? 'active' : '' }}">
                <i class="bi bi-bell"></i> Notifikasi
            </a>
                
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center gap-2" 
                            type="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false"
                            style="color: #4b5563;">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                 alt="Profile" 
                                 class="rounded-circle"
                                 style="width: 32px; height: 32px; object-fit: cover;">
                        @else
                            <i class="fas fa-user-circle fa-lg" style="color: #6c757d;"
                                 alt="Profile" 
                                 class="rounded-circle"
                                 style="width: 32px; height: 32px; object-fit: cover;"> </i>
                        @endif
                        <span class="fw-semibold">{{ auth()->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" 
                               href="{{ route('laporan.form_laporan') }}">
                                <i class="bi bi-person"></i>
                                laporan
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
.header {
    background: white;
    border-bottom: 1px solid #e5e7eb;
}

.header a {
    color: #4b5563;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 1rem;
}

.header a:hover {
    color: #fbb03b;
}

.header a.active {
    color: #fbb03b;
    font-weight: 600;
}

/* Dropdown styles */
.dropdown-toggle {
    border: none;
    background: none;
    padding: 0;
}

.dropdown-toggle:focus {
    box-shadow: none;
}

.dropdown-toggle::after {
    margin-left: 0.5rem;
    vertical-align: middle;
}

.dropdown-menu {
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border-radius: 8px;
    margin-top: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.text-danger:hover {
    background-color: #fee2e2;
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-color: #e5e7eb;
}
</style>
