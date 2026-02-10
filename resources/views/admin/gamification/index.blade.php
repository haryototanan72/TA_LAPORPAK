@extends('layouts.adminlayout')

@section('title', 'Dashboard Gamifikasi')

@section('content')
<div class="container-fluid p-0">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="h3">Gamifikasi & Leaderboard</h1>
        <p class="text-muted">
            Dashboard pemantauan partisipasi pengguna berbasis poin dan gamifikasi
        </p>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistik Gamifikasi --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total User</h6>
                <h3 class="mb-0">{{ $totalUsers }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Laporan</h6>
                <h3 class="mb-0">{{ $totalReports }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Poin</h6>
                <h3 class="mb-0">{{ $totalPoints }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Top Contributor</h6>
                <strong>{{ $topUser->name ?? '-' }}</strong><br>
                <small class="text-muted">
                    {{ $topUser->points ?? 0 }} poin · {{ $topUser->title ?? '-' }}
                </small>
            </div>
        </div>
    </div>

    {{-- Leaderboard --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">🏆 Leaderboard Top 10</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Peringkat</th>
                        <th>Nama</th>
                        <th>Title</th>
                        <th>Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaderboard as $index => $user)
                        <tr>
                            <td>
                                @if($index == 0)
                                    🥇
                                @elseif($index == 1)
                                    🥈
                                @elseif($index == 2)
                                    🥉
                                @else
                                    #{{ $index + 1 }}
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $user->title }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $user->points }}</strong> poin
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada data leaderboard
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
