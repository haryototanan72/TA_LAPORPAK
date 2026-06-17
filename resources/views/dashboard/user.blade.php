<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>LaporPak! - Dashboard User</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <style>
    /* --- GAYA TAMPILAN MODERN TERBARU --- */
    /* Hero CTA Button */
    .btn-lapor-modern {
        background: linear-gradient(135deg, #ff8c42 0%, #ff3c3c 100%);
        color: #fff !important;
        font-weight: 700;
        letter-spacing: 1px;
        border: none;
        border-radius: 50px;
        box-shadow: 0 8px 24px rgba(255, 60, 60, 0.35);
        transition: all 0.3s ease;
    }
    .btn-lapor-modern:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 32px rgba(255, 60, 60, 0.5);
    }

    /* Card Kategori Modern (Glassmorphism & Rapat) */
    .features-row-custom {
        max-width: 960px;
        margin: 0 auto;
    }
    .card-kategori-modern {
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        padding: 35px 25px;
        box-shadow: 0 10px 30px rgba(35, 43, 68, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .card-kategori-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(255, 140, 66, 0.15);
        border-color: rgba(255, 140, 66, 0.3);
        background: #ffffff;
    }
    .card-kategori-modern .icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }
    .card-kategori-modern:hover .icon-circle {
        transform: scale(1.1) rotate(5deg);
    }
    .card-kategori-modern h5 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #232b44;
        margin-bottom: 12px;
    }
    .card-kategori-modern p {
        font-size: 0.88rem;
        color: #64748b;
        margin-bottom: 0;
        line-height: 1.5;
    }

    /* Stat Card Modern */
    .stat-card-modern {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
        border-radius: 18px;
        width: 140px;
        height: 160px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .stat-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        background: #ffffff;
    }
  </style>
</head>
<body class="index-page">
  
  @include('layouts.partials.user-header')

  <main class="main">
    <section id="hero" class="min-vh-100 d-flex align-items-center position-relative overflow-hidden dark-background" style="z-index: 0; background: url('{{ asset('assets/img/hero-bg.jpg') }}') center center / cover no-repeat;">
      <img src="{{ asset('assets/img/dashboard-1.png') }}" alt="" class="landing-bg position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 1; opacity: 1; pointer-events:none;">
      <div class="container position-relative z-2">
        <div class="row gy-4 d-flex justify-content-between">
          <div class="col-lg-8 d-flex flex-column justify-content-center text-white" style="text-shadow: 0 2px 10px rgba(0,0,0,0.4);">
            <h1 class="fw-bold display-4" data-aos="fade-up" data-aos-delay="100">LaporPak!</h1>
              <p class="fs-5" data-aos="fade-up" data-aos-delay="200">
                Platform Pelaporan Infrastruktur Kota Bandung Berbasis Crowdsensing dan Gamifikasi <br>
                "Mata Warga, Data Nyata, Infrastruktur Terjaga."
              </p>
            <div data-aos="fade-up" data-aos-delay="300">
              <a href="{{ route('laporan.form_laporan') }}" id="btn-lapor" class="btn btn-lapor-modern btn-lg px-5 py-3 mt-3">LAPOR!</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section id="statistik" class="py-5 d-flex align-items-center position-relative overflow-hidden" style="z-index: 0; min-height: 80vh;">
      <img src="{{ asset('assets/img/dashboard-2.png') }}" alt="" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 0; opacity: 0.95;">
      <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
          <div class="col-lg-4 mb-5 mb-lg-0">
            <h2 class="fw-bold" style="font-size:2.6rem; color:#232b44;">
              <span style="border-bottom:4px solid #ffb300; display:inline-block; margin-bottom:10px; padding-bottom: 5px;">Statistik Pelaporan</span><br>LaporPak
            </h2>
            <p class="text-muted mt-3" style="font-size: 0.95rem;">Transparansi jumlah pengaduan dari seluruh masyarakat untuk Bandung yang lebih baik.</p>
          </div>
          <div class="col-lg-8">
            <div class="row row-cols-2 row-cols-sm-3 g-3 justify-content-center justify-content-lg-start mx-auto mx-lg-0" style="max-width: 480px;">
              <div class="col d-flex justify-content-center">
                <div class="stat-card-modern text-center">
                  <i class="bi bi-file-earmark-text-fill" style="font-size:2rem; color:#ffb300; margin-bottom:8px;"></i>
                  <div class="fw-bold" style="font-size:1.6rem; color:#232b44; line-height:1;">{{ $total ?? '0' }}</div>
                  <div class="small mt-1 fw-semibold" style="color:#64748b; font-size: 0.8rem;">Total Laporan</div>
                </div>
              </div>
              
              <div class="col d-flex justify-content-center">
                <div class="stat-card-modern text-center">
                  <i class="bi bi-send" style="font-size:2rem; color:#64748b; margin-bottom:8px;"></i>
                  <div class="fw-bold" style="font-size:1.6rem; color:#232b44; line-height:1;">{{ $diajukan ?? '0' }}</div>
                  <div class="small mt-1 fw-semibold" style="color:#64748b; font-size: 0.8rem;">Diajukan</div>
                </div>
              </div>
              
              <div class="col d-flex justify-content-center">
                <div class="stat-card-modern text-center">
                  <i class="bi bi-search" style="font-size:2rem; color:#0891b2; margin-bottom:8px;"></i>
                  <div class="fw-bold" style="font-size:1.6rem; color:#232b44; line-height:1;">{{ $diverifikasi ?? '0' }}</div>
                  <div class="small mt-1 fw-semibold" style="color:#64748b; font-size: 0.8rem;">Diverifikasi</div>
                </div>
              </div>
              
              <div class="col d-flex justify-content-center">
                <div class="stat-card-modern text-center">
                  <i class="bi bi-tools" style="font-size:2rem; color:#f39c12; margin-bottom:8px;"></i>
                  <div class="fw-bold" style="font-size:1.6rem; color:#232b44; line-height:1;">{{ $ditindaklanjuti ?? '0' }}</div>
                  <div class="small mt-1 fw-semibold" style="color:#64748b; font-size: 0.8rem;">Tindak Lanjut</div>
                </div>
              </div>
              
              <div class="col d-flex justify-content-center">
                <div class="stat-card-modern text-center">
                  <i class="bi bi-check2-square" style="font-size:2rem; color:#2ecc71; margin-bottom:8px;"></i>
                  <div class="fw-bold" style="font-size:1.6rem; color:#232b44; line-height:1;">{{ $selesai ?? '0' }}</div>
                  <div class="small mt-1 fw-semibold" style="color:#64748b; font-size: 0.8rem;">Selesai</div>
                </div>
              </div>
              
              <div class="col d-flex justify-content-center">
                <div class="stat-card-modern text-center">
                  <i class="bi bi-x-circle" style="font-size:2rem; color:#e74c3c; margin-bottom:8px;"></i>
                  <div class="fw-bold" style="font-size:1.6rem; color:#232b44; line-height:1;">{{ $ditolak ?? '0' }}</div>
                  <div class="small mt-1 fw-semibold" style="color:#64748b; font-size: 0.8rem;">Ditolak</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section id="peta" class="peta section dark-background">
      <div class="background-overlay">
        <img src="{{ asset('assets/img/peta.png') }}" alt="Peta Indonesia" class="peta-img">
      </div>
      <div class="container">
        <div class="row justify-content-start">
          <div class="col-xl-6">
            <div class="text-block">
              <h2><span class="light-text">PETA</span><br><strong>KONDISI JALAN</strong></h2>
               <p>Lihat titik jalan rusak dimana saja, dan kondisinya!</p>
              <div class="underline"></div>
              <a class="cta-btn" href="{{ route('petakondisi.index') }}">Baca Lebih Lanjut &gt;</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section id="kategori" class="py-5 d-flex align-items-center position-relative overflow-hidden" style="min-height: 80vh;">
      <img src="{{ asset('assets/img/dashboard-3.png') }}" alt="" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="z-index: 0;" data-aos="fade-in" />
      <div class="container position-relative" style="z-index: 1;">
        <div class="section-title text-center mb-5" data-aos="fade-up">
          <h2 style="font-size: 2.2rem; color: #232b44; font-weight: 700; letter-spacing: 1px;">PANTAU LAPORANMU</h2>
          <div style="width: 60px; height: 4px; background: #ffb300; margin: 10px auto;"></div>
        </div>
        
        <div class="row justify-content-center gy-4 features-row-custom">
          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
            <a href="{{ route('track.show') }}" class="card-kategori-modern text-center">
              <div class="icon-circle text-white bg-danger shadow-sm" style="background: linear-gradient(135deg, #ff6b6b, #ee5253) !important;">
                <i class="bi bi-search"></i>
              </div>
              <h5>Lacak Laporanmu &gt;</h5>
              <p>Sudah Melapor? Lacak menggunakan nomor laporan untuk melihat perkembangan status aduan Anda.</p>
            </a>
          </div>
          
          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
            <a href="{{ route('leaderboard.index') }}" class="card-kategori-modern text-center">
              <div class="icon-circle text-white bg-warning shadow-sm" style="background: linear-gradient(135deg, #fbb03b, #f39c12) !important;">
                <i class="bi bi-graph-up"></i>
              </div>
              <h5>Leaderboard Pelapor &gt;</h5>
              <p>Pantau peringkat keaktifan pelapor lainnya, jadilah kontributor utama dan klaim Gelar kehormatan!</p>
            </a>
          </div>
          
          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <a href="{{ route('laporan.index') }}" class="card-kategori-modern text-center">
              <div class="icon-circle text-white bg-primary shadow-sm" style="background: linear-gradient(135deg, #54a0ff, #2e86de) !important;">
                <i class="bi bi-clipboard-data"></i>
              </div>
              <h5>Aktivitas Laporan &gt;</h5>
              <p>Lihat daftar seluruh riwayat laporan pengaduan infrastruktur Anda beserta tanggapan petugas.</p>
            </a>
          </div>
        </div>
      </div>
    </section>
    
    <section id="about" class="video" style="background-image: url('{{ asset('assets/img/video1.png') }}'); background-size: cover; background-position: center;">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start order-lg-last order-first" data-aos="fade-up" data-aos-delay="200">
            <img src="{{ asset('assets/img/video2.png') }}" class="img-fluid rounded" alt="">
            <a href="https://www.youtube.com/watch?v=cd940jePm3Y" class="glightbox pulsating-play-btn"></a>
          </div>
          <div class="col-lg-6 content order-last order-lg-first text-white d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <h3>Konten Sosialisasi LaporPak</h3>
            <p>
              Kegiatan Sosialisasi secara offline oleh <br>
              sepeda motor di wilayah Kota Bandung<br>
              pada tanggal Januari 2026
            </p>
          </div>
        </div>
      </div>
    </section>
    
    <section id="recent-posts" class="py-5" style="background: #f4f7f6;">
      <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4" data-aos="fade-up">
          <div>
            <h6 class="text-warning fw-bold mb-1" style="letter-spacing: 2px; font-size: 0.8rem;">UPDATE TERKINI</h6>
            <h2 class="fw-bold mb-0" style="color:#232b44;">Berita Terbaru</h2>
          </div>
          <a href="{{ route('news.index') }}" class="btn-view-all">
            LIHAT SEMUA BERITA <i class="bi bi-arrow-up-right-circle ms-1"></i>
          </a>
        </div>

        <div class="row g-4">
          <div class="col-lg-8">
            <div class="row g-4">
              @php $maxPosts = 6; @endphp
              @if(!empty($recentNews) && count($recentNews) > 0)
                @foreach($recentNews as $idx => $news)
                  @if($idx >= $maxPosts) @break @endif
                  <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $idx * 50 }}">
                    <div class="news-modern-card shadow-sm h-100">
                      <div class="news-img-container">
                        <img src="{{ $news->gambar ? asset('storage/'.$news->gambar) : asset('assets/img/news1.jpg') }}" 
                             alt="{{ $news->judul }}">
                        <span class="category-badge">{{ $news->kategori ?? 'UMUM' }}</span>
                      </div>
                      <div class="card-body-modern">
                        <h5 class="news-modern-title">
                          <a href="{{ route('news.show', $news->id) }}">{{ Str::limit($news->judul, 60) }}</a>
                        </h5>
                        <div class="news-modern-meta">
                          <span><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($news->tanggal_terbit)->translatedFormat('d M Y') }}</span>
                          <span class="read-more-link">Baca Selengkapnya <i class="bi bi-arrow-right"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>

          <div class="col-lg-4">
            <div class="sidebar-news-container p-4 shadow-sm" data-aos="fade-left">
              <div class="d-flex align-items-center mb-4 border-bottom pb-2">
                <div class="hot-icon me-2"><i class="bi bi-fire text-danger"></i></div>
                <h5 class="fw-bold mb-0" style="color: #232b44;">Pilihan Redaksi</h5>
              </div>
              
              <div class="list-group list-group-flush gap-3">
                @if(!empty($recentNews) && count($recentNews) > 0)
                  @foreach($recentNews->take(4) as $news)
                    <a href="{{ route('news.show', $news->id) }}" class="sidebar-item d-flex align-items-center gap-3">
                      <img src="{{ $news->gambar ? asset('storage/'.$news->gambar) : asset('assets/img/news1.jpg') }}" 
                           class="rounded-3 shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                      <div class="flex-grow-1 overflow-hidden">
                        <h6 class="fw-bold mb-1 text-navy text-truncate" style="font-size: 0.9rem;">{{ $news->judul }}</h6>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($news->tanggal_terbit)->diffForHumans() }}</small>
                      </div>
                    </a>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <style>
      .text-navy { color: #232b44; }
      
      .btn-view-all {
          text-decoration: none;
          color: #232b44;
          font-weight: 700;
          font-size: 0.9rem;
          padding: 8px 18px;
          border: 2px solid #232b44;
          border-radius: 50px;
          transition: 0.3s ease;
      }
      .btn-view-all:hover {
          background: #232b44;
          color: #ffb300;
          transform: translateY(-3px);
      }

      .news-modern-card {
          background: #ffffff;
          border-radius: 20px;
          overflow: hidden;
          transition: 0.4s ease;
          border: 1px solid rgba(0,0,0,0.05);
      }
      .news-modern-card:hover {
          transform: translateY(-10px);
          box-shadow: 0 15px 35px rgba(35, 43, 68, 0.12) !important;
      }

      .news-img-container {
          position: relative;
          height: 190px;
          overflow: hidden;
      }
      .news-img-container img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: 0.6s ease;
      }
      .news-modern-card:hover .news-img-container img {
          transform: scale(1.1);
      }

      .category-badge {
          position: absolute;
          top: 15px;
          left: 15px;
          background: #ffb300;
          color: #232b44;
          padding: 4px 12px;
          border-radius: 50px;
          font-size: 0.7rem;
          font-weight: 800;
          box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      }

      .card-body-modern {
          padding: 20px;
      }

      .news-modern-title a {
          text-decoration: none;
          color: #232b44;
          font-weight: 700;
          font-size: 1.05rem;
          line-height: 1.4;
          transition: 0.3s;
      }
      .news-modern-title a:hover {
          color: #ffb300;
      }

      .news-modern-meta {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-top: 15px;
          padding-top: 12px;
          border-top: 1px solid #f0f0f0;
          font-size: 0.8rem;
          color: #6c757d;
      }

      .read-more-link {
          color: #ffb300;
          font-weight: 700;
          text-transform: uppercase;
          font-size: 0.7rem;
      }

      .sidebar-news-container {
          background: #ffffff;
          border-radius: 20px;
      }
      .sidebar-item {
          text-decoration: none;
          transition: 0.3s;
      }
      .sidebar-item:hover {
          transform: translateX(5px);
      }
      .sidebar-item:hover h6 {
          color: #ffb300 !important;
      }
    </style>
  <footer class="custom-footer">
      <div class="container footer-content">
        <div class="footer-section social-icons">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
        </div>
        <div class="footer-section">
          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=TimLaporPak@laporpak.id" target="_blank" style="text-decoration: none; color: inherit;">
          <i class="bi bi-envelope-fill"></i> TimLaporPak@laporpak.id</a>
        </div>
        <div class="footer-section">
          <i class="bi bi-telephone-fill"></i> (022) 555-0103
        </div>
        <div class="footer-section">
          <i class="bi bi-geo-alt-fill"></i> Jl. Telekomunikasi No. 1, Bandung Terusan Buahbatu
        </div>
      </div><br>
      <div class="container text-center">
        <p class="mb-0">&copy; With ❤️ Tim Laporpak 2026</p>
      </div>
    </footer>
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  
  <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 rounded-15 shadow">
        <div class="modal-header border-0 bg-light py-3">
          <h5 class="modal-title fw-bold text-dark" id="notificationModalLabel">
            <i class="bi bi-bell-fill text-warning me-2"></i> Notifikasi Terkini
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3">
          @if(isset($dashboardNotifications) && count($dashboardNotifications) > 0)
            <div class="list-group list-group-flush">
              @foreach($dashboardNotifications as $notif)
                @php
                  $statusLower = isset($notif->data['status']) ? strtolower($notif->data['status']) : '';
                  $iconClass = 'bi-bell-fill text-primary';
                  
                  if (strpos($statusLower, 'selesai') !== false || strpos($statusLower, 'diperbaiki') !== false) {
                      $iconClass = 'bi-check-circle-fill text-success';
                  } elseif (strpos($statusLower, 'tolak') !== false || strpos($statusLower, 'kurang valid') !== false) {
                      $iconClass = 'bi-x-circle-fill text-danger';
                  } elseif (strpos($statusLower, 'tindak') !== false || strpos($statusLower, 'proses') !== false) {
                      $iconClass = 'bi-gear-fill text-warning';
                  }
                @endphp
                <div class="list-group-item border-0 rounded-10 mb-2 p-3 d-flex align-items-start {{ $notif->read_at ? 'bg-white border-bottom' : 'bg-light-orange-tint' }}" style="transition: background-color 0.2s; border: 1px solid #f1f1f1 !important;">
                  <div class="rounded-circle d-flex align-items-center justify-content-center p-2 me-3 bg-white shadow-xs" style="width: 36px; height: 36px; flex-shrink: 0; border: 1px solid #eee;">
                    <i class="bi {{ $iconClass }}" style="font-size: 1.1rem;"></i>
                  </div>
                  <div class="flex-grow-1 min-width-0">
                    <p class="mb-1 text-dark small" style="line-height: 1.4; font-weight: {{ $notif->read_at ? '400' : '600' }}; text-align: left;">
                      {{ $notif->data['message'] ?? 'Perubahan status laporan.' }}
                    </p>
                    <span class="text-muted d-block text-start" style="font-size: 0.75rem;">
                      <i class="bi bi-clock-history me-1"></i> {{ $notif->created_at->diffForHumans() }}
                    </span>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-5">
              <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
              <p class="text-muted mt-2 small">Tidak ada notifikasi untuk saat ini.</p>
            </div>
          @endif
        </div>
        <div class="modal-footer border-0 bg-light py-2 justify-content-center">
          <a href="{{ route('notifikasi.index') }}" class="btn btn-sm btn-outline-warning w-100 rounded-32 fw-bold py-2">
            Lihat Semua Riwayat Notifikasi
          </a>
        </div>
      </div>
    </div>
  </div>

  <style>
    .rounded-15 { border-radius: 15px !important; }
    .rounded-10 { border-radius: 10px !important; }
    .bg-light-orange-tint {
        background-color: rgba(246, 178, 62, 0.05) !important;
        border: 1px solid rgba(246, 178, 62, 0.12) !important;
    }
    .shadow-xs {
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
  </style>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>