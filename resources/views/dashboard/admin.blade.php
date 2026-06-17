@extends('layouts.adminlayout')

@section('title', 'Dashboard Admin - LaporPak')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection

@php
    // Fallback/Default data jika Controller belum mengirim data zona kerawanan
    if (!isset($zonaKerawanan)) {
        $zonaKerawanan = [
            'BdgWtn' => ['count' => 3, 'label' => 'Sedang', 'color' => '#d97706', 'bg_color' => '#fef3c7'],
            'Coblong' => ['count' => 8, 'label' => 'Tinggi', 'color' => '#dc2626', 'bg_color' => '#fee2e2'],
            'Lengkong' => ['count' => 5, 'label' => 'Tinggi', 'color' => '#dc2626', 'bg_color' => '#fee2e2'],
            'Buahbatu' => ['count' => 2, 'label' => 'Rendah', 'color' => '#16a34a', 'bg_color' => '#dcfce7'],
            'Kiacon' => ['count' => 6, 'label' => 'Tinggi', 'color' => '#dc2626', 'bg_color' => '#fee2e2']
        ];
    }

    // 1. Urutkan zona dari jumlah laporan terbanyak ke terendah secara descending
    uasort($zonaKerawanan, function($a, $b) {
        return $b['count'] <=> $a['count'];
    });

    // 2. Tentukan rekomendasi zona secara dinamis berdasarkan data peringkat pertama
    if (!isset($rekomendasiZona)) {
        $firstZoneKey = array_key_first($zonaKerawanan);
        $rekomendasiZonaName = $firstZoneKey === 'BdgWtn' ? 'Bandung Wetan' : ($firstZoneKey === 'Kiacon' ? 'Kiaracondong' : $firstZoneKey);
        $rekomendasiZona = $rekomendasiZonaName;
    }
@endphp

@section('content')
<style>
    /* Status Card Styling */
    .status-card {
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .status-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .status-title {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }
    .status-count {
        font-size: 1.8rem;
        font-weight: 700;
        margin-top: 8px;
        margin-bottom: 0;
    }

    /* Keterangan Zona (Legend) Styling */
    .legend-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        height: 260px; /* Disesuaikan agar proporsional */
        overflow-y: auto;
        padding-right: 8px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        border-radius: 8px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    .legend-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
    }
    .legend-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .legend-count {
        font-size: 0.9rem;
        font-weight: 700;
    }
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }

    /* Card styling overrides */
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
    .card-subtitle-custom {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 4px;
        margin-bottom: 0;
    }
    #mini-map {
        height: 380px; /* Disesuaikan agar sejajar dengan tinggi konten kiri */
        width: 100%;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        z-index: 1;
    }

    /* Scrollbar for legend */
    .legend-container::-webkit-scrollbar {
        width: 6px;
    }
    .legend-container::-webkit-scrollbar-track {
        background: #f1f1f1; 
        border-radius: 4px;
    }
    .legend-container::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 4px;
    }
    .legend-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; 
    }
</style>

<div class="container-fluid px-0">
    <div class="mb-4">
        <h4 class="fw-bold text-dark" style="font-size: 1.5rem;">Dashboard Admin</h4>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Ikhtisar data laporan aduan infrastruktur dan peta lokasi aduan masuk.</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="status-card" style="border-left: 4px solid #64748b; background: #f1f5f9; color: #475569;">
                <span class="status-title" style="color: #64748b;">Diajukan</span>
                <h3 class="status-count">{{ $statusLaporan['diajukan'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="status-card" style="border-left: 4px solid #0891b2; background: #ecfeff; color: #0891b2;">
                <span class="status-title" style="color: #0891b2;">Diverifikasi</span>
                <h3 class="status-count">{{ $statusLaporan['diverifikasi'] }}</h3>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="status-card" style="border-left: 4px solid #dc2626; background: #fef2f2; color: #dc2626;">
                <span class="status-title" style="color: #dc2626;">Ditolak</span>
                <h3 class="status-count">{{ $statusLaporan['ditolak'] }}</h3>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="status-card" style="border-left: 4px solid #d97706; background: #fffbeb; color: #d97706;">
                <span class="status-title" style="color: #d97706;">Ditindaklanjuti</span>
                <h3 class="status-count">{{ $statusLaporan['ditindaklanjuti'] }}</h3>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="status-card" style="border-left: 4px solid #16a34a; background: #f0fdf4; color: #16a34a;">
                <span class="status-title" style="color: #16a34a;">Selesai</span>
                <h3 class="status-count">{{ $statusLaporan['selesai'] }}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card custom-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">Zona Kerawanan & Pemetaan Lokasi</h5>
                    <p class="card-subtitle-custom">Distribusi aduan wilayah (terbanyak ke terendah) dan peta sebaran koordinat laporan masuk.</p>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-end">
                        
                        <div class="col-md-5 mb-3 mb-md-0">
                            <h6 class="mb-3 fw-bold" style="font-size: 0.9rem; color: #475569;">Total Aduan per Zona</h6>
                            <div class="legend-container">
                                @foreach ($zonaKerawanan as $name => $zVal)
                                    @php
                                        // Menyesuaikan nama zona agar lebih enak dibaca
                                        $displayName = $name === 'BdgWtn' ? 'Bandung Wetan' : ($name === 'Kiacon' ? 'Kiaracondong' : $name);
                                    @endphp
                                    <div class="legend-item">
                                        <span class="legend-name">{{ $displayName }}</span>
                                        <div class="legend-indicator">
                                            <span class="legend-count" style="color: {{ $zVal['color'] }};">{{ $zVal['count'] }} Laporan</span>
                                            <span class="legend-dot" style="background-color: {{ $zVal['color'] }};" title="{{ $zVal['label'] }}"></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3 pt-3 border-top" style="font-size: 0.8rem; color: #64748b;">
                                <span class="fw-bold d-block mb-1">Indikator Tingkat Kerawanan:</span>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="legend-dot" style="background-color: #dc2626; width: 10px; height: 10px;"></span> 
                                    <span><strong>T</strong>inggi (Warna Merah)</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="legend-dot" style="background-color: #d97706; width: 10px; height: 10px;"></span> 
                                    <span><strong>S</strong>edang (Warna Oranye)</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="legend-dot" style="background-color: #16a34a; width: 10px; height: 10px;"></span> 
                                    <span><strong>R</strong>endah (Warna Hijau)</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div id="mini-map"></div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded-3 d-flex align-items-center gap-2" style="background-color: #f8fafc; border: 1px dashed #e2e8f0; font-size: 0.9rem; color: #475569;">
                        <span>💡</span>
                        <span>Zona <strong>{{ $rekomendasiZona }}</strong> mendominasi aduan jalan rusak saat ini. Rekomendasi Pioritas Perbaikan Jalan.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card custom-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">Laporan Terbaru</h5>
                    <p class="card-subtitle-custom">Laporan aduan yang baru saja masuk</p>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                            <thead>
                                <tr class="text-muted" style="font-size: 0.8rem; text-transform: uppercase;">
                                    <th>No. Laporan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporanTerbaru as $laporan)
                                <tr>
                                    <td class="fw-semibold text-dark">{{ $laporan->nomor_laporan }}</td>
                                    <td>
                                        @php
                                            $badgeStyle = 'background: #f1f5f9; color: #475569;'; // default
                                            $statusLower = strtolower($laporan->status);
                                            if ($statusLower === 'diajukan') $badgeStyle = 'background: #f1f5f9; color: #475569;';
                                            elseif ($statusLower === 'diverifikasi') $badgeStyle = 'background: #ecfeff; color: #0891b2;';
                                            elseif ($statusLower === 'diterima') $badgeStyle = 'background: #eff6ff; color: #2563eb;';
                                            elseif ($statusLower === 'ditolak') $badgeStyle = 'background: #fef2f2; color: #dc2626;';
                                            elseif ($statusLower === 'ditindaklanjuti') $badgeStyle = 'background: #fffbeb; color: #d97706;';
                                            elseif ($statusLower === 'ditanggapi') $badgeStyle = 'background: #faf5ff; color: #7c3aed;';
                                            elseif ($statusLower === 'selesai') $badgeStyle = 'background: #f0fdf4; color: #16a34a;';
                                        @endphp
                                        <span class="badge rounded-pill px-2 py-1 font-weight-500" style="{{ $badgeStyle }}">
                                            {{ ucfirst($laporan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.laporan.detail', $laporan->nomor_laporan) }}" class="btn btn-sm btn-light border-0 fw-semibold" style="background: rgba(37, 99, 235, 0.08); color: #2563eb; transition: all 0.2s;">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi peta mini di Bandung
            const map = L.map('mini-map', {
                zoomControl: false,
                scrollWheelZoom: false
            }).setView([-6.918, 107.636], 12);

            // OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 18,
            }).addTo(map);

            // Tambahkan zoom control di kanan atas agar rapi
            L.control.zoom({
                position: 'topright'
            }).addTo(map);

            // Data Zona dari PHP fallback
            const zonesData = @json($zonaKerawanan);

            // Koordinat Kecamatan Bandung (Visual Zona)
            const coords = {
                'Coblong': [-6.8884, 107.6191],
                'BdgWtn': [-6.9034, 107.6187],
                'Lengkong': [-6.9328, 107.6231],
                'Buahbatu': [-6.9497, 107.6601],
                'Kiacon': [-6.9298, 107.6441]
            };

            // Loop untuk menggambar marker kerawanan administratif
            Object.keys(coords).forEach(key => {
                const coord = coords[key];
                const data = zonesData[key];
                
                if (data) {
                    const marker = L.circleMarker(coord, {
                        radius: 8 + (data.count * 2.5),
                        fillColor: data.color,
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.6
                    }).addTo(map);

                    const fullName = key === 'BdgWtn' ? 'Bandung Wetan' : (key === 'Kiacon' ? 'Kiaracondong' : key);
                    const tooltipContent = `
                        <div style="font-family: 'Poppins', sans-serif; font-size: 11px; padding: 2px;">
                            <strong>Kec. ${fullName}</strong><br>
                            <span style="color: ${data.color}; font-weight: 700;">${data.count} Aduan (${data.label})</span>
                        </div>
                    `;
                    
                    marker.bindTooltip(tooltipContent, {
                        direction: 'top',
                        className: 'custom-tooltip'
                    });
                    
                    marker.on('mouseover', function() {
                        this.openTooltip();
                    });
                }
            });

            // PEMETAAN AKTUAL: Menggambar koordinat real-time dari data laporan terbaru
            const recentReports = @json($laporanTerbaru);
            
            recentReports.forEach(laporan => {
                if (laporan.lokasi) {
                    const parts = laporan.lokasi.split(',');
                    if (parts.length === 2) {
                        const lat = parseFloat(parts[0]);
                        const lng = parseFloat(parts[1]);
                        
                        if (!isNaN(lat) && !isNaN(lng)) {
                            // Gambar pin marker standar Leaflet untuk lokasi riil
                            const pinMarker = L.marker([lat, lng]).addTo(map);
                            
                            // Pop-up berisi nomor laporan dan tombol arah detail
                            const detailUrl = "{{ route('admin.laporan.detail', ':id') }}".replace(':id', laporan.nomor_laporan);
                            
                            pinMarker.bindPopup(`
                                <div style="font-family: 'Poppins', sans-serif; font-size: 11px; min-width: 140px; padding: 2px;">
                                    <strong style="color: #1e293b;">No. Laporan:</strong><br>
                                    <span style="color: #2563eb; font-weight: 600;">${laporan.nomor_laporan}</span><br>
                                    <strong style="color: #1e293b;">Status:</strong> ${laporan.status}<br>
                                    <a href="${detailUrl}" style="display: inline-block; margin-top: 6px; color: #fff; background-color: #2563eb; padding: 3px 8px; border-radius: 4px; text-decoration: none; font-weight: 600;">Lihat Detail &rarr;</a>
                                </div>
                            `);
                        }
                    }
                }
            });
        });
    </script>
@endsection