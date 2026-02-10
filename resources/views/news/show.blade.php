<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - Laporpak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .article-image {
            max-height: 400px;
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
        .article-meta {
            color: #666;
            font-size: 0.9rem;
        }
        .article-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('news.index') }}">
                <span class="text-primary">Lapor</span>Pak
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('news.index') }}">Berita</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- Article Content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $berita->judul }}</h1>
                <div class="article-meta mb-4">
                    <span class="me-3"><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($berita->tanggal_terbit)->format('d M Y') }}</span>
                    <span><i class="fas fa-folder me-1"></i> {{ $berita->kategori }}</span>
                </div>
                @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="article-image mb-4">
                @endif
                <div class="article-content">
                    {!! nl2br(e($berita->isi)) !!}
                </div>
                <div class="mt-4">
                    <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Berita
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
