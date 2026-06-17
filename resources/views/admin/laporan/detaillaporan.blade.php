@extends('layouts.adminlayout')

@section('title', 'Detail Laporan - LaporPak')

@section('head')
    <!-- Leaflet CSS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection

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
        gap: 12px;
    }
    .btn-back-dashboard {
        color: #64748b;
        text-decoration: none;
        font-size: 1.25rem;
        display: inline-flex;
        align-items: center;
        transition: color 0.2s;
    }
    .btn-back-dashboard:hover {
        color: #2563eb;
    }
    .card-title-custom {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
    }
    th.text-secondary {
        font-weight: 600;
        color: #64748b !important;
        width: 160px;
    }
    .form-select-custom {
        background-color: #2563eb;
        color: #ffffff;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
    }
    .form-select-custom:focus {
        border: 1px solid #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    }
    .btn-change-status {
        background: #2563eb;
        border: none;
        color: #ffffff;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 24px;
        transition: background-color 0.2s;
    }
    .btn-change-status:hover {
        background: #1d4ed8;
    }
    
    /* Media box styles */
    .media-preview-box {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        max-height: 250px;
        overflow: hidden;
    }
    
    /* Timeline styles */
    .status-timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 36px;
        min-width: 100%;
        position: relative;
    }
    .timeline-line {
        position: absolute;
        left: 0;
        right: 0;
        top: 28px;
        height: 4px;
        background: rgba(37, 99, 235, 0.1);
        z-index: 1;
    }
    .timeline-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: 500;
        color: #94a3b8;
        z-index: 2;
        min-width: 120px;
    }
    .timeline-item.done {
        color: #2563eb;
    }
    .timeline-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        background: #f1f5f9;
        color: #94a3b8;
        border-radius: 50%;
        margin-bottom: 10px;
        font-size: 1.5rem;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        transition: background 0.2s, color 0.2s;
    }
    .timeline-item.done .timeline-icon {
        background: #2563eb;
        color: #fff;
    }
    .timeline-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-top: 2px;
        text-align: center;
    }
</style>

<div class="container-fluid px-0 py-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-header-custom">
                    <a href="{{ route('admin.laporan.index') }}" class="btn-back-dashboard" title="Kembali ke Daftar Laporan">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h5 class="card-title-custom">Detail Informasi Laporan</h5>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Row 1: Detail Table & Mini Map -->
                    <div class="row g-4 align-items-stretch mb-5">
                        <div class="col-md-6">
                            <table class="table table-borderless align-middle mb-0">
                                <tr>
                                    <th class="text-secondary">Nomor Laporan</th>
                                    <td class="fw-semibold text-dark">{{ $laporan->nomor_laporan }}</td>
                                </tr>
                                <tr>
                                    <th class="text-secondary">Tanggal Masuk</th>
                                    <td>{{ $laporan->created_at->format('d F Y H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <th class="text-secondary">Pelapor</th>
                                    <td>{{ $laporan->user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-secondary">Jenis Laporan</th>
                                    <td>{{ $laporan->jenis_laporan }}</td>
                                </tr>
                                <tr>
                                    <th class="text-secondary">Ciri Khusus</th>
                                    <td>{{ $laporan->ciri_khusus ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-secondary">Status Laporan</th>
                                    <td>
                                        <form id="statusForm" action="{{ route('admin.laporan.updateStatus', $laporan->nomor_laporan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" id="statusSelect" class="form-select form-select-custom d-inline-block w-auto">
                                                <option value="diajukan" {{ $laporan->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                                <option value="diverifikasi" {{ $laporan->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                                <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                <option value="ditindaklanjuti" {{ $laporan->status == 'ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                                                <option value="ditanggapi" {{ $laporan->status == 'ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
                                                <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                @if($laporan->status === 'diverifikasi')
                                <tr>
                                    <th class="text-secondary">Verifikasi</th>
                                    <td>
                                        <form action="{{ route('admin.laporan.verify', $laporan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm fw-semibold rounded-8 px-3">
                                                <i class="bi bi-envelope-check-fill me-1"></i> Kirim Email ke Instansi
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                                @if($laporan->laporanPetugas->count())
                                <tr>
                                    <th class="text-secondary align-top">Kondisi Lapangan</th>
                                    <td>
                                        @foreach($laporan->laporanPetugas as $petugas)
                                            <div class="p-2 bg-light border rounded-3 mb-1" style="font-size: 0.85rem;">{{ $petugas->kondisi_lapangan }}</div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6 d-flex flex-column justify-content-between">
                            <span class="text-secondary fw-semibold mb-2 d-block">Peta Lokasi Laporan</span>
                            <div id="detail-map" style="height: 220px; border-radius: 12px; border: 1px solid #e2e8f0; width: 100%;"></div>
                        </div>
                    </div>

                    <!-- Row 2: Bukti Laporan & Deskripsi Laporan -->
                    <div class="row g-4 align-items-stretch mb-5">
                        <div class="col-md-6 d-flex flex-column">
                            <span class="text-secondary fw-semibold mb-2 d-block">Lampiran Bukti Laporan</span>
                            <div class="media-preview-box flex-grow-1">
                                @if($laporan->bukti_laporan)
                                    @php
                                        $ext = pathinfo($laporan->bukti_laporan, PATHINFO_EXTENSION);
                                        $isVideo = in_array(strtolower($ext), ['mp4', 'mov', 'avi', 'mkv', 'webm']);
                                    @endphp

                                    @if($isVideo)
                                        <video id="buktiLaporanVideo" controls class="rounded-3" style="max-width: 100%; max-height: 200px; cursor: pointer; object-fit: cover;">
                                            <source src="{{ asset('storage/' . $laporan->bukti_laporan) }}" type="video/{{ $ext }}">
                                            Browser tidak mendukung video.
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $laporan->bukti_laporan) }}" alt="Bukti Laporan" class="rounded-3" style="max-width: 100%; max-height: 200px; object-fit: cover; cursor: pointer;" id="buktiLaporanImg">
                                    @endif
                                @else
                                    <div class="text-muted small">Tidak ada bukti lampiran</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-column">
                            <span class="text-secondary fw-semibold mb-2 d-block">Deskripsi Laporan</span>
                            <div class="bg-light p-3 rounded-3 border flex-grow-1" style="font-size: 0.95rem; line-height: 1.6; color: #334155; min-height: 200px;">
                                {{ $laporan->deskripsi_laporan ?: $laporan->deskripsi }}
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Status Timeline -->
                    <div class="row mb-5">
                        <div class="col-12 overflow-x-auto">
                            <div class="status-timeline d-flex justify-content-between align-items-center position-relative">
                                <div class="timeline-line"></div>
                                <div class="timeline-item {{ in_array($laporan->status, ['diajukan', 'diverifikasi', 'diterima', 'ditindaklanjuti', 'ditanggapi', 'selesai']) ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="bi bi-pencil-fill"></i></span>
                                    <span class="timeline-title">Tulis Laporan</span>
                                </div>
                                <div class="timeline-item {{ in_array($laporan->status, ['diverifikasi', 'diterima', 'ditindaklanjuti', 'ditanggapi', 'selesai']) ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="bi bi-check-circle-fill"></i></span>
                                    <span class="timeline-title">Proses Verifikasi</span>
                                </div>
                                <div class="timeline-item {{ in_array($laporan->status, ['ditindaklanjuti', 'ditanggapi', 'selesai']) ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="bi bi-gear-fill"></i></span>
                                    <span class="timeline-title">Proses Tindak Lanjut</span>
                                </div>
                                <div class="timeline-item {{ in_array($laporan->status, ['ditanggapi', 'selesai']) ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="bi bi-chat-text-fill"></i></span>
                                    <span class="timeline-title">Beri Tanggapan</span>
                                </div>
                                <div class="timeline-item {{ $laporan->status == 'selesai' ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="bi bi-check-all"></i></span>
                                    <span class="timeline-title">Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Ubah Status Button -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <button id="btnUbahStatus" class="btn btn-change-status">Simpan Perubahan Status</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk preview gambar/video besar -->
<div id="buktiModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.8); align-items:center; justify-content:center;">
    <div style="position:relative; display:flex; align-items:center; justify-content:center; height:100vh;">
        @if(isset($isVideo) && $isVideo)
            <video controls autoplay style="max-width:80vw; max-height:80vh; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.5);">
                <source src="{{ asset('storage/' . $laporan->bukti_laporan) }}" type="video/{{ $ext }}">
                Browser tidak mendukung video.
            </video>
        @elseif(isset($ext))
            <img src="{{ asset('storage/' . $laporan->bukti_laporan) }}" alt="Bukti Laporan Besar" style="max-width:80vw; max-height:80vh; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.5);">
        @endif

        <button id="closeBuktiModal" style="position:absolute; top:20px; right:20px; background:#ef4444; color:#fff; border:none; border-radius:50%; width:40px; height:40px; font-size:22px; font-weight:bold; cursor:pointer; display:flex; align-items:center; justify-content:center;">&times;</button>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Leaflet JS for Map -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview Modal Logic
            var img = document.getElementById('buktiLaporanImg');
            var video = document.getElementById('buktiLaporanVideo');
            var modal = document.getElementById('buktiModal');
            var closeBtn = document.getElementById('closeBuktiModal');

            if (modal && closeBtn) {
                if (img) {
                    img.addEventListener('click', function() {
                        modal.style.display = 'flex';
                    });
                }
                if (video) {
                    video.addEventListener('click', function() {
                        modal.style.display = 'flex';
                    });
                }
                closeBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) modal.style.display = 'none';
                });
            }

            // Ubah Status Alert
            document.getElementById('btnUbahStatus').addEventListener('click', function() {
                const statusSelect = document.getElementById('statusSelect');
                const statusText = statusSelect.options[statusSelect.selectedIndex].text;
                if(confirm('Apakah Anda yakin ingin mengubah status laporan menjadi: ' + statusText + '?')) {
                    document.getElementById('statusForm').submit();
                }
            });

            // Map Rendering Logic
            let latA = null, lngA = null, latB = null, lngB = null;

            // Parse lokasi awal
            let locA = "{{ $laporan->lokasi_awal }}";
            if (locA) {
                let parts = locA.split(',');
                if (parts.length === 2) {
                    latA = parseFloat(parts[0]);
                    lngA = parseFloat(parts[1]);
                }
            }

            // Parse lokasi akhir
            let locB = "{{ $laporan->lokasi_akhir }}";
            if (locB) {
                let parts = locB.split(',');
                if (parts.length === 2) {
                    latB = parseFloat(parts[0]);
                    lngB = parseFloat(parts[1]);
                }
            }

            // Fallback: Check lokasi original jika tidak ada lokasi_awal
            if (!latA && !lngA) {
                let locOrig = "{{ $laporan->lokasi }}";
                if (locOrig) {
                    let parts = locOrig.split(',');
                    if (parts.length === 2) {
                        latA = parseFloat(parts[0]);
                        lngA = parseFloat(parts[1]);
                    }
                }
            }

            // Render Map jika ada koordinat
            if ((latA && !isNaN(latA)) || (latB && !isNaN(latB))) {
                let centerLat = latA || latB;
                let centerLng = lngA || lngB;
                
                const map = L.map('detail-map', {
                    scrollWheelZoom: false
                }).setView([centerLat, centerLng], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                let points = [];

                if (latA && lngA) {
                    L.marker([latA, lngA]).addTo(map).bindPopup("<strong>Titik Awal Aduan</strong>");
                    points.push([latA, lngA]);
                }

                if (latB && lngB) {
                    L.marker([latB, lngB]).addTo(map).bindPopup("<strong>Titik Akhir Aduan</strong>");
                    points.push([latB, lngB]);
                }

                if (points.length === 2) {
                    L.polyline(points, { color: '#2563eb', weight: 4 }).addTo(map);
                    map.fitBounds(points, { padding: [20, 20] });
                }
            } else {
                // Tampilkan placeholder jika bukan koordinat
                document.getElementById('detail-map').outerHTML = `
                    <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 220px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        <div class="text-center p-3">
                            <i class="bi bi-geo-alt-fill text-secondary fs-3 mb-2"></i>
                            <p class="mb-0 small fw-semibold">Peta tidak dapat dimuat</p>
                            <span class="small text-muted" style="font-size: 0.8rem; display: block; max-width: 280px; margin-top: 4px;">Alamat: <strong>{{ $laporan->lokasi ?: ($laporan->lokasi_awal ?: '-') }}</strong></span>
                        </div>
                    </div>
                `;
            }
        });
    </script>
@endsection
