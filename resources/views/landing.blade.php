<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Lapor Pak</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon"> -->
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Logis
  * Template URL: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ route('landing') }}" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">LaporPak!</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('landing') }}" class="text-decoration-none">Beranda<br></a></li>
          {{-- <li><a href="#statistik">Statistik</a></li> --}}
          <li><a href="{{ route('faq') }}">FAQ</a></li>
          {{-- <li><a href="#contact">Kontak</a></li>
          <li><a href="{{ route('track.show') }}" class="btn-get-started">Lacak Laporan</a></li> --}}
          @if (Route::has('login'))
            @auth
              {{-- <li><a href="{{ route('laporan.index') }}" class="btn-get-started">History Laporan Saya</a></li> --}}
              <li><a href="{{ url('/dashboard/user') }}" class="btn-get-started">Dashboard</a></li>
            @else
              <li><a href="{{ route('login') }}" class="btn-get-started">Login</a></li>
            @endauth
          @endif
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <!-- <a class="btn-getstarted" href="get-a-quote.html">Get a Quote</a> -->

    </div>
  </header>

  <main class="main">

    <!-- landing Section -->
    <section id="landing" class="landing section dark-background">

      <img src="{{ asset('assets/img/dashboard-1.png') }}" alt="" class="landing-bg" data-aos="fade-in">



      <section class="min-vh-100 d-flex align-items-center" style="background: url('{{ asset('assets/img/your-background-image.jpg') }}') center center / cover no-repeat;">
        <div class="container">
          <div class="row gy-4 d-flex justify-content-between">
            <div class="col-lg-8 d-flex flex-column justify-content-center text-white">
              <h1 class="fw-bold display-4" data-aos="fade-up" data-aos-delay="100">LAYANAN PENGADUAN ONLINE</h1>
              <p class="fs-5" data-aos="fade-up" data-aos-delay="200">
                Laporkan segera saat Anda mempunyai informasi Jalan atau Jembatan Nasional Rusak
              </p>
                <div class="mt-4" data-aos="fade-up" data-aos-delay="300">
                  <a href="{{ route('register') }}" class="btn btn-warning btn-lg me-2 px-4 py-2">Daftar</a>
                  <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4 py-2">Masuk</a>

                <!-- Tombol Lacak Laporanmu -->
                <div class="mt-3" data-aos="fade-up" data-aos-delay="400">
                  <a href="{{ route('track.show') }}" class="btn btn-danger text-white btn-lg px-4 py-2">
                    <i class="bi bi-geo-alt-fill me-2"></i> Lacak Laporanmu
                  </a>                                 
                </div>
              </div>
              
                
              </div>
            </div>
          </div>
        </div>
      </section>
            
            <!-- <form action="#" class="form-search d-flex align-items-stretch mb-3" data-aos="fade-up" data-aos-delay="200">
              <input type="text" class="form-control" placeholder="Your ZIP code or City. e.g. New York">
              <button type="submit" class="btn btn-primary">Search</button>
            </form> -->

            <div class="row gy-4" data-aos="fade-up" data-aos-delay="300">

              <div class="col-lg-3 col-6">
                <div class="stats-item text-center w-100 h-100">
                  <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="0" class="purecounter">232</span>
                  <p>Clients</p>
                </div>
              </div><!-- End Stats Item -->

              <div class="col-lg-3 col-6">
                <div class="stats-item text-center w-100 h-100">
                  <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="0" class="purecounter">521</span>
                  <p>Projects</p>
                </div>
              </div><!-- End Stats Item -->

              <div class="col-lg-3 col-6">
                <div class="stats-item text-center w-100 h-100">
                  <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="0" class="purecounter">1453</span>
                  <p>Support</p>
                </div>
              </div><!-- End Stats Item -->

              <div class="col-lg-3 col-6">
                <div class="stats-item text-center w-100 h-100">
                  <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="0" class="purecounter">32</span>
                  <p>Workers</p>
                </div>
              </div><!-- End Stats Item -->

            </div>

          </div>

          <!-- <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="assets/img/hero-img.svg" class="img-fluid mb-3 mb-lg-0" alt="">
          </div> -->

        </div>
      </div>

    </section><!-- /landing Section -->

    <!-- Statistik -->
    <section class="min-vh-100 d-flex align-items-center position-relative overflow-hidden" style="z-index: 0;">
      <!-- Gambar Background  -->
      <img src="{{ asset('assets/img/dashboard-2.png') }}" alt=""
          class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
          style="z-index: 0; opacity: 0.95;" data-aos="fade-in">

      <div class="container position-relative" style="z-index: 2;">
        <div class="row">
          <div class="col-lg-5 mb-4 mb-lg-0">
            <h2 class="fw-bold" style="font-size:2.5rem; color:#232b44;">
              <span style="border-bottom:4px solid #ffb300; display:inline-block; margin-bottom:10px;">Statistik</span><br>LaporPak
            </h2>
          </div>
          <div class="col-lg-7">
            <div class="d-flex flex-row flex-wrap justify-content-lg-start justify-content-center align-items-end gap-4">
              <div class="stat-card text-center bg-white bg-opacity-75 shadow-sm p-3 rounded" style="width:140px; height:170px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <i class="bi bi-file-earmark-text-fill" style="font-size:2.1rem; color:#ffb300; margin-bottom:10px;"></i>
                <div class="fw-bold" style="font-size:1.7rem; color:#232b44; line-height:1;">{{ $totalLaporan }}</div>
                <div class="small mt-1" style="color:#232b44;">Total</div>
              </div>
              <div class="stat-card text-center bg-white bg-opacity-75 shadow-sm p-3 rounded" style="width:140px; height:170px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <i class="bi bi-calendar-check" style="font-size:2.1rem; color:#ffb300; margin-bottom:10px;"></i>
                <div class="fw-bold" style="font-size:1.7rem; color:#232b44; line-height:1;">{{ $laporanBulanIni }}</div>
                <div class="small mt-1" style="color:#232b44;">Baru</div>
              </div>
              <div class="stat-card text-center bg-white bg-opacity-75 shadow-sm p-3 rounded" style="width:140px; height:170px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <i class="bi bi-check2-square" style="font-size:2.1rem; color:#ffb300; margin-bottom:10px;"></i>
                <div class="fw-bold" style="font-size:1.7rem; color:#232b44; line-height:1;">{{ $selesaiComplaint }}</div>
                <div class="small mt-1" style="color:#232b44;">Selesai</div>
              </div>
              <div class="stat-card text-center bg-white bg-opacity-75 shadow-sm p-3 rounded" style="width:140px; height:170px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <i class="bi bi-gear-fill" style="font-size:2.1rem; color:#ffb300; margin-bottom:10px;"></i>
                <div class="fw-bold" style="font-size:1.7rem; color:#232b44; line-height:1;">{{ $prosesComplaint }}</div>
                <div class="small mt-1" style="color:#232b44;">Proses</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Peta -->
    <section id="peta" class="peta section dark-background">
      <div class="background-overlay">
        <img src="{{ asset('assets/img/peta.png') }}" alt="Peta Indonesia" class="peta-img">
      </div>
      <div class="container">
        <div class="row justify-content-start">
          <div class="col-xl-6">
            <div class="text-block">
              <h2><span class="light-text">PETA</span><br><strong>KONDISI JALAN</strong></h2>
              <div class="underline"></div>
              <a class="cta-btn" href="{{ route('petakondisi.index') }}">Baca Lebih Lanjut &gt;</a>
            </div>
          </div>
        </div>
      </div>
    </section>    
    <!-- /end Peta -->

    {{-- <!-- Berita Section -->
    <section id="recent-posts" class="py-5" style="background:#fff;">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-bold mb-0" style="color:#232b44;">Berita Terbaru</h3>
          <a href="{{ route('news.index') }}" class="btn btn-outline-secondary btn-sm fw-bold">VIEW ALL <i class="bi bi-arrow-up-right"></i></a>
        </div>
        <div class="row g-4">
          <!-- Main Posts -->
          <div class="col-lg-8">
            <div class="row g-3">
  @php $maxPosts = 6; @endphp
@if(!empty($recentNews) && count($recentNews) > 0)
  @foreach($recentNews as $idx => $news)
    @if($idx >= $maxPosts) @break @endif
    <div class="col-md-4 d-flex">
      <a href="{{ route('news.show', $news->id) }}" class="text-decoration-none w-100">
        <div class="card bg-dark text-white h-100">
          <img src="{{ $news->gambar ? asset('storage/'.$news->gambar) : asset('assets/img/news1.jpg') }}" class="card-img" alt="{{ $news->judul }}">
          <div class="card-img-overlay d-flex flex-column justify-content-end p-2">
            <h6 class="card-title fw-bold mb-1" style="font-size:1rem;">{{ $news->judul }}</h6>
            <p class="card-text mb-0" style="font-size:0.85rem;"><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($news->tanggal_terbit)->format('d F, Y') }}</p>
          </div>
        </div>
      </a>
    </div>
  @endforeach
  @if(count($recentNews) < $maxPosts)
    @for($i = count($recentNews); $i < $maxPosts; $i++)
    <div class="col-md-4 d-flex">
      <div class="card bg-dark text-white h-100">
        <img src="{{ asset('assets/img/news'.($i+1).'.jpg') }}" class="card-img" alt="Placeholder">
        <div class="card-img-overlay d-flex flex-column justify-content-end p-2">
          <h6 class="card-title fw-bold mb-1" style="font-size:1rem;">Belum ada berita</h6>
          <p class="card-text mb-0" style="font-size:0.85rem;"><i class="bi bi-calendar"></i> - </p>
        </div>
      </div>
    </div>
    @endfor
  @endif
@else
  @for($i = 0; $i < $maxPosts; $i++)
  <div class="col-md-4 d-flex">
    <div class="card bg-dark text-white h-100">
      <img src="{{ asset('assets/img/news'.($i+1).'.jpg') }}" class="card-img" alt="Placeholder">
      <div class="card-img-overlay d-flex flex-column justify-content-end p-2">
        <h6 class="card-title fw-bold mb-1" style="font-size:1rem;">Belum ada berita</h6>
        <p class="card-text mb-0" style="font-size:0.85rem;"><i class="bi bi-calendar"></i> - </p>
      </div>
    </div>
  </div>
  @endfor
@endif
</div>
          </div>
          <!-- Sidebar News List -->
          <div class="col-lg-4">
            <div class="d-flex justify-content-between mb-2">
              <span class="badge bg-danger">Berita Terbaru</span>
              <span class="fw-bold">Pilihan</span>
            </div>
            <div class="list-group list-group-flush">
              @if(!empty($recentNews) && count($recentNews) > 0)
                @foreach($recentNews as $news)
                  <a href="{{ route('news.show', $news->id) }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 p-2">
                    <img src="{{ $news->gambar ? asset('storage/'.$news->gambar) : asset('assets/img/news1.jpg') }}" alt="{{ $news->judul }}" class="rounded" style="width:48px;height:48px;object-fit:cover;">
                    <div>
                      <div class="fw-bold" style="font-size:0.95rem;">{{ $news->judul }}</div>
                      <div class="text-muted" style="font-size:0.85rem;"><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($news->tanggal_terbit)->translatedFormat('d F, Y') }}</div>
                    </div>
                  </a>
                @endforeach
              @else
                <div class="list-group-item p-2 text-center text-muted">Belum ada berita</div>
              @endif
            </div>
          </div>
        </div>
      </div> --}}

    <!-- Kategori Laporan Section -->
    {{-- <section id="kategori" class="min-vh-100 d-flex align-items-center position-relative overflow-hidden">
  
      <!-- Gambar Background -->
      <img src="{{ asset('assets/img/dashboard-3.png') }}" alt=""
           class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
           style="z-index: 0;" data-aos="fade-in" />
    
      <!-- Konten di atas gambar -->
      <div class="container position-relative" style="z-index: 1;">
        <div class="section-title text-md-start" data-aos="fade-up">
          <h2>KATEGORI LAPORAN</h2>
        </div>
    
        <div class="row justify-content-center gy-4">
          <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="card-kategori text-center shadow">
              <i class="bi bi-search text-danger"></i>
              <h5><a href="{{ route('track.show') }}">Lacak Laporanmu &gt;</a></h5>
              <p>Sudah Melapor? Lacak menggunakan nomor laporan.</p>
            </div>
          </div>
    
          <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="card-kategori text-center shadow">
              <i class="bi bi-graph-up text-purple"></i>
              <h5><a href="{{ route('user.laporan.ringkasan') }}">Laporan Masuk &amp; Selesai &gt;</a></h5>
              <p>Data Laporan Masuk Tahun 2025</p>
            </div>
          </div>
    
          <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="card-kategori text-center shadow">
              <i class="bi bi-clipboard-data text-primary"></i>
              <h5><a href="{{ route('laporan.masuk') }}">Aktivitas Laporan &gt;</a></h5>
              <p>Lihat Aktivitas Laporanmu</p>
            </div>
          </div>
        </div>
      </div>
    </section>     --}}
   <!-- /Kategori Laporan Section -->


    <!-- Video -->
    <section id="about" class="video" style="background-image: url('{{ asset('assets/img/video1.png') }}'); background-size: cover; background-position: center;">

      <div class="container">
        <div class="row gy-4">

          <!-- Gambar + Play Button -->
          <div class="col-lg-6 position-relative align-self-start order-lg-last order-first" data-aos="fade-up" data-aos-delay="200">
            <img src="{{ asset('assets/img/video2.png') }}" class="img-fluid rounded" alt="">
            <a href="https://www.youtube.com/watch?v=cd940jePm3Y" class="glightbox pulsating-play-btn"></a>
          </div>

      <!-- Konten Teks -->
      <div class="col-lg-6 content order-last order-lg-first text-white d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
        <h3>Konten Sosialisasi LaporPak</h3>
        <p>
          Kegiatan Sosialisasi secara offline oleh <br>
          sepeda motor di wilayah Kota Bandung<br>
          pada tanggal 3 Januari 2024
        </p>
      </div>

        </div>
      </div>

    </section>
    <!-- /End Video -->

    <!-- footer -->
    <footer class="custom-footer">
      <div class="container footer-content">
        <div class="footer-section social-icons">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
        </div>
        <div class="footer-section">
          <i class="bi bi-envelope-fill"></i> laporpak@example.com
        </div>
        <div class="footer-section">
          <i class="bi bi-telephone-fill"></i> (480) 555-0103
        </div>
        <div class="footer-section">
          <i class="bi bi-geo-alt-fill"></i> Jl. Telekomunikasi No. 1, Bandung Terusan Buahbatu
        </div>
      </div>
    </footer>
    

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>