@extends('layouts.adminlayout')

@section('title', 'Detail Berita')

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
        padding: 20px 24px;
    }
    .card-title-custom {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
    }
    .berita-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.35;
    }
    .berita-content {
        font-size: 1rem;
        color: #334155;
        line-height: 1.7;
    }
</style>

<div class="container-fluid px-0 py-2">
    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="fw-bold text-dark" style="font-size: 1.5rem;">Detail Berita</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Pratinjau artikel berita dan pengaturan penerbitan publik.</p>
        </div>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-primary fw-semibold" style="border-radius: 8px; padding: 8px 24px;">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Main Section -->
    <div class="row">
        <!-- News Content (Left) -->
        <div class="col-lg-8 mb-4">
            <div class="card custom-card">
                <div class="card-body p-4">
                    <h2 class="berita-title mb-3">{{ $berita->judul }}</h2>
                    
                    <div class="mb-4 d-flex align-items-center gap-2 flex-wrap" style="font-size: 0.85rem;">
                        <span class="badge rounded-pill px-3 py-1 fw-semibold" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                            {{ $berita->kategori }}
                        </span>
                        
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
                        
                        <span class="text-muted ms-2 d-inline-flex align-items-center gap-1">
                            <i class="bi bi-calendar3"></i> Terbit: {{ $berita->tanggal_terbit->format('d M Y') }}
                        </span>
                    </div>
                    
                    @if($berita->gambar)
                        <div class="mb-4 text-center bg-light rounded overflow-hidden p-2" style="border: 1px solid #f1f5f9;">
                            <img src="/storage/{{ $berita->gambar }}" alt="Gambar Utama" class="img-fluid rounded shadow-sm" style="max-height: 420px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <div class="berita-content border-top pt-4">
                        {!! $berita->isi !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions & Info (Right) -->
        <div class="col-lg-4 mb-4">
            <div class="card custom-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">Informasi Publikasi</h5>
                </div>
                <div class="list-group list-group-flush" style="font-size: 0.85rem;">
                    <div class="list-group-item px-4 py-3 bg-transparent border-bottom">
                        <small class="text-muted d-block mb-1">Dibuat Pada</small>
                        <strong class="text-dark">{{ $berita->created_at->format('d M Y · H:i') }} WIB</strong>
                    </div>
                    <div class="list-group-item px-4 py-3 bg-transparent border-bottom">
                        <small class="text-muted d-block mb-1">Terakhir Diperbarui</small>
                        <strong class="text-dark">{{ $berita->updated_at->format('d M Y · H:i') }} WIB</strong>
                    </div>
                </div>
                <div class="card-body p-4">
                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn text-white fw-bold d-block w-100 mb-3 border-0 py-2.5" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 10px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);">
                        <i class="bi bi-pencil"></i> Edit Berita
                    </a>
                    
                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light fw-bold text-danger d-block w-100 py-2.5 border-0 btn-delete" style="background: rgba(220, 38, 38, 0.08); border-radius: 10px; transition: all 0.2s;">
                            <i class="bi bi-trash"></i> Hapus Berita
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteBtn = document.querySelector('.btn-delete');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus berita ini secara permanen?')) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
@endsection
