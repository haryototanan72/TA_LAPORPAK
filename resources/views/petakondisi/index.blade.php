<!DOCTYPE html>
<html>
<head>
    <title>Peta Kondisi Jalan - LaporPak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        #map { height: 100vh; width: 100%; }
        .legend {
            background: white;
            padding: 15px;
            line-height: 22px;
            font-size: 13px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            border: 1px solid #eee;
            color: #333;
        }
        .legend i {
            width: 24px;
            height: 6px;
            float: left;
            margin-top: 8px;
            margin-right: 8px;
            opacity: 0.9;
            border-radius: 3px;
        }
        .back-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 24px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(255, 140, 66, 0.3);
            z-index: 1000;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
        }
        .back-btn:hover {
            background: linear-gradient(90deg, #ff3c3c 0%, #ff8c42 100%);
            box-shadow: 0 6px 14px rgba(255, 140, 66, 0.4);
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <!-- Tombol Back -->
    <a href="{{ url()->previous() }}" class="back-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short mr-1" viewBox="0 0 16 16" style="vertical-align: middle;">
            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
        </svg>
        Kembali
    </a>

    <div id="map"></div>

    {{-- DEBUG: tampilkan isi $data yang dikirim ke view jika diperlukan untuk testing --}}
    {{-- <pre style="position: absolute; bottom: 10px; left: 10px; z-index: 999; max-height: 200px; overflow: auto; background: rgba(255,255,255,0.8);">{{ print_r($data, true) }}</pre> --}}

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const data = @json($data);

        // Set awal ke Bandung
        const map = L.map('map').setView([-6.914744, 107.609810], 12);

        // Tambahkan tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18,
        }).addTo(map);

        // Tambahkan penanda rute jalan ke peta
        data.forEach((item, index) => {
            if (!item.lokasi_awal || !item.lokasi_akhir) return; // skip jika lokasi kosong/null
            
            let [latA, lngA] = item.lokasi_awal.split(',').map(Number);
            let [latB, lngB] = item.lokasi_akhir.split(',').map(Number);
            if (isNaN(latA) || isNaN(lngA) || isNaN(latB) || isNaN(lngB)) return; // skip jika koordinat tidak valid

            let color = '';
            let statusText = item.status ? item.status.toLowerCase() : '';
            if (statusText === 'selesai' || statusText === 'sudah diperbaiki') {
                color = '#2ecc71'; // Green
            } else if (statusText === 'ditindaklanjuti' || statusText === 'dalam proses' || statusText === 'proses') {
                color = '#f39c12'; // Orange
            } else {
                color = '#e74c3c'; // Red
            }

            // 1. Gambar garis lurus terlebih dahulu sebagai fallback instan
            let polyline = L.polyline([[latA, lngA], [latB, lngB]], {
                color: color,
                weight: 6,
                opacity: 0.8,
                lineJoin: 'round',
                className: 'damage-line'
            }).addTo(map);

            // 2. Gambar titik penanda awal & akhir yang kecil
            let startMarker = L.circleMarker([latA, lngA], {
                radius: 5,
                fillColor: '#ffffff',
                color: color,
                weight: 2.5,
                fillOpacity: 1
            }).addTo(map);

            let endMarker = L.circleMarker([latB, lngB], {
                radius: 5,
                fillColor: '#ffffff',
                color: color,
                weight: 2.5,
                fillOpacity: 1
            }).addTo(map);

            // Konten popup informasi kerusakan
            const popupContent = `
                <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; min-width: 200px; padding: 4px;">
                    <h4 style="margin: 0 0 6px 0; color: #333; font-size: 14px; border-bottom: 1.5px solid #eee; padding-bottom: 6px; font-weight: bold;">
                        ${item.kategori || 'Detail Laporan'}
                    </h4>
                    <div style="font-size: 12px; color: #555; line-height: 1.5;">
                        <strong>Nomor:</strong> ${item.nomor_laporan || '-'}<br>
                        <strong>Status:</strong> <span style="background-color: ${color}; color: #fff; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; display: inline-block; margin-top: 2px;">${item.status || 'Diajukan'}</span><br>
                        <div style="margin-top: 6px; border-top: 1px dashed #eee; padding-top: 4px;">
                            <strong>Deskripsi:</strong><br>
                            <span style="color: #666; font-style: italic;">${item.deskripsi || '-'}</span>
                        </div>
                    </div>
                </div>
            `;
            
            polyline.bindPopup(popupContent);
            startMarker.bindPopup(popupContent);
            endMarker.bindPopup(popupContent);

            // Interaksi hover pada garis jalan
            polyline.on('mouseover', function() {
                this.setStyle({ weight: 9, opacity: 1.0 });
            });
            polyline.on('mouseout', function() {
                this.setStyle({ weight: 6, opacity: 0.8 });
            });

            // 3. Tarik rute jalan raya riil via OSRM API (diberikan jeda/offset 200ms per request untuk mencegah rate limit API)
            setTimeout(() => {
                const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${lngA},${latA};${lngB},${latB}?overview=full&geometries=geojson`;
                fetch(osrmUrl)
                    .then(res => res.json())
                    .then(routeData => {
                        if (routeData.code === 'Ok' && routeData.routes && routeData.routes.length > 0) {
                            const route = routeData.routes[0];
                            const routeCoords = route.geometry.coordinates.map(coord => [coord[1], coord[0]]);
                            polyline.setLatLngs(routeCoords);
                        }
                    })
                    .catch(err => {
                        console.warn('Gagal memproses routing OSRM untuk laporan #' + (item.nomor_laporan || index) + '. Menggunakan garis lurus.', err);
                    });
            }, index * 200);
        });

        // Legend
        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'legend');
            div.innerHTML += "<strong>Nilai Kondisi Jalan Nasional<br>Tahun 2025</strong><br><br>";
            div.innerHTML += '<i style="background:#e74c3c"></i>Sedang diajukan<br>';
            div.innerHTML += '<i style="background:#f39c12"></i>Dalam proses perbaikan<br>';
            div.innerHTML += '<i style="background:#2ecc71"></i>Sudah diperbaiki<br>';
            return div;
        };
        legend.addTo(map);
    </script>

</body>
</html>
