@extends('layouts.app')

@section('content')

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news.index') }}" class="text-decoration-none">Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>

            <h1 class="display-5 fw-bold mb-3" style="color: #232b44;">{{ $berita->judul }}</h1>

            <div class="d-flex align-items-center article-meta mb-4 pb-3 border-bottom text-muted">
                <div class="me-4">
                    <i class="fas fa-calendar-alt me-2 text-warning"></i> 
                    {{ \Carbon\Carbon::parse($berita->tanggal_terbit)->translatedFormat('d F Y') }}
                </div>
                <div>
                    <i class="fas fa-tag me-2 text-warning"></i> 
                    <span class="badge bg-light text-dark border">{{ $berita->kategori }}</span>
                </div>
            </div>

            @if($berita->gambar)
                <div class="position-relative mb-5 shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('storage/' . $berita->gambar) }}" 
                         alt="{{ $berita->judul }}" 
                         class="img-fluid w-100" 
                         style="max-height: 500px; object-fit: cover;">
                </div>
            @endif

            <article class="article-content" style="line-height: 1.9; font-size: 1.15rem; color: #444; text-align: justify;">
                {{-- 
                    PENTING: Gunakan {!! !!} agar tag HTML dari editor (seperti CKEditor) 
                    bisa ter-render menjadi paragraf, bukan teks mentah.
                --}}
                {!! $berita->isi !!}
            </article>

        </div>
    </div>
</div>

<style>
    /* Mengikuti skema warna Navy Dashboard kamu */
    .btn-navy {
        background-color: #232b44;
        color: white;
        border: none;
        transition: 0.3s;
    }

    .btn-navy:hover {
        background-color: #1a2033;
        color: #ffb300;
        transform: translateY(-2px);
    }

    /* Styling tambahan untuk konten agar rapi */
    .article-content p {
        margin-bottom: 1.5rem;
    }

    .breadcrumb-item a {
        color: #232b44;
        font-weight: 500;
    }

    /* Penyesuaian untuk body agar tidak mepet navbar fixed */
    body {
        background-color: #f8f9fa;
    }
</style>
@endsection