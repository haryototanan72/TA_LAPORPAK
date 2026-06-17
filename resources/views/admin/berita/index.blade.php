@extends('layouts.adminlayout')

@section('title', 'Daftar Berita')

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
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-title-custom {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
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
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="fw-bold text-dark" style="font-size: 1.5rem;">Kelola Berita</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Kelola artikel, berita, dan pengumuman publik terkait infrastruktur jalan Kota Bandung.</p>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="btn text-white fw-bold d-inline-flex align-items-center gap-2 border-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 10px; padding: 10px 24px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);">
            <i class="bi bi-plus-lg"></i> <span>Tambah Berita</span>
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-12 p-3 mb-4" style="background-color: #d1e7dd; color: #0f5132;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Table Card -->
    <div class="card custom-card">
        <div class="card-header-custom">
            <h5 class="card-title-custom">Daftar Berita</h5>
        </div>

        <div class="table-responsive">
            <table class="table custom-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 80px; text-align: center;">No</th>
                        <th style="width: 100px; text-align: center;">Gambar</th>
                        <th>Judul Berita</th>
                        <th>Kategori</th>
                        <th>Ringkasan Isi</th>
                        <th>Tanggal Terbit</th>
                        <th>Status</th>
                        <th style="width: 180px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $berita)
                    <tr>
                        <td class="text-center fw-bold text-secondary">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if($berita->gambar)
                                <img src="{{ Storage::url($berita->gambar) }}" alt="Gambar" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #e2e8f0;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px; border: 1px solid #e2e8f0;">
                                    <i class="bi bi-image" style="font-size: 1.2rem;"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold text-dark">
                            <a href="{{ route('admin.berita.show', $berita->id) }}" class="text-decoration-none text-dark hover-primary" style="transition: color 0.2s;">
                                {{ $berita->judul }}
                            </a>
                        </td>
                        <td>
                            <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(37, 99, 235, 0.08); color: #2563eb; font-weight: 500;">
                                {{ $berita->kategori }}
                            </span>
                        </td>
                        <td class="text-muted">{{ Str::limit(strip_tags($berita->isi), 45) }}</td>
                        <td>{{ $berita->tanggal_terbit->format('d M Y') }}</td>
                        <td>
                            @php
                                $statusLower = strtolower($berita->status);
                                $statusBadge = 'background: rgba(100, 116, 139, 0.08); color: #64748b;';
                                if ($statusLower === 'publish' || $statusLower === 'published') {
                                    $statusBadge = 'background: rgba(22, 163, 74, 0.08); color: #16a34a;';
                                }
                            @endphp
                            <span class="badge rounded-pill px-3 py-1 fw-bold" style="{{ $statusBadge }}">
                                {{ ucfirst($berita->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.berita.show', $berita->id) }}" class="btn btn-sm btn-light border-0 fw-semibold text-secondary" style="background: rgba(100, 116, 139, 0.08); padding: 6px 12px;" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-sm btn-light border-0 fw-semibold text-primary" style="background: rgba(37, 99, 235, 0.08); padding: 6px 12px;" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" class="d-inline" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border-0 fw-semibold text-danger btn-delete" style="background: rgba(220, 38, 38, 0.08); padding: 6px 12px;" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada data berita yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($beritas->hasPages())
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
            {{ $beritas->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('form').forEach(function(form) {
            const deleteBtn = form.querySelector('.btn-delete');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>
@endsection
