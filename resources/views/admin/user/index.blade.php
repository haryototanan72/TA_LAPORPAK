@extends('layouts.adminlayout')

@section('title', 'Manajemen Pengguna')

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
    
    /* Stat cards styling */
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

    /* Table custom styles */
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
    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold text-dark" style="font-size: 1.5rem;">Manajemen Pengguna</h4>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Kelola hak akses, peran pengguna, dan pantau status keaktifan warga dalam sistem.</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-12 p-3 mb-4" style="background-color: #d1e7dd; color: #0f5132;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stat Cards Row -->
    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card d-flex align-items-center justify-content-between" style="border-left: 4px solid #2563eb; background: #eff6ff; color: #2563eb;">
                <div>
                    <span class="stat-title" style="color: #2563eb;">Jumlah Pengguna</span>
                    <h3 class="stat-count">{{ $users->count() }}</h3>
                </div>
                <i class="bi bi-people-fill fs-2 opacity-50"></i>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card d-flex align-items-center justify-content-between" style="border-left: 4px solid #16a34a; background: #f0fdf4; color: #16a34a;">
                <div>
                    <span class="stat-title" style="color: #16a34a;">Pengguna Aktif</span>
                    <h3 class="stat-count">{{ $users->where('status','aktif')->count() }}</h3>
                </div>
                <i class="bi bi-person-check-fill fs-2 opacity-50"></i>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 mb-3">
            <div class="stat-card d-flex align-items-center justify-content-between" style="border-left: 4px solid #dc2626; background: #fef2f2; color: #dc2626;">
                <div>
                    <span class="stat-title" style="color: #dc2626;">Pengguna Nonaktif</span>
                    <h3 class="stat-count">{{ $users->where('status','tidak aktif')->count() }}</h3>
                </div>
                <i class="bi bi-person-x-fill fs-2 opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card custom-card">
        <div class="card-header-custom">
            <h5 class="card-title-custom">Daftar Akun Pengguna</h5>
        </div>

        <div class="table-responsive">
            <table class="table custom-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 100px; text-align: center;">ID</th>
                        <th>Nama Pengguna</th>
                        <th>Alamat Email</th>
                        <th>Peran (Role)</th>
                        <th>Status</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-center fw-bold text-secondary">
                            {{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="fw-semibold text-dark">
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=ffffff&size=32" class="rounded-circle" style="width: 32px; height: 32px;">
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @php
                                $roleLower = strtolower($user->role);
                                $roleBadge = 'bg-secondary';
                                if ($roleLower === 'admin') $roleBadge = 'bg-primary';
                                elseif ($roleLower === 'petugas') $roleBadge = 'bg-info text-white';
                            @endphp
                            <span class="badge rounded-pill px-2.5 py-1 {{ $roleBadge }}" style="font-weight: 500;">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusLower = strtolower($user->status);
                                $statusBadge = 'background: rgba(220, 38, 38, 0.08); color: #dc2626;';
                                if ($statusLower === 'aktif') $statusBadge = 'background: rgba(22, 163, 74, 0.08); color: #16a34a;';
                            @endphp
                            <span class="badge rounded-pill px-3 py-1 fw-bold" style="{{ $statusBadge }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.user.updateStatus', $user->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @if($user->status == 'aktif')
                                        <button type="submit" class="btn btn-sm btn-light border-0 fw-semibold text-danger" style="background: rgba(220, 38, 38, 0.08); transition: all 0.2s;" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan pengguna {{ $user->name }}?')">
                                            Nonaktifkan
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-light border-0 fw-semibold text-success" style="background: rgba(22, 163, 74, 0.08); transition: all 0.2s;">
                                            Aktifkan
                                        </button>
                                    @endif
                                </form>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
