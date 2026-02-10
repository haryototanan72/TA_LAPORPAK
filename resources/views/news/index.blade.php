@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Laporpak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .news-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
            height: 100%;
        }
        .news-card:hover {
            transform: translateY(-5px);
        }
        .news-image {
            height: 200px;
            object-fit: cover;
        }
        .news-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .news-excerpt {
            color: #666;
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
                        <a class="nav-link" href="#">Tentang</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- Featured News Section -->
    <div class="container mt-4">
    <button type="button" onclick="window.history.back()" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left me-1"></i> Kembali</button>
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Berita Utama</h2>
            </div>
        </div>

        <div class="row">
            @forelse($featuredNews as $featured)
                <div class="col-md-4 mb-4">
                    <div class="card news-card h-100">
                        @if($featured->gambar)
                            <img src="{{ Storage::url($featured->gambar) }}" class="card-img-top news-image" alt="{{ $featured->judul }}">
                        @else
                            <div class="card-img-top news-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-newspaper fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="news-title">{{ $featured->judul }}</h5>
                            <p class="news-excerpt flex-grow-1">{{ Str::limit(strip_tags($featured->isi), 150) }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($featured->tanggal_terbit)->format('d M Y') }}
                                    </small>
                                    <a href="{{ route('news.show', $featured->id) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Belum ada berita utama.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- All News Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="mb-4">Semua Berita</h2>
            </div>
        </div>

        <!-- News Grid -->
        <div class="row">
            @forelse($beritas as $berita)
            <div class="col-md-4 mb-4">
                <div class="card news-card">
                    @if($berita->gambar)
                        <img src="{{ Storage::url($berita->gambar) }}" class="card-img-top news-image" alt="{{ $berita->judul }}">
                    @else
                        <div class="card-img-top news-image bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="news-title">{{ $berita->judul }}</h5>
                        <p class="news-excerpt flex-grow-1">{{ Str::limit(strip_tags($berita->isi), 100) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($berita->tanggal_terbit)->format('d M Y') }}
                                </small>
                                <a href="{{ route('news.show', $berita->id) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Belum ada berita yang dipublikasikan.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                {{ $beritas->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
