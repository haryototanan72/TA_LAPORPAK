<!DOCTYPE html>
<html>
<head>
    <title>Form Laporan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Leaflet CSS untuk OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- jQuery UI CSS untuk Autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <!-- JANGAN load JS di sini, load SEMUA JS DI PALING BAWAH sebelum </body> -->
    <style>
        /* Pastikan dropdown autocomplete selalu di depan map */
        .ui-autocomplete {
            z-index: 99999 !important;
            position: absolute !important;
            background: #fff;
            border: 1px solid #ddd;
        }

        /* Styling untuk button cancel dan submit */
        .btn-cancel {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
            border-color: #545b62;
            color: white;
        }

        .btn-submit {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
        }

        .btn-submit:hover {
            background-color: #0069d9;
            border-color: #0062cc;
            color: white;
        }
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #e0ecfc 0%, #f9f6e7 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 480px;
            margin: 40px auto;
            background: #fff;
            padding: 32px 24px 28px 24px;
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            position: relative;
        }

        .title {
            font-size: 2.1rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
            color: #222;
        }
        .subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 2.2rem;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 4px;
        }
        .form-control, select {
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            font-size: 1rem;
            padding: 10px 14px;
            margin-bottom: 2px;
        }
        .form-control:focus, select:focus {
            border-color: #f6b23e;
            box-shadow: 0 0 0 2px #ffe4b8;
        }
        textarea.form-control {
            min-height: 90px;
        }
        .form-check-label {
            font-size: 0.97rem;
            color: #444;
        }
        .form-check-input:checked {
            background-color: #f6b23e;
            border-color: #f6b23e;
        }
        .error-message {
            color: #e74c3c;
            font-size: 0.95rem;
            margin-top: 2px;
        }
        .required {
            color: #e74c3c;
            margin-left: 2px;
        }
        .optional {
            color: #aaa;
            font-style: italic;
        }
        .btn-lapor {
            background: linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%);
            color: #fff;
            font-size: 1.35rem;
            font-weight: 700;
            border: none;
            border-radius: 32px;
            box-shadow: 0 4px 18px 0 rgba(255, 140, 66, 0.15);
            padding: 12px 48px 12px 48px;
            margin: 0 auto 24px auto;
            display: block;
            transition: background 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .btn-lapor:hover, .btn-lapor:focus {
            background: linear-gradient(90deg, #ff3c3c 0%, #ff8c42 100%);
            box-shadow: 0 8px 32px 0 rgba(255, 140, 66, 0.18);
        }
        .btn-cancel {
            background: #fff;
            color: #ff8c42;
            border: 2px solid #ff8c42;
            border-radius: 8px;
            font-weight: 500;
            margin-right: 10px;
            transition: background 0.2s, color 0.2s;
        }
        .btn-cancel:hover {
            background: #ffe4b8;
            color: #d35400;
        }
        .btn-submit {
            background: #f6b23e;
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #e6a23c;
        }
        .alert-success, .alert-danger {
            font-size: 1rem;
            text-align: center;
            border-radius: 8px;
        }
        #map {
            height: 180px;
            width: 100%;
            margin-bottom: 16px;
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            overflow: hidden;
        }
        #map iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            justify-content: center;
            box-shadow: 0 2px 8px 0 rgba(255, 140, 66, 0.13);
            font-size: 1.4rem;
            margin-bottom: 18px;
            margin-right: 8px;
            transition: background 0.2s, box-shadow 0.2s;
        }
        .btn-back:hover, .btn-back:focus {
            background: linear-gradient(90deg, #ff3c3c 0%, #ff8c42 100%);
            color: #fff;
            box-shadow: 0 4px 16px 0 rgba(255, 140, 66, 0.18);
            text-decoration: none;
        }
        .btn-back svg {
            width: 22px;
            height: 22px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url()->previous() }}" class="btn-back" title="Kembali">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </a>
        <button type="button" class="btn-lapor" style="cursor:pointer;">LAPOR</button>
        <h1 class="title">LAYANAN PENGADUAN ONLINE</h1>
        <p class="subtitle">Laporkan segera saat Anda mempunyai informasi Jalan atau Jembatan Nasional Rusak</p>

        @if(session('nomor_laporan'))
            <div class="alert alert-success">
                Laporan berhasil dikirim! Nomor Laporan Anda adalah: <span class="font-weight-bold">{{ session('nomor_laporan') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
        <form id="laporanForm" enctype="multipart/form-data" style="margin-top:10px;" autocomplete="off" novalidate>
            @csrf
            <div class="form-group">
                <label for="kategori_laporan">Jenis Laporan <span class="required">*</span></label>
                <select class="form-control" id="jenis_laporan" name="jenis_laporan">
                    <option value="">Pilih Jenis Laporan</option>
                    <option value="Privat">Privat/Rahasia</option>
                    <option value="Publik">Publik</option>
                </select>
                <div id="jenis_laporan_error" class="error-message"></div>
            </div>

            {{-- <div class="form-group">
                <label for="bukti_laporan">Bukti Laporan <span class="required">*</span></label>
                <input type="file" class="form-control" id="bukti_laporan" name="bukti_laporan" accept=".jpg,.jpeg,.png,.mp4">
                <div id="bukti_laporan_error" class="error-message"></div>
            </div> --}}
            <div class="form-group">
                <label for="bukti_laporan">Bukti Laporan <span class="required">*</span></label>
                <input 
                    type="file" 
                    class="form-control" 
                    id="bukti_laporan" 
                    name="bukti_laporan"
                    accept="image/*,video/*" 
                    capture="environment"> <!-- ini memungkinkan kamera langsung terbuka di HP -->
                <div id="bukti_laporan_error" class="error-message"></div>
            </div>


            <div class="form-group">
                <label for="lokasi">Lokasi Laporan <span class="required">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="lokasi" placeholder="Cari alamat atau klik peta" autocomplete="off">
<input type="hidden" id="lokasi_hidden" name="lokasi" />
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="btn-lokasi-saya" title="Dapatkan Lokasi Saya">
                            <span class="d-none d-md-inline">Lokasi Saya</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                              <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="lokasi_error" class="error-message"></div>
                <div id="map" style="height: 200px;"></div>
            </div>

            <div class="form-group">
                <label for="ciri_khusus_lokasi">Ciri Khusus Lokasi <span class="optional">(Optional)</span></label>
                <input type="text" class="form-control" id="ciri_khusus_lokasi" name="ciri_khusus_lokasi">
            </div>

            <div class="form-group">
                <label for="kategori_laporan">Kategori Laporan <span class="required">*</span></label>
                <select class="form-control" id="kategori_laporan" name="kategori_laporan">
                    <option value="">Pilih Kategori</option>
                    <option value="Jalan Rusak">Jalan Rusak</option>
                    <option value="Jembatan Rusak">Jembatan Rusak</option>
                    <option value="Banjir">Banjir</option>
                </select>
                <div id="kategori_laporan_error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="deskripsi_laporan">Deskripsi Laporan <span class="required">*</span></label>
                <textarea class="form-control" id="deskripsi_laporan" name="deskripsi_laporan" rows="3"></textarea>
                <div id="deskripsi_laporan_error" class="error-message"></div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="ceklis" name="ceklis">
                    <label class="form-check-label" for="ceklis">
                        Laporan yang Saya Buat Benar dan dapat dipertanggungjawabkan <span class="required">*</span>
                    </label>
                </div>
                <div id="pernyataan_error" class="error-message"></div>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-submit">Kirim</button>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
        // --- LEAFLET + OSM + NOMINATIM + jQuery UI Autocomplete ---
        let map, marker;
        $(document).ready(function() {
            // Inisialisasi map
            map = L.map('map').setView([-6.9032739, 107.5731165], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: ' OpenStreetMap contributors'
            }).addTo(map);
            marker = L.marker([-6.9032739, 107.5731165], {draggable: true}).addTo(map);

// Event klik di peta
map.on('click', function(e) {
    marker.setLatLng(e.latlng);
    $('#lokasi_hidden').val(e.latlng.lat + ',' + e.latlng.lng);
$('#preview_koordinat').text('Koordinat: ' + e.latlng.lat + ',' + e.latlng.lng);
});
// Event drag marker
marker.on('dragend', function(e) {
    var pos = marker.getLatLng();
    $('#lokasi_hidden').val(pos.lat + ',' + pos.lng);
$('#preview_koordinat').text('Koordinat: ' + pos.lat + ',' + pos.lng);
});

            // Autocomplete lokasi dengan jQuery UI + Nominatim
            $('#lokasi').autocomplete({
    minLength: 2,
    source: function(request, response) {
        $.ajax({
            url: 'https://nominatim.openstreetmap.org/search',
            data: {
                q: request.term,
                format: 'json',
                addressdetails: 1,
                limit: 5
            },
            success: function(data) {
                response($.map(data, function(item) {
                    return {
                        label: item.display_name,
                        value: item.display_name,
                        lat: item.lat,
                        lon: item.lon
                    };
                }));
            },
            error: function(xhr, status, error) {
                console.log('Nominatim error:', error);
                response([]);
            }
        });
    },
    select: function(event, ui) {
        var latlng = [parseFloat(ui.item.lat), parseFloat(ui.item.lon)];
        marker.setLatLng(latlng);
        map.setView(latlng, 16);
        // Set hidden koordinat
        $('#lokasi_hidden').val(latlng.join(','));
$('#preview_koordinat').text('Koordinat: ' + latlng.join(','));
    }
});

// Jika user mengetik dan tekan Enter di kolom lokasi, lakukan pencarian Nominatim otomatis
$('#lokasi').on('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        var query = $(this).val();
        if (query.length < 2) return;
        $.ajax({
            url: 'https://nominatim.openstreetmap.org/search',
            data: {
                q: query,
                format: 'json',
                addressdetails: 1,
                limit: 1
            },
            success: function(data) {
                if (data && data.length > 0) {
                    var lat = parseFloat(data[0].lat);
                    var lon = parseFloat(data[0].lon);
                    marker.setLatLng([lat, lon]);
                    map.setView([lat, lon], 16);
                    $('#lokasi_hidden').val(lat + ',' + lon);
$('#preview_koordinat').text('Koordinat: ' + lat + ',' + lon);
                } else {
                    $('#lokasi_error').text('Lokasi tidak ditemukan, coba nama jalan/lokasi lain.');
                }
            },
            error: function() {
                $('#lokasi_error').text('Terjadi kesalahan saat mencari lokasi.');
            }
        });
    }
});

            // Jika field lokasi diisi manual koordinat
            $('#lokasi').on('change', function() {
                var val = $(this).val();
                var coordMatch = val.match(/^(-?\d+\.\d+),\s*(-?\d+\.\d+)$/);
                if (coordMatch) {
                    var lat = parseFloat(coordMatch[1]);
                    var lng = parseFloat(coordMatch[2]);
                    var latlng = [lat, lng];
                    marker.setLatLng(latlng);
                    map.setView(latlng, 16);
                    // Reverse geocoding ke alamat
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.display_name) {
                                $('#lokasi').val(data.display_name);
                            }
                        });
                }
            });

            // Fitur Lokasi Saya
            $('#btn-lokasi-saya').on('click', function() {
                let btn = $(this);
                let oldText = btn.html();
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Mengambil...');
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        var latlng = [lat, lng];
                        marker.setLatLng(latlng);
                        map.setView(latlng, 16);
                        // Reverse geocoding ke alamat
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                        .then(res => res.json())
                        .then(data => {
                            $('#lokasi').val(data.display_name || (lat + ', ' + lng));
                            // Set hidden koordinat
                            $('#lokasi_hidden').val(lat + ',' + lng);
                    $('#preview_koordinat').text('Koordinat: ' + lat + ',' + lng);
                        });
                        btn.prop('disabled', false).html(oldText);
                    }, function(error) {
                        btn.prop('disabled', false).html(oldText);
                    }, { enableHighAccuracy: true, maximumAge: 0, timeout: 20000 });
                } else {
                    btn.prop('disabled', false).html(oldText);
                }
            });

                // Hilangkan required HTML agar browser tidak pakai pesan default
                $('#jenis_laporan').removeAttr('required');
                $('#bukti_laporan').removeAttr('required');
                $('#lokasi').removeAttr('required');
                $('#kategori_laporan').removeAttr('required');
                $('#deskripsi_laporan').removeAttr('required');
                $('#ceklis').removeAttr('required');
                // --- Ambil lokasi otomatis saat user menambahkan bukti ---
                $('#bukti_laporan').on('click', function() {
                    // Saat user ingin menambahkan bukti, ambil lokasi saat ini juga
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;
                            var latlng = [lat, lng];

                            // Update marker & map
                            marker.setLatLng(latlng);
                            map.setView(latlng, 16);

                            // Reverse geocoding ke alamat (pakai Nominatim)
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                                .then(res => res.json())
                                .then(data => {
                                    $('#lokasi').val(data.display_name || (lat + ', ' + lng));
                                    $('#lokasi_hidden').val(lat + ',' + lng);
                                    $('#preview_koordinat').text('Koordinat: ' + lat + ',' + lng);
                                })
                                .catch(() => {
                                    $('#lokasi').val(lat + ', ' + lng);
                                    $('#lokasi_hidden').val(lat + ',' + lng);
                                });
                        }, function(error) {
                            console.warn('Gagal ambil lokasi:', error);
                            Swal.fire({
                                icon: 'warning',
                                title: 'Lokasi tidak dapat diambil',
                                text: 'Pastikan GPS aktif dan izinkan akses lokasi browser.',
                                confirmButtonColor: '#f6b23e'
                            });
                        }, { enableHighAccuracy: true, timeout: 15000 });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tidak Didukung',
                            text: 'Browser Anda tidak mendukung geolokasi.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });

                $('#laporanForm').submit(function(e) {
    e.preventDefault();

    var jenis_laporan = $('#jenis_laporan').val();
    var bukti_laporan = $('#bukti_laporan').val();
    // Ambil koordinat dari hidden input
    var lokasi = $('#lokasi_hidden').val();
    var kategori_laporan = $('#kategori_laporan').val();
    var deskripsi_laporan = $('#deskripsi_laporan').val();
    var ceklis = $('#ceklis').is(':checked');

    // Fallback: jika hidden koordinat belum terisi tapi marker sudah berpindah, ambil posisi marker
    if (!lokasi || !/^(-?\d+\.\d+),\s*(-?\d+\.\d+)$/.test(lokasi)) {
        if (typeof marker !== 'undefined') {
            var pos = marker.getLatLng();
            if (pos && pos.lat && pos.lng) {
                lokasi = pos.lat + ',' + pos.lng;
                $('#lokasi_hidden').val(lokasi);
            }
        }
    }

    // Validasi koordinat harus terisi
    if (!lokasi || !/^(-?\d+\.\d+),\s*(-?\d+\.\d+)$/.test(lokasi)) {
        $('#lokasi_error').text('Silakan pilih lokasi di peta atau autocomplete, lalu pastikan pin sudah muncul.');
        Swal.fire({icon:'error',title:'Peringatan',text:'Lokasi koordinat wajib diisi!'});
        return;
    } else {
        $('#lokasi_error').text('');
    }

                    $('.error-message').text('');

                    // Fungsi popup error universal
                    function showPopup(msg) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Peringatan',
                            text: msg,
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Tutup',
                            customClass: {
                                title: 'swal2-title',
                                popup: 'swal2-popup',
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    }

                    if (!bukti_laporan && !jenis_laporan && !lokasi && !kategori_laporan && !deskripsi_laporan && !ceklis) {
                        showPopup('Tidak Dapat Mengirimkan Laporan Kosong');
                        return false;
                    }
                    if (!bukti_laporan) {
                        $('#bukti_laporan_error').text('Lengkapi Bukti Kerusakan');
                        showPopup('Lengkapi Bukti Kerusakan');
                        return false;
                    }
                    if (!jenis_laporan || !lokasi || !kategori_laporan || !deskripsi_laporan) {
                        showPopup('Lengkapi Kolom yang Kosong');
                        if (!jenis_laporan) $('#jenis_laporan_error').text('Kolom wajib diisi');
                        if (!lokasi) $('#lokasi_error').text('Kolom wajib diisi');
                        if (!kategori_laporan) $('#kategori_laporan_error').text('Kolom wajib diisi');
                        if (!deskripsi_laporan) $('#deskripsi_laporan_error').text('Kolom wajib diisi');
                        return false;
                    }
                    if (!ceklis) {
                        $('#pernyataan_error').text('Ceklis Pernyataan');
                        showPopup('Ceklis Pernyataan');
                        return false;
                    }

                    var formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('submit.laporan') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Laporan berhasil dikirim! Nomor Laporan Anda adalah: ' + response.nomor_laporan,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            });
                            $('#laporanForm')[0].reset();
                            $('.error-message').text('');
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = '';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else {
                                errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                            }
                            showPopup(errorMessage);
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                var errors = xhr.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    $('#' + key + '_error').text(value[0]);
                                });
                            }
                        }
                    });
                });

                // Fitur Lokasi Saya
                let geoWatchId = null;
                $('#btn-lokasi-saya').on('click', function() {
                    let btn = $(this);
                    let oldText = btn.html();
                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Mengambil...');
                    if (navigator.geolocation) {
                        if (geoWatchId !== null) {
                            navigator.geolocation.clearWatch(geoWatchId);
                        }
                        geoWatchId = navigator.geolocation.getCurrentPosition(function(position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;
                            var latlng = { lat: lat, lng: lng };
                            // Reverse geocode ke alamat
                            geocoder.geocode({ location: latlng }, function(results, status) {
                                if (status === 'OK' && results[0]) {
                                    $('#lokasi').val(results[0].formatted_address);
                                } else {
                                    $('#lokasi').val(lat + ', ' + lng);
                                }
                            });
                            // Update map dan marker
                            map.setCenter(latlng);
                            map.setZoom(16);
                            marker.setPosition(latlng);
                            btn.prop('disabled', false).html(oldText);
                        }, function(error) {
                            btn.prop('disabled', false).html(oldText);
                        }, { enableHighAccuracy: true, maximumAge: 0, timeout: 20000 });
                    } else {
                        btn.prop('disabled', false).html(oldText);
                    }
                });

                // Update marker & map jika field lokasi diisi manual koordinat
                $('#lokasi').on('change', function() {
                    var val = $(this).val();
                    // Jika input berupa koordinat
                    var coordMatch = val.match(/^(-?\d+\.\d+),\s*(-?\d+\.\d+)$/);
                    if (coordMatch) {
                        var lat = parseFloat(coordMatch[1]);
                        var lng = parseFloat(coordMatch[2]);
                        var latlng = { lat: lat, lng: lng };
                        map.setCenter(latlng);
                        map.setZoom(16);
                        marker.setPosition(latlng);
                    }
                });
            });


        </script>

    </div>
</body>
</html>