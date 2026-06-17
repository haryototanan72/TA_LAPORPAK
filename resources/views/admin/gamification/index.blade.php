@extends('layouts.adminlayout')

@section('title', 'Dashboard Gamifikasi')

@section('content')
<style>
    .custom-card {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02) !important;
    }
    .card-header-custom {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 24px;
    }
    .card-title-custom {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
    }
    
    /* Stat cards */
    .stat-card {
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .stat-title {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }
    .stat-count {
        font-size: 1.8rem;
        font-weight: 700;
        margin-top: 8px;
        margin-bottom: 0;
    }
    
    /* Table styling */
    .custom-table th {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 600;
        background: #f8fafc;
        padding: 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .custom-table td {
        padding: 16px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }
</style>

<div class="container-fluid px-0 py-2">
    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-bold text-dark" style="font-size: 1.5rem;">Gamifikasi & Leaderboard</h4>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Dashboard pemantauan partisipasi pengguna berbasis poin dan status kontribusi warga.</p>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-12 p-3 mb-4" style="background-color: #d1e7dd; color: #0f5132;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistik Gamifikasi --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card d-flex align-items-center justify-content-between" style="border-left: 4px solid #2563eb; background: #eff6ff; color: #2563eb;">
                <div>
                    <span class="stat-title" style="color: #2563eb;">Total Pengguna</span>
                    <h3 class="stat-count">{{ $totalUsers }}</h3>
                </div>
                <i class="bi bi-people-fill fs-2 opacity-50"></i>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card d-flex align-items-center justify-content-between" style="border-left: 4px solid #0891b2; background: #ecfeff; color: #0891b2;">
                <div>
                    <span class="stat-title" style="color: #0891b2;">Total Laporan</span>
                    <h3 class="stat-count">{{ $totalReports }}</h3>
                </div>
                <i class="bi bi-chat-left-text-fill fs-2 opacity-50"></i>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card d-flex align-items-center justify-content-between" style="border-left: 4px solid #d97706; background: #fffbeb; color: #d97706;">
                <div>
                    <span class="stat-title" style="color: #d97706;">Total Poin</span>
                    <h3 class="stat-count">{{ $totalPoints }}</h3>
                </div>
                <i class="bi bi-award-fill fs-2 opacity-50"></i>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card d-flex align-items-center justify-content-between" style="border-left: 4px solid #16a34a; background: #f0fdf4; color: #16a34a;">
                <div>
                    <span class="stat-title" style="color: #16a34a;">Top Contributor</span>
                    <div>
                        <h5 class="fw-bold text-dark mt-2 mb-0" style="font-size: 0.95rem;">{{ $topUser->name ?? '-' }}</h5>
                        <span class="small text-muted" style="font-size: 0.75rem;">
                            {{ $topUser->points ?? 0 }} Poin · {{ $topUser->title ?? '-' }}
                        </span>
                    </div>
                </div>
                <i class="bi bi-trophy-fill fs-2 opacity-50"></i>
            </div>
        </div>
    </div>

    {{-- Leaderboard --}}
    <div class="card custom-card">
        <div class="card-header-custom">
            <h5 class="card-title-custom">🏆 Leaderboard Top 10 Kontributor</h5>
        </div>

        <div class="table-responsive">
            <table class="table custom-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 120px; text-align: center;">Peringkat</th>
                        <th>Nama Kontributor</th>
                        <th>Gelar / Title</th>
                        <th style="width: 180px; text-align: center;">Poin Keaktifan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaderboard as $index => $user)
                        <tr>
                            <td class="text-center fw-semibold text-secondary">
                                @if($index == 0)
                                    🥇 <span class="ms-1 fw-bold text-warning" style="font-size: 0.95rem;">Juara 1</span>
                                @elseif($index == 1)
                                    🥈 <span class="ms-1 fw-bold text-secondary" style="font-size: 0.95rem;">Juara 2</span>
                                @elseif($index == 2)
                                    🥉 <span class="ms-1 fw-bold text-danger" style="font-size: 0.95rem;">Juara 3</span>
                                @else
                                    #{{ $index + 1 }}
                                @endif
                            </td>
                            <td class="fw-semibold text-dark">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=ffffff&size=32" class="rounded-circle" style="width: 32px; height: 32px;">
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-1 font-weight-600" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                                    {{ $user->title }}
                                </span>
                            </td>
                            <td class="text-center">
                                <strong class="text-dark">{{ $user->points }}</strong> <span class="text-muted small">poin</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada data leaderboard.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
