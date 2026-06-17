@extends('layouts.app')

@section('content')
<style>
    /* Gradient Page Background matching other user features */
    .leaderboard-page-container {
        background: linear-gradient(135deg, #e0ecfc 0%, #f9f6e7 100%);
        min-height: 90vh;
        border-radius: 12px;
        padding: 40px 30px;
        font-family: 'Poppins', Arial, sans-serif;
        position: relative;
    }
    
    .title {
        font-size: 2.1rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 0.5rem;
        color: #222;
    }
    
    .subtitle {
        text-align: center;
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 2.2rem;
    }
    
    /* Button back matching other pages */
    .btn-back {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        justify-content: center;
        box-shadow: 0 2px 8px 0 rgba(255, 140, 66, 0.13);
        font-size: 1.4rem;
        margin-bottom: 18px;
        transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
        text-decoration: none;
    }
    
    .btn-back:hover {
        background: linear-gradient(90deg, #ff3c3c 0%, #ff8c42 100%);
        color: #fff;
        box-shadow: 0 4px 16px 0 rgba(255, 140, 66, 0.18);
        text-decoration: none;
        transform: scale(1.05);
    }
    
    .btn-back svg {
        width: 22px;
        height: 22px;
        vertical-align: middle;
    }

    /* Table & Card Design */
    .rounded-12 {
        border-radius: 12px !important;
    }
    
    .custom-table th, .custom-table td {
        vertical-align: middle !important;
        text-align: center;
        padding: 16px;
    }

    .table-highlight {
        background-color: rgba(37, 99, 235, 0.04) !important;
        border-left: 4px solid #2563eb !important;
    }

    @media (max-width: 576px) {
        .leaderboard-page-container {
            padding: 20px 10px;
        }
        .title {
            font-size: 1.6rem;
        }
        .subtitle {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        .custom-table th, .custom-table td {
            font-size: 0.8rem;
            padding: 12px 6px !important;
        }
        .card {
            padding: 15px 10px !important;
        }
        .user-stat-card {
            flex-direction: column;
            text-align: center !important;
        }
        .user-stat-card .text-end {
            text-align: center !important;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 15px;
            margin-top: 10px;
        }
        .user-stat-card .border-end {
            border-right: none !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 10px;
            margin-bottom: 10px;
            padding-right: 0 !important;
        }
    }
</style>

<div class="leaderboard-page-container shadow-sm mt-3">
    <!-- Back Button to Dashboard -->
    <a href="{{ route('user.dashboard') }}" class="btn-back" title="Kembali ke Dashboard">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18l-6-6 6-6" />
        </svg>
    </a>

    <div class="text-center mb-4">
        <h1 class="title">🏆 LEADERBOARD PELAPOR</h1>
        <p class="subtitle">Daftar pelapor teraktif dengan kontribusi poin tertinggi</p>
    </div>

    <!-- Gamified My Rank Card Widget -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-11">
            <div class="card border-0 shadow-sm rounded-12 bg-white overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3 user-stat-card" style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); color: #ffffff;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rank-badge-container d-flex align-items-center justify-content-center bg-white text-primary rounded-circle" style="width: 60px; height: 60px; font-size: 1.8rem; box-shadow: 0 4px 10px rgba(0,0,0,0.15); flex-shrink: 0;">
                            🏆
                        </div>
                        <div class="text-start">
                            <span class="d-block opacity-75 small text-uppercase fw-bold" style="letter-spacing: 0.5px; font-size: 0.75rem;">Status Kontribusi Anda</span>
                            <h4 class="fw-bold mb-0" style="font-size: 1.35rem;">Peringkat #{{ $userRank }}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4 text-end">
                        <div class="pe-4 border-end border-white-50">
                            <span class="d-block opacity-75 small text-uppercase" style="font-size: 0.75rem;">Total Poin</span>
                            <span class="fs-4 fw-bold">{{ auth()->user()->points }} <span style="font-size: 0.9rem; font-weight: 500;">Poin</span></span>
                        </div>
                        <div>
                            <span class="d-block opacity-75 small text-uppercase" style="font-size: 0.75rem;">Gelar</span>
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold mt-1" style="font-size: 0.85rem;">
                                {{ auth()->user()->title ?? 'Pelapor Pemula' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaderboard Table Card -->
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card border-0 shadow-sm rounded-12 bg-white p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center custom-table">
                        <thead class="table-light" style="border-radius: 8px;">
                            <tr style="color: #64748b; font-size: 0.85rem; text-transform: uppercase;">
                                <th style="width: 120px;">Peringkat</th>
                                <th class="text-start">Nama Kontributor</th>
                                <th>Gelar / Title</th>
                                <th style="width: 180px;">Poin Keaktifan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaderboard as $index => $user)
                                <tr class="{{ auth()->id() == $user->id ? 'table-highlight' : '' }}" style="transition: all 0.2s;">
                                    <td class="fw-bold">
                                        @if($index == 0)
                                            🥇 <span class="d-block text-warning small fw-bold" style="font-size: 0.75rem;">Juara 1</span>
                                        @elseif($index == 1)
                                            🥈 <span class="d-block text-secondary small fw-bold" style="font-size: 0.75rem;">Juara 2</span>
                                        @elseif($index == 2)
                                            🥉 <span class="d-block text-danger small fw-bold" style="font-size: 0.75rem;">Juara 3</span>
                                        @else
                                            <span class="text-muted">#{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background={{ auth()->id() == $user->id ? '2563eb' : '64748b' }}&color=ffffff&size=36" class="rounded-circle" style="width: 36px; height: 36px;">
                                            <div>
                                                <span class="fw-semibold text-dark d-block">{{ $user->name }}</span>
                                                @if(auth()->id() == $user->id)
                                                    <span class="badge bg-primary rounded-pill" style="font-size: 0.65rem;">Anda</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-1 fw-semibold" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                                            {{ $user->title ?? 'Pelapor Pemula' }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-dark">{{ $user->points }}</strong> <span class="text-muted small">poin</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
