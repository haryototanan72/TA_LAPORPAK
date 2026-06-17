@extends('layouts.adminlayout')

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
    .filter-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        padding: 8px 12px;
        outline: none;
        background-color: #ffffff;
        color: #475569;
        transition: border-color 0.2s;
    }
    .filter-select:focus {
        border-color: #2563eb;
    }
    .btn-apply {
        background: #2563eb;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 16px;
        border: none;
        transition: all 0.2s;
    }
    .btn-apply:hover {
        background: #1d4ed8;
        color: #fff;
    }
    
    /* Tambahan Styling untuk Tombol Export */
    .btn-export {
        background: #10b981; /* Warna hijau khas Excel */
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 16px;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-export:hover {
        background: #059669;
        color: #fff;
    }

    .btn-reset {
        border: 1px solid #dc2626;
        color: #dc2626;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 16px;
        background: transparent;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-reset:hover {
        background: #fef2f2;
        color: #b91c1c;
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
    
    /* Button styles */
    .btn-detail {
        background: rgba(37, 99, 235, 0.08);
        color: #2563eb;
        border-radius: 6px;
        font-weight: 600;
        padding: 6px 12px;
        font-size: 0.85rem;
        text-decoration: none;
        border: none;
        transition: all 0.2s;
        display: inline-block;
    }
    .btn-detail:hover {
        background: #2563eb;
        color: #fff;
    }
    .btn-delete {
        background: rgba(220, 38, 38, 0.08);
        color: #dc2626;
        border-radius: 6px;
        font-weight: 600;
        padding: 6px 12px;
        font-size: 0.85rem;
        border: none;
        transition: all 0.2s;
        margin-left: 4px;
        display: inline-block;
    }
    .btn-delete:hover {
        background: #dc2626;
        color: #fff;
    }
</style>

<div class="container-fluid px-0 py-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">Daftar Laporan Masuk</h5>
                </div>
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="d-flex flex-wrap align-items-center mb-4 gap-2">
                        <span class="fw-semibold text-secondary me-2" style="font-size: 0.9rem;">Filter Laporan:</span>
                        
                        <input type="month" name="bulan" class="filter-select" value="{{ request('bulan') }}">

                        <select name="tanggal" class="filter-select">
                            <option value="">Urutkan Tanggal</option>
                            <option value="terbaru" {{ request('tanggal') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('tanggal') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        </select>
                        
                        <select name="status" class="filter-select">
                            <option value="">Status Laporan</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="ditindaklanjuti" {{ request('status') == 'ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        
                        <button type="submit" class="btn-apply">Terapkan</button>
                        
                        <button type="submit" name="export" value="excel" class="btn-export">
                            <i class="bi bi-file-earmark-excel"></i> Unduh Rekapan Excel
                        </button>
                        
                        <a href="{{ route('admin.laporan.index') }}" class="btn-reset ms-md-auto">
                            <i class="bi bi-arrow-clockwise"></i> Reset Filter
                        </a>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle custom-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">No.</th>
                                    <th>Nomor Laporan</th>
                                    <th>Pelapor</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporans as $index => $laporan)
                                <tr>
                                    <td class="fw-semibold text-secondary">{{ $laporans->firstItem() + $index }}</td>
                                    <td class="fw-semibold text-dark">{{ $laporan->nomor_laporan }}</td>
                                    <td>{{ $laporan->user && $laporan->user->role === 'user' ? $laporan->user->name : 'Pelapor Anonim' }}</td>
                                    <td>{{ $laporan->created_at->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $badgeStyle = 'background: #f1f5f9; color: #475569;'; // default
                                            $statusLower = strtolower($laporan->status);
                                            // Penyesuaian 5 Status Badge
                                            if ($statusLower === 'diajukan') $badgeStyle = 'background: #f1f5f9; color: #475569;';
                                            elseif ($statusLower === 'diverifikasi') $badgeStyle = 'background: #ecfeff; color: #0891b2;';
                                            elseif ($statusLower === 'ditindaklanjuti') $badgeStyle = 'background: #fffbeb; color: #d97706;';
                                            elseif ($statusLower === 'selesai') $badgeStyle = 'background: #f0fdf4; color: #16a34a;';
                                            elseif ($statusLower === 'ditolak') $badgeStyle = 'background: #fef2f2; color: #dc2626;';
                                        @endphp
                                        <span class="badge rounded-pill px-2 py-1 font-weight-500" style="{{ $badgeStyle }}">
                                            {{ ucfirst($laporan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.laporan.detail', $laporan->nomor_laporan) }}" class="btn-detail">
                                            Detail
                                        </a>
                                        @if(in_array($laporan->status, ['ditolak', 'selesai']))
                                            <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $laporans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection