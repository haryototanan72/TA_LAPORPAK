@extends('layouts.app')

@section('content')
<style>
    /* Background Page */
    body {
        background-color: #f4f7f6;
    }

    /* News Card Enhancements */
    .news-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        position: relative;
    }
    
    .news-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(35, 43, 68, 0.15) !important;
    }

    .news-image-wrapper {
        position: relative;
        overflow: hidden;
    }

    .news-image {
        height: 240px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .news-card:hover .news-image {
        transform: scale(1.1);
    }

    /* Category Badge Overlay */
    .badge-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(251, 176, 59, 0.9);
        backdrop-filter: blur(5px);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 50px;
        z-index: 2;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .news-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #232b44;
        line-height: 1.3;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-excerpt {
        font-size: 0.92rem;
        color: #636e72;
        line-height: 1.6;
    }

    /* Custom Button */
    .btn-read {
        background-color: #232b44;
        color: #fff;
        border-radius: 12px;
        padding: 8px 20px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }

    .btn-read:hover {
        background-color: #fbb03b;
        color: #232b44;
    }

    /* Section Header */
    .section-header {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 30px;
    }

    .section-header::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 4px;
        background: #fbb03b;
        border-radius: 2px;
    }
</style>

<div class="container py-5 mt-5">
    <div class="mb-5" data-aos="fade-right">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-navy text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Berita</li>
            </ol>
        </nav>
        <h2 class="display-6 fw-bold text-navy">Pusat Informasi <span class="text-warning">LaporPak!</span></h2>
        <p class="text-muted">Pantau terus perkembangan infrastruktur Kota Bandung di sini.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12">
            <h4 class="section-header fw-bold">Berita Utama</h4>
        </div>
        
        @forelse($featuredNews as $featured)
            <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                <div class="card news-card h-100 shadow-sm border-0">
                    <div class="news-image-wrapper">
                        <span class="badge-category">{{ $featured->kategori ?? 'UMUM' }}</span>
                        @if($featured->gambar)
                            <img src="{{ asset('storage/' . $featured->gambar) }}" class="news-image" alt="{{ $featured->judul }}">
                        @else
                            <div class="news-image bg-navy d-flex align-items-center justify-content-center">
                                <i class="bi bi-newspaper text-white opacity-25" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="news-title">{{ $featured->judul }}</h5>
                        <p class="news-excerpt flex-grow-1">
                            {{ Str::limit(strip_tags($featured->isi), 100) }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($featured->tanggal_terbit)->diffForHumans() }}
                            </small>
                            <a href="{{ route('news.show', $featured->id) }}" class="btn btn-read btn-sm">
                                Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted italic">Belum ada berita utama tersedia.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-5">
        <h4 class="section-header fw-bold">Arsip Berita</h4>
        <div class="row g-4">
            @foreach($beritas as $berita)
                <div class="col-md-6 col-lg-3" data-aos="fade-up">
                    <div class="card news-card h-100 shadow-sm border-0">
                        <div class="news-image-wrapper">
                            @if($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" class="news-image" style="height: 160px;" alt="{{ $berita->judul }}">
                            @else
                                <div class="news-image bg-light" style="height: 160px;"></div>
                            @endif
                        </div>
                        <div class="card-body p-3">
                            <small class="text-warning fw-bold mb-1 d-block">{{ strtoupper($berita->kategori) }}</small>
                            <h6 class="fw-bold text-navy" style="font-size: 0.95rem;">{{ Str::limit($berita->judul, 50) }}</h6>
                            <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($berita->tanggal_terbit)->translatedFormat('d M Y') }}</p>
                            <a href="{{ route('news.show', $berita->id) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $beritas->links() }}
        </div>
    </div>
</div>

<style>
    .text-navy { color: #232b44; }
    .bg-navy { background-color: #232b44; }
</style>
@endsection