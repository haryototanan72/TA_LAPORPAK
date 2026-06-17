<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan Pengaduan</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Leaflet CSS untuk OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- jQuery UI CSS untuk Autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <style>
        /* Pastikan dropdown autocomplete selalu di depan map */
        .ui-autocomplete {
            z-index: 99999 !important;
            position: absolute !important;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-height: 250px;
            overflow-y: auto;
        }
        .ui-menu-item {
            padding: 8px 12px;
            font-size: 0.9rem;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
        }
        .ui-menu-item:last-child {
            border-bottom: none;
        }
        .ui-state-active, .ui-widget-content .ui-state-active {
            border: none !important;
            background: #ff8c42 !important;
            color: #fff !important;
            border-radius: 4px;
        }
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #e0ecfc 0%, #f9f6e7 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            min-height: 100vh;
            background: #fff;
            padding: 30px;
            padding-bottom: 120px; /* Space for sticky submit button */
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-radius: 16px;
        }
        @media (max-width: 768px) {
            .container {
                max-width: 100%;
                padding: 20px;
                padding-bottom: 100px;
                border-radius: 0;
                box-shadow: none;
            }
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
            font-weight: 600;
            margin-bottom: 6px;
            color: #444;
        }
        .form-control, select {
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            font-size: 1rem;
            padding: 10px 14px;
            margin-bottom: 2px;
            height: auto;
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
        .form-check-input {
            margin-top: 5px;
        }
        .form-check-input:checked {
            background-color: #f6b23e;
            border-color: #f6b23e;
        }
        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 4px;
            font-weight: 500;
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
            padding: 12px 48px;
            margin: 0 auto 24px auto;
            display: block;
            transition: background 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .btn-lapor:hover, .btn-lapor:focus {
            background: linear-gradient(90deg, #ff3c3c 0%, #ff8c42 100%);
            box-shadow: 0 8px 32px 0 rgba(255, 140, 66, 0.18);
            color: #fff;
            text-decoration: none;
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
            padding: 12px;
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
            height: 320px;
            width: 100%;
            border-radius: 12px;
            margin-top: 16px;
            margin-bottom: 16px;
            border: 2.5px solid #fff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
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
        .sticky-submit {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 800px;
            background: white;
            padding: 16px 30px;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
            z-index: 1000;
            border-radius: 16px 16px 0 0;
        }
        @media (max-width: 768px) {
            .sticky-submit {
                max-width: 100%;
                padding: 12px 20px;
                border-radius: 0;
            }
        }
        /* Custom Upload Dropzone styling */
        .upload-dropzone {
            border: 2px dashed #f6b23e;
            background-color: rgba(246, 178, 62, 0.04);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .upload-dropzone:hover {
            background-color: rgba(246, 178, 62, 0.08);
            border-color: #ff8c42;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(246, 178, 62, 0.12);
        }
        .upload-icon-wrapper {
            color: #f6b23e;
            transition: transform 0.3s ease;
        }
        .upload-dropzone:hover .upload-icon-wrapper {
            transform: scale(1.1);
            color: #ff8c42;
        }
        .upload-preview {
            background: #fff;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1.5px solid #e0e0e0;
        }
        .preview-item {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .preview-media {
            flex-shrink: 0;
        }
        .preview-media img, .preview-media video {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }
        .preview-details {
            flex-grow: 1;
            min-width: 0;
            margin-left: 12px;
        }
        /* Custom Leaflet Pin Styling */
        .marker-pin {
            width: 32px;
            height: 32px;
            border-radius: 50% 50% 50% 0;
            position: absolute;
            transform: rotate(-45deg);
            left: 50%;
            top: 50%;
            margin: -16px 0 0 -16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.25);
            border: 2px solid white;
        }
        .marker-pin span {
            transform: rotate(45deg);
            display: inline-block;
        }
        .start-pin {
            background: #2ecc71; /* Green */
        }
        .end-pin {
            background: #e74c3c; /* Red */
        }
        
        /* Animated dash effect for Polyline connection */
        .path-route {
            stroke-dasharray: 8 6;
            animation: dash 25s linear infinite;
        }
        @keyframes dash {
            to {
                stroke-dashoffset: -1000;
            }
        }
        /* Pills selection styling */
        .nav-pills .nav-link {
            border: 1.5px solid #e0e0e0;
            color: #555;
            background-color: #fff;
            font-weight: 600;
            border-radius: 8px;
            margin: 0 4px;
            transition: all 0.2s ease;
        }
        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            background-color: #f6b23e;
            border-color: #f6b23e;
            color: #fff;
            box-shadow: 0 4px 10px rgba(246, 178, 62, 0.25);
        }
        .nav-pills .nav-link:hover:not(.active) {
            background-color: #f9f9f9;
            border-color: #f6b23e;
            color: #f6b23e;
        }
        .bg-light-orange {
            background-color: rgba(246, 178, 62, 0.06);
            border: 1px solid rgba(246, 178, 62, 0.15);
        }
        /* Live record button styles */
        .btn-live-record {
            background: linear-gradient(90deg, #2ecc71 0%, #27ae60 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.2);
            transition: all 0.3s ease;
            border: none;
            padding: 14px 24px;
        }
        .btn-live-record:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(46, 204, 113, 0.3);
        }
        .btn-live-record:focus {
            outline: none;
            color: #fff;
        }
        .btn-live-record.recording {
            background: linear-gradient(90deg, #e74c3c 0%, #c0392b 100%);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.25);
        }
        .btn-live-record.recording:hover {
            box-shadow: 0 6px 18px rgba(231, 76, 60, 0.35);
        }
        /* Glowing pulse animation for recording status */
        .record-pulse-icon {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #fff;
            display: inline-block;
            box-shadow: 0 0 0 rgba(255, 255, 255, 0.4);
        }
        .recording .record-pulse-icon {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }
        
        /* Spacing & input group design improvements */
        .form-group {
            margin-bottom: 1.25rem;
        }
        @media (max-width: 768px) {
            .form-row > .form-group:not(:last-child) {
                margin-bottom: 1.25rem;
            }
        }
        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .input-group .input-group-append .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            border: 1.5px solid #e0e0e0;
            border-left: none;
            background-color: #fff;
            color: #6c757d;
        }
        .input-group .input-group-append .btn:hover {
            background-color: #f8f9fa;
            color: #ff8c42;
        }
        
        /* Bottom Sheet / Action Sheet Modal Styling */
        @media (max-width: 576px) {
            .bottom-sheet-modal .modal-dialog {
                margin: 0;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                max-width: 100%;
                transform: translateY(100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .bottom-sheet-modal.show .modal-dialog {
                transform: translateY(0);
            }
            .bottom-sheet-modal .modal-content {
                border-radius: 20px 20px 0 0;
                padding-bottom: env(safe-area-inset-bottom);
            }
        }
        @media (min-width: 577px) {
            .bottom-sheet-modal .modal-content {
                border-radius: 16px;
            }
        }
        .btn-action-sheet {
            background: #f8fafc;
            color: #333;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 1.05rem;
            text-align: left;
            display: flex;
            align-items: center;
            width: 100%;
            transition: all 0.2s ease;
        }
        .btn-action-sheet:hover, .btn-action-sheet:focus {
            background: rgba(246, 178, 62, 0.08);
            border-color: #f6b23e;
            color: #ff8c42;
            outline: none;
            box-shadow: none;
            text-decoration: none;
        }
        .btn-action-sheet-cancel {
            background: #fff;
            color: #64748b;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 1.05rem;
            text-align: center;
            width: 100%;
            transition: all 0.2s ease;
        }
        .btn-action-sheet-cancel:hover {
            background: #f1f5f9;
            color: #334155;
            text-decoration: none;
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
                <label for="jenis_laporan">Jenis Laporan <span class="required">*</span></label>
                <select class="form-control" id="jenis_laporan" name="jenis_laporan">
                    <option value="">Pilih Jenis Laporan</option>
                    <option value="Privat">Privat/Rahasia</option>
                    <option value="Publik">Publik</option>
                </select>
                <div id="jenis_laporan_error" class="error-message"></div>
            </div>
            <!-- Custom Upload Box for Bukti Laporan -->
            <div class="form-group">
                <label for="bukti_laporan">Bukti Laporan <span class="required">*</span></label>
                <div id="upload-container" class="upload-dropzone">
                    <div class="upload-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.981 15 7.773c0-1.125-.97-2.164-2.43-2.164a.5.5 0 0 1-.49-.409C11.83 2.562 10.05 1 8 1 6.22 1 4.72 2.22 4.3 3.997a.5.5 0 0 1-.484.403C2.39 4.49 1 5.757 1 7.42 1 9.07 2.37 10 3.883 10H6a.5.5 0 0 1 0 1H3.883C1.91 11 0 9.29 0 7.42c0-1.636 1.4-2.88 3.167-3.136A5.51 5.51 0 0 1 4.406 1.342z"/>
                            <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L5.354 8.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                    </div>
                    <div class="upload-text mt-2">
                        <span class="font-weight-bold">Ketuk untuk Unggah Bukti</span>
                        <p class="text-muted small mb-0">Mendukung Foto (Gambar) & Video</p>
                    </div>
                    
                    <!-- Preview Container (hidden by default) -->
                    <div id="upload-preview" class="upload-preview d-none">
                        <div class="preview-item">
                            <div id="preview-media-container" class="preview-media"></div>
                            <div class="preview-details text-left">
                                <span id="preview-filename" class="font-weight-bold d-block text-truncate" style="max-width: 250px;">filename.jpg</span>
                                <span id="preview-filesize" class="text-muted small">0 KB</span>
                            </div>
                            <button type="button" id="btn-remove-file" class="btn btn-sm btn-danger ml-auto" title="Hapus Bukti">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Actual file input (hidden) -->
                <input type="file" id="bukti_laporan" name="bukti_laporan" accept="image/*,video/*" class="d-none">
                <div id="bukti_laporan_error" class="error-message"></div>
            </div>
            <!-- Bagian Lokasi Laporan -->
            <div class="form-group mb-0">
                <label>Metode Penentuan Lokasi <span class="required">*</span></label>
                
                <!-- Tab Pilihan Metode Lokasi -->
                <ul class="nav nav-pills nav-fill mb-3" id="lokasiTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="manual-tab" data-toggle="tab" href="#manual-lokasi" role="tab" aria-controls="manual-lokasi" aria-selected="true">
                            Cari / Geser Pin Manual
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="live-tab" data-toggle="tab" href="#live-lokasi" role="tab" aria-controls="live-lokasi" aria-selected="false">
                            Rekam Rute Live (GPS Bergerak)
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="lokasiTabContent">
                    <!-- Tab 1: Manual/Pin -->
                    <div class="tab-pane fade show active" id="manual-lokasi" role="tabpanel" aria-labelledby="manual-tab">
                        <div class="form-row">
                            <!-- Lokasi Awal -->
                            <div class="form-group col-md-6">
                                <label for="lokasi_awal">Lokasi Awal (Titik Mulai) <span class="required">*</span></label>
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="lokasi_awal" 
                                        name="lokasi_awal_alamat"
                                        placeholder="Cari lokasi awal atau seret pin A" 
                                        autocomplete="off"
                                    >
                                    <div class="input-group-append">
                                        <button 
                                            type="button" 
                                            id="btn-lokasi-saya-awal" 
                                            class="btn btn-outline-secondary d-flex align-items-center"
                                            title="Gunakan lokasi saya untuk titik mulai"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="lokasi_awal_hidden" name="lokasi_awal" />
                                <div id="lokasi_awal_error" class="error-message"></div>
                            </div>
                            <!-- Lokasi Akhir -->
                            <div class="form-group col-md-6">
                                <label for="lokasi_akhir">Lokasi Akhir (Titik Selesai) <span class="required">*</span></label>
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="lokasi_akhir" 
                                        name="lokasi_akhir_alamat"
                                        placeholder="Cari lokasi akhir atau seret pin B" 
                                        autocomplete="off"
                                    >
                                    <div class="input-group-append">
                                        <button 
                                            type="button" 
                                            id="btn-lokasi-saya-akhir" 
                                            class="btn btn-outline-secondary d-flex align-items-center"
                                            title="Gunakan lokasi saya untuk titik selesai"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="lokasi_akhir_hidden" name="lokasi_akhir" />
                                <div id="lokasi_akhir_error" class="error-message"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab 2: Live Tracking -->
                    <div class="tab-pane fade" id="live-lokasi" role="tabpanel" aria-labelledby="live-tab">
                        <div class="card p-3 border-0 bg-light-orange rounded-12 mb-3">
                            <div class="d-flex flex-column align-items-center text-center">
                                <p class="mb-3 text-muted" style="font-size: 0.95rem;">
                                    Tekan <strong>Mulai</strong> di titik awal kerusakan, lalu berjalan/berkendara ke titik selesai kerusakan dan tekan <strong>Stop</strong> untuk merekam rute Anda secara langsung.
                                </p>
                                <button type="button" id="btn-toggle-live-tracking" class="btn btn-live-record btn-lg w-100 rounded-32">
                                    <span class="d-flex align-items-center justify-content-center">
                                        <span class="record-pulse-icon mr-2"></span>
                                        <strong id="live-btn-text">Mulai Rekam Rute Live</strong>
                                    </span>
                                </button>
                                <div class="mt-2 font-weight-600 text-muted small" id="live-status-info">Status: Siap Merekam</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Hasil Rekam Titik Awal</label>
                                <input type="text" class="form-control bg-light" id="lokasi_awal_live" readonly placeholder="Menunggu perekaman...">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Hasil Rekam Titik Akhir</label>
                                <input type="text" class="form-control bg-light" id="lokasi_akhir_live" readonly placeholder="Menunggu perekaman...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Jarak/Panjang Kerusakan Badge -->
            <div id="jarak_container" class="alert alert-info mt-1 mb-2 d-none align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="mr-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 8a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                    </svg>
                    <span>Panjang Kerusakan Terdeteksi: <strong id="jarak_value">-</strong></span>
                </div>
            </div>
            <!-- Map area -->
            <div id="map"></div>
            <div class="form-group mt-4">
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
            <div class="sticky-submit">
                <button type="submit" class="btn btn-submit w-100">Kirim Laporan</button>
            </div>
        </form>
    </div>

    <!-- Modal Pilih Sumber Bukti (Bottom Sheet / Action Sheet) -->
    <div class="modal fade bottom-sheet-modal" id="pilihSumberModal" tabindex="-1" role="dialog" aria-labelledby="pilihSumberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold text-center w-100" id="pilihSumberModalLabel">Unggah Bukti Kerusakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-3 pb-4">
                    <p class="text-muted text-center small mb-4">Silakan pilih metode pengambilan gambar/video bukti kerusakan:</p>
                    <div class="d-flex flex-column">
                        <button type="button" id="btn-pilih-kamera" class="btn btn-action-sheet mb-2">
                            <span class="mr-3"></span> Ambil Foto Langsung
                        </button>
                        <button type="button" id="btn-pilih-video" class="btn btn-action-sheet mb-2">
                            <span class="mr-3"></span> Rekam Video Langsung (Max 30s)
                        </button>
                        <button type="button" id="btn-pilih-galeri" class="btn btn-action-sheet mb-2">
                            <span class="mr-3"></span> Buka Galeri (Foto & Video)
                        </button>
                        <button type="button" class="btn btn-action-sheet-cancel mt-3" data-dismiss="modal">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SCRIPTS LOADED AT THE BOTTOM -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // --- LEAFLET MAP + OSM NOMINATIM + OSRM ROUTING + LIVE TRACKING ---
        let map, markerA, markerB, polyline;
        let liveWatchId = null;
        let liveCoordinates = [];
        let wakeLock = null;
        let isLivePathActive = false;
        
        // Koordinat default (Bandung)
        const defaultCoordsA = [-6.9032739, 107.5731165];
        const defaultCoordsB = [-6.9042739, 107.5741165];
        $(document).ready(function() {
            // Inisialisasi map
            map = L.map('map').setView(defaultCoordsA, 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            // Icon kustom untuk Penanda Mulai (A) dan Selesai (B)
            const markerAIcon = L.divIcon({
                className: 'custom-marker-icon',
                html: `<div class="marker-pin start-pin"><span>A</span></div>`,
                iconSize: [32, 42],
                iconAnchor: [16, 42]
            });
            const markerBIcon = L.divIcon({
                className: 'custom-marker-icon',
                html: `<div class="marker-pin end-pin"><span>B</span></div>`,
                iconSize: [32, 42],
                iconAnchor: [16, 42]
            });
            // Tambah Marker A dan B
            markerA = L.marker(defaultCoordsA, {
                draggable: true,
                icon: markerAIcon,
                title: 'Titik Mulai (A)'
            }).addTo(map);
            markerB = L.marker(defaultCoordsB, {
                draggable: true,
                icon: markerBIcon,
                title: 'Titik Selesai (B)'
            }).addTo(map);
            // Set koordinat default pada input tersembunyi
            $('#lokasi_awal_hidden').val(defaultCoordsA.join(','));
            $('#lokasi_akhir_hidden').val(defaultCoordsB.join(','));
            // Tambah Polyline (Garis Penghubung)
            polyline = L.polyline([defaultCoordsA, defaultCoordsB], {
                color: '#ff8c42',
                weight: 4,
                opacity: 0.8,
                className: 'path-route'
            }).addTo(map);
            // Hitung rute awal
            updateRouteAndDistance();
            // --- EVENT DRAG MARKER ---
            markerA.on('dragend', function() {
                isLivePathActive = false;
                const pos = markerA.getLatLng();
                $('#lokasi_awal_hidden').val(pos.lat + ',' + pos.lng);
                updateRouteAndDistance();
                reverseGeocode(pos.lat, pos.lng, 'awal');
            });
            markerB.on('dragend', function() {
                isLivePathActive = false;
                const pos = markerB.getLatLng();
                $('#lokasi_akhir_hidden').val(pos.lat + ',' + pos.lng);
                updateRouteAndDistance();
                reverseGeocode(pos.lat, pos.lng, 'akhir');
            });
            // --- KLIK DI PETA ---
            map.on('click', function(e) {
                // Jangan izinkan klik peta saat rekam live sedang aktif
                if (liveWatchId !== null) return;
                
                isLivePathActive = false;
                const clickLatLng = e.latlng;
                const distToA = clickLatLng.distanceTo(markerA.getLatLng());
                const distToB = clickLatLng.distanceTo(markerB.getLatLng());
                
                if (distToA <= distToB) {
                    markerA.setLatLng(clickLatLng);
                    $('#lokasi_awal_hidden').val(clickLatLng.lat + ',' + clickLatLng.lng);
                    reverseGeocode(clickLatLng.lat, clickLatLng.lng, 'awal');
                } else {
                    markerB.setLatLng(clickLatLng);
                    $('#lokasi_akhir_hidden').val(clickLatLng.lat + ',' + clickLatLng.lng);
                    reverseGeocode(clickLatLng.lat, clickLatLng.lng, 'akhir');
                }
                updateRouteAndDistance();
            });
            // --- TABS SWITCH EVENTS ---
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                map.invalidateSize(); // recalibrate map layout inside tabs
                if (e.target.id === 'manual-tab') {
                    // Jika kembali ke manual, dan rute live tidak aktif, hitung ulang rute jalan OSRM
                    if (!isLivePathActive) {
                        updateRouteAndDistance();
                    } else {
                        adjustMapBoundsToRoute();
                    }
                } else if (e.target.id === 'live-tab') {
                    if (isLivePathActive) {
                        adjustMapBoundsToRoute();
                    }
                }
            });
            // --- LIVE TRACKING LOGIC ---
            $('#btn-toggle-live-tracking').on('click', function() {
                if (liveWatchId === null) {
                    startLiveTracking();
                } else {
                    stopLiveTracking();
                }
            });
            // --- AUTOCOMPLETE LOKASI (Nominatim OSM) ---
            setupAutocomplete('#lokasi_awal', 'awal');
            setupAutocomplete('#lokasi_akhir', 'akhir');
            // Handle Input manual (Koordinat)
            setupManualCoordInput('#lokasi_awal', 'awal');
            setupManualCoordInput('#lokasi_akhir', 'akhir');
            // --- TOMBOL LOKASI SAYA ---
            $('#btn-lokasi-saya-awal').on('click', function() {
                isLivePathActive = false;
                triggerGeolocation('awal');
            });
            $('#btn-lokasi-saya-akhir').on('click', function() {
                isLivePathActive = false;
                triggerGeolocation('akhir');
            });
            // --- CUSTOM BUKTI LAPORAN (BOTTOM SHEET CAM VS GALLERY) ---
            $('#upload-container').on('click', function(e) {
                if ($(e.target).closest('#btn-remove-file').length) return;
                $('#pilihSumberModal').modal('show');
            });

            // Handle Kamera Langsung (Foto)
            $('#btn-pilih-kamera').on('click', function() {
                $('#bukti_laporan').attr('accept', 'image/*');
                $('#bukti_laporan').attr('capture', 'environment');
                $('#bukti_laporan').removeAttr('maxduration');
                $('#bukti_laporan').click();
                $('#pilihSumberModal').modal('hide');
                
                // Otomatis get lokasi awal jika berada di tab manual dan live rekam sedang mati
                if (liveWatchId === null) {
                    triggerGeolocationSilently('awal');
                }
            });

            // Handle Rekam Video Langsung
            $('#btn-pilih-video').on('click', function() {
                $('#bukti_laporan').attr('accept', 'video/*');
                $('#bukti_laporan').attr('capture', 'environment');
                $('#bukti_laporan').attr('maxduration', '30');
                $('#bukti_laporan').click();
                $('#pilihSumberModal').modal('hide');
                
                // Otomatis get lokasi awal jika berada di tab manual dan live rekam sedang mati
                if (liveWatchId === null) {
                    triggerGeolocationSilently('awal');
                }
            });

            // Handle Buka Galeri
            $('#btn-pilih-galeri').on('click', function() {
                $('#bukti_laporan').attr('accept', 'image/*,video/*');
                $('#bukti_laporan').removeAttr('capture');
                $('#bukti_laporan').removeAttr('maxduration');
                $('#bukti_laporan').click();
                $('#pilihSumberModal').modal('hide');
                
                // Otomatis get lokasi awal jika berada di tab manual dan live rekam sedang mati
                if (liveWatchId === null) {
                    triggerGeolocationSilently('awal');
                }
            });
            // Handling preview bukti file
            $('#bukti_laporan').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const showPreview = function() {
                        $('#preview-filename').text(file.name);
                        
                        let sizeStr = (file.size / 1024).toFixed(1) + ' KB';
                        if (file.size > 1024 * 1024) {
                            sizeStr = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                        }
                        $('#preview-filesize').text(sizeStr);
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const mediaContainer = $('#preview-media-container');
                            mediaContainer.empty();
                            
                            if (file.type.startsWith('image/')) {
                                mediaContainer.html(`<img src="${e.target.result}" alt="Preview Bukti">`);
                            } else if (file.type.startsWith('video/')) {
                                mediaContainer.html(`<video src="${e.target.result}" muted autoplay loop style="max-height: 100%; object-fit: cover;"></video>`);
                            } else {
                                mediaContainer.html(`
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#f6b23e" class="bi bi-file-earmark" viewBox="0 0 16 16">
                                        <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                    </svg>
                                `);
                            }
                        };
                        reader.readAsDataURL(file);
                        
                        $('#upload-preview').removeClass('d-none');
                        $('.upload-icon-wrapper, .upload-text').addClass('d-none');
                        $('#bukti_laporan_error').text('');
                    };

                    if (file.type.startsWith('video/')) {
                        const videoEl = document.createElement('video');
                        videoEl.preload = 'metadata';
                        videoEl.onloadedmetadata = function() {
                            window.URL.revokeObjectURL(videoEl.src);
                            // Validasi durasi video maks 30 detik (tambahkan toleransi kecil 0.5s untuk metadata rounding)
                            if (videoEl.duration > 30.5) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Durasi Video Terlalu Lama',
                                    text: 'Durasi video bukti laporan maksimal adalah 30 detik. Silakan unggah/rekam video yang lebih singkat.',
                                    confirmButtonColor: '#ff8c42'
                                });
                                resetUploadPreview();
                            } else {
                                showPreview();
                            }
                        };
                        videoEl.src = URL.createObjectURL(file);
                    } else {
                        showPreview();
                    }
                } else {
                    resetUploadPreview();
                }
            });
            // Tombol Hapus Bukti
            $('#btn-remove-file').on('click', function(e) {
                e.stopPropagation();
                resetUploadPreview();
            });
            // --- SUBMIT FORM ---
            $('#laporanForm').submit(function(e) {
                e.preventDefault();
                var jenis_laporan = $('#jenis_laporan').val();
                var bukti_laporan = $('#bukti_laporan').val();
                var lokasi_awal = $('#lokasi_awal_hidden').val();
                var lokasi_akhir = $('#lokasi_akhir_hidden').val();
                var kategori_laporan = $('#kategori_laporan').val();
                var deskripsi_laporan = $('#deskripsi_laporan').val();
                var ceklis = $('#ceklis').is(':checked');
                $('.error-message').text('');
                let valid = true;
                function showPopup(msg) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Peringatan',
                        text: msg,
                        confirmButtonColor: '#ff8c42'
                    });
                }
                if (!bukti_laporan && !jenis_laporan && !lokasi_awal && !lokasi_akhir && !kategori_laporan && !deskripsi_laporan && !ceklis) {
                    showPopup('Tidak Dapat Mengirimkan Laporan Kosong');
                    return false;
                }
                if (!bukti_laporan) {
                    $('#bukti_laporan_error').text('Lengkapi Bukti Kerusakan');
                    showPopup('Lengkapi Bukti Kerusakan');
                    return false;
                }
                if (!jenis_laporan) {
                    $('#jenis_laporan_error').text('Jenis laporan wajib diisi');
                    valid = false;
                }
                if (!lokasi_awal) {
                    $('#lokasi_awal_error').text('Lokasi awal wajib diisi');
                    valid = false;
                }
                if (!lokasi_akhir) {
                    $('#lokasi_akhir_error').text('Lokasi akhir wajib diisi');
                    valid = false;
                }
                if (!kategori_laporan) {
                    $('#kategori_laporan_error').text('Kategori wajib diisi');
                    valid = false;
                }
                if (!deskripsi_laporan) {
                    $('#deskripsi_laporan_error').text('Deskripsi wajib diisi');
                    valid = false;
                }
                if (!valid) {
                    showPopup('Lengkapi Kolom yang Kosong');
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
                            confirmButtonColor: '#3085d6'
                        });
                        
                        // Reset Form & Elemen Kustom
                        $('#laporanForm')[0].reset();
                        resetUploadPreview();
                        $('.error-message').text('');
                        
                        // Reset Live Tracking inputs
                        $('#lokasi_awal_live').val('');
                        $('#lokasi_akhir_live').val('');
                        isLivePathActive = false;
                        
                        // Reset Map ke default
                        markerA.setLatLng(defaultCoordsA);
                        markerB.setLatLng(defaultCoordsB);
                        $('#lokasi_awal_hidden').val(defaultCoordsA.join(','));
                        $('#lokasi_akhir_hidden').val(defaultCoordsB.join(','));
                        updateRouteAndDistance();
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
        });
        // --- HELPER FUNCTIONS ---
        // Integrasi Autocomplete dengan Nominatim
        function setupAutocomplete(selector, target) {
            $(selector).autocomplete({
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
                        error: function() {
                            response([]);
                        }
                    });
                },
                select: function(event, ui) {
                    isLivePathActive = false;
                    const latlng = [parseFloat(ui.item.lat), parseFloat(ui.item.lon)];
                    const marker = target === 'awal' ? markerA : markerB;
                    
                    marker.setLatLng(latlng);
                    $(`#lokasi_${target}_hidden`).val(latlng.join(','));
                    updateRouteAndDistance();
                }
            });
        }
        // Handle Enter key manual pada kolom pencarian alamat
        function setupManualCoordInput(selector, target) {
            $(selector).on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = $(this).val();
                    if (query.length < 2) return;
                    
                    const errorElement = $(`#lokasi_${target}_error`);
                    const hiddenElement = $(`#lokasi_${target}_hidden`);
                    const marker = target === 'awal' ? markerA : markerB;
                    
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
                                isLivePathActive = false;
                                const lat = parseFloat(data[0].lat);
                                const lon = parseFloat(data[0].lon);
                                marker.setLatLng([lat, lon]);
                                hiddenElement.val(lat + ',' + lon);
                                updateRouteAndDistance();
                                errorElement.text('');
                            } else {
                                errorElement.text('Lokasi tidak ditemukan, coba alamat lain.');
                            }
                        },
                        error: function() {
                            errorElement.text('Terjadi kesalahan saat mencari lokasi.');
                        }
                    });
                }
            });
            // Deteksi input koordinat langsung (format: lat,lng)
            $(selector).on('change', function() {
                const val = $(this).val();
                const coordMatch = val.match(/^(-?\d+\.\d+),\s*(-?\d+\.\d+)$/);
                if (coordMatch) {
                    isLivePathActive = false;
                    const lat = parseFloat(coordMatch[1]);
                    const lng = parseFloat(coordMatch[2]);
                    const marker = target === 'awal' ? markerA : markerB;
                    
                    marker.setLatLng([lat, lng]);
                    $(`#lokasi_${target}_hidden`).val(lat + ',' + lng);
                    updateRouteAndDistance();
                    reverseGeocode(lat, lng, target);
                }
            });
        }
        // Menghitung rute riil via jalan utama OSRM & menghitung jarak rute
        function updateRouteAndDistance() {
            if (!markerA || !markerB) return;
            
            const latlngA = markerA.getLatLng();
            const latlngB = markerB.getLatLng();
            
            // Animasi loading teks jarak
            $('#jarak_value').html('<span class="spinner-border spinner-border-sm"></span> Menghitung rute jalan...');
            // URL OSRM API (mengikuti jalur berkendara jalan raya)
            const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${latlngA.lng},${latlngA.lat};${latlngB.lng},${latlngB.lat}?overview=full&geometries=geojson`;
            fetch(osrmUrl)
                .then(res => res.json())
                .then(data => {
                    if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
                        const route = data.routes[0];
                        const routeCoords = route.geometry.coordinates.map(coord => [coord[1], coord[0]]);
                        
                        // Update rute garis pada peta
                        polyline.setLatLngs(routeCoords);
                        
                        // Hitung jarak jalan (dalam meter)
                        const distanceMeters = route.distance;
                        let distanceText = '';
                        if (distanceMeters < 1000) {
                            distanceText = Math.round(distanceMeters) + ' meter';
                        } else {
                            distanceText = (distanceMeters / 1000).toFixed(2) + ' km';
                        }
                        
                        $('#jarak_value').text(distanceText);
                        $('#jarak_container').removeClass('d-none').addClass('d-flex');
                        
                        adjustMapBoundsToRoute();
                    } else {
                        drawStraightLineFallback(latlngA, latlngB);
                    }
                })
                .catch(err => {
                    console.warn('Gagal memuat rute jalan (OSRM). Menggunakan garis lurus:', err);
                    drawStraightLineFallback(latlngA, latlngB);
                });
        }
        // Fallback jika API Routing Offline
        function drawStraightLineFallback(latlngA, latlngB) {
            polyline.setLatLngs([latlngA, latlngB]);
            const distanceMeters = latlngA.distanceTo(latlngB);
            let distanceText = '';
            if (distanceMeters < 1000) {
                distanceText = Math.round(distanceMeters) + ' meter (garis lurus)';
            } else {
                distanceText = (distanceMeters / 1000).toFixed(2) + ' km (garis lurus)';
            }
            $('#jarak_value').text(distanceText);
            $('#jarak_container').removeClass('d-none').addClass('d-flex');
            
            const bounds = L.latLngBounds([latlngA, latlngB]);
            map.fitBounds(bounds.pad(0.15));
        }
        // Fit map agar mencakup seluruh rute polyline jalan raya dengan padding
        function adjustMapBoundsToRoute() {
            if (polyline) {
                map.fitBounds(polyline.getBounds().pad(0.15));
            }
        }
        // Geocoding terbalik (koordinat ke teks alamat)
        function reverseGeocode(lat, lng, target) {
            const inputElement = target === 'awal' ? $('#lokasi_awal') : $('#lokasi_akhir');
            const liveInputElement = target === 'awal' ? $('#lokasi_awal_live') : $('#lokasi_akhir_live');
            
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    const address = data.display_name || (lat + ', ' + lng);
                    inputElement.val(address);
                    liveInputElement.val(address);
                })
                .catch(() => {
                    const coords = lat + ', ' + lng;
                    inputElement.val(coords);
                    liveInputElement.val(coords);
                });
        }
        // Trigger Geolocation secara aktif (mengklik tombol)
        function triggerGeolocation(target) {
            const btn = $(`#btn-lokasi-saya-${target}`);
            const oldHtml = btn.html();
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const marker = target === 'awal' ? markerA : markerB;
                    
                    marker.setLatLng([lat, lng]);
                    $(`#lokasi_${target}_hidden`).val(lat + ',' + lng);
                    updateRouteAndDistance();
                    reverseGeocode(lat, lng, target);
                    btn.prop('disabled', false).html(oldHtml);
                }, function(error) {
                    btn.prop('disabled', false).html(oldHtml);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Akses Gagal',
                        text: 'Gagal mendapatkan lokasi. Pastikan GPS aktif dan izin browser disetujui.',
                        confirmButtonColor: '#f6b23e'
                    });
                }, { enableHighAccuracy: true, timeout: 15000 });
            } else {
                btn.prop('disabled', false).html(oldHtml);
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Didukung',
                    text: 'Browser Anda tidak mendukung Geolocation.',
                    confirmButtonColor: '#d33'
                });
            }
        }
        // Trigger Geolocation secara senyap (ketika mengambil gambar bukti)
        function triggerGeolocationSilently(target) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const marker = target === 'awal' ? markerA : markerB;
                    
                    marker.setLatLng([lat, lng]);
                    $(`#lokasi_${target}_hidden`).val(lat + ',' + lng);
                    updateRouteAndDistance();
                    reverseGeocode(lat, lng, target);
                }, function(err) {
                    console.warn('Geolocation silent failed:', err);
                }, { enableHighAccuracy: true, timeout: 10000 });
            }
        }
        // --- LIVE TRACKING CORE METHODS ---
        
        function startLiveTracking() {
            if (!navigator.geolocation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Didukung',
                    text: 'Browser Anda tidak mendukung Geolocation.',
                    confirmButtonColor: '#d33'
                });
                return;
            }
            
            liveCoordinates = [];
            isLivePathActive = true;
            
            $('#live-status-info').html('<span class="spinner-border spinner-border-sm text-success mr-2"></span>Merekam pergerakan GPS...');
            $('#live-btn-text').text('Hentikan Rekam (Stop)');
            $('#btn-toggle-live-tracking').addClass('recording');
            
            $('#lokasi_awal_live').val('Mengambil koordinat awal...');
            $('#lokasi_akhir_live').val('Merekam pergerakan...');
            
            // Kunci layar agar tidak mati (Wake Lock)
            requestWakeLock();
            
            // Nonaktifkan drag marker selama perekaman agar koordinat sinkron
            markerA.dragging.disable();
            markerB.dragging.disable();
            
            // Bersihkan jalur polyline lama
            polyline.setLatLngs([]);
            
            liveWatchId = navigator.geolocation.watchPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                
                // Lewati titik dengan tingkat akurasi rendah (> 30 meter) untuk meminimalisir lonjakan lompatan GPS
                if (accuracy > 35) {
                    console.log('GPS Signal Weak, skipping coordinate. Accuracy:', accuracy);
                    return;
                }
                
                const latlng = L.latLng(lat, lng);
                liveCoordinates.push(latlng);
                
                // Set Titik Mulai (A) di koordinat valid pertama
                if (liveCoordinates.length === 1) {
                    markerA.setLatLng(latlng);
                    $('#lokasi_awal_hidden').val(lat + ',' + lng);
                    reverseGeocode(lat, lng, 'awal');
                }
                
                // Posisikan Titik Akhir (B) selalu mengikuti lokasi GPS terkini
                markerB.setLatLng(latlng);
                $('#lokasi_akhir_hidden').val(lat + ',' + lng);
                
                // Gambar garis rute aktual yang dilalui
                polyline.setLatLngs(liveCoordinates);
                
                // Update jarak akumulatif secara dinamis
                updateLiveDistance();
                
                // Arahkan pandangan peta mengikuti posisi pengguna
                map.setView(latlng, 17);
                
            }, function(error) {
                console.error('Live GPS tracking error:', error);
                let errorMsg = 'Gagal mengakses GPS.';
                if (error.code === error.PERMISSION_DENIED) {
                    errorMsg = 'Akses lokasi ditolak oleh pengguna/browser.';
                } else if (error.code === error.TIMEOUT) {
                    errorMsg = 'Koneksi GPS timeout.';
                }
                $('#live-status-info').html('<span class="text-danger">Gagal: ' + errorMsg + '</span>');
                stopLiveTracking(true);
            }, {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 10000
            });
        }
        
        function stopLiveTracking(isCancelled = false) {
            if (liveWatchId !== null) {
                navigator.geolocation.clearWatch(liveWatchId);
                liveWatchId = null;
            }
            
            // Lepas kunci layar
            releaseWakeLock();
            
            // Kembalikan status tombol
            $('#btn-toggle-live-tracking').removeClass('recording');
            $('#live-btn-text').text('Mulai Rekam Rute Live');
            
            // Aktifkan kembali drag marker
            markerA.dragging.enable();
            markerB.dragging.enable();
            
            if (isCancelled) {
                return;
            }
            
            if (liveCoordinates.length < 2) {
                isLivePathActive = false;
                $('#live-status-info').text('Status: Siap Merekam');
                $('#lokasi_awal_live').val('');
                $('#lokasi_akhir_live').val('');
                Swal.fire({
                    icon: 'warning',
                    title: 'Rute Terlalu Pendek',
                    text: 'Minimal dibutuhkan 2 titik lokasi valid yang terekam. Pastikan Anda sudah berpindah posisi sejauh beberapa meter sebelum menekan tombol Stop.',
                    confirmButtonColor: '#f6b23e'
                });
                updateRouteAndDistance();
                return;
            }
            
            $('#live-status-info').text('Status: Perekaman Rute Selesai');
            
            // Tentukan koordinat titik akhir
            const startPoint = liveCoordinates[0];
            const endPoint = liveCoordinates[liveCoordinates.length - 1];
            
            $('#lokasi_awal_hidden').val(startPoint.lat + ',' + startPoint.lng);
            $('#lokasi_akhir_hidden').val(endPoint.lat + ',' + endPoint.lng);
            
            // Jalankan geocoding terbalik untuk mendapatkan alamat tekstual riil
            reverseGeocode(startPoint.lat, startPoint.lng, 'awal');
            reverseGeocode(endPoint.lat, endPoint.lng, 'akhir');
            
            // Fit map agar mencakup rute live yang direkam
            adjustMapBoundsToRoute();
        }
        
        // Menghitung akumulasi jarak berjalan riil dari titik ke titik
        function updateLiveDistance() {
            if (liveCoordinates.length < 2) return;
            
            let totalDist = 0;
            for (let i = 0; i < liveCoordinates.length - 1; i++) {
                totalDist += liveCoordinates[i].distanceTo(liveCoordinates[i+1]);
            }
            
            let distanceText = '';
            if (totalDist < 1000) {
                distanceText = Math.round(totalDist) + ' meter (Live Track)';
            } else {
                distanceText = (totalDist / 1000).toFixed(2) + ' km (Live Track)';
            }
            
            $('#jarak_value').text(distanceText);
            $('#jarak_container').removeClass('d-none').addClass('d-flex');
        }
        // Layar Tetap Aktif saat Merekam (Wake Lock)
        async function requestWakeLock() {
            if ('wakeLock' in navigator) {
                try {
                    wakeLock = await navigator.wakeLock.request('screen');
                    console.log('Screen Wake Lock aktif.');
                } catch (err) {
                    console.warn(`Screen Wake Lock gagal diaktifkan: ${err.message}`);
                }
            }
        }
        function releaseWakeLock() {
            if (wakeLock !== null) {
                wakeLock.release().then(() => {
                    wakeLock = null;
                    console.log('Screen Wake Lock dilepas.');
                });
            }
        }
        // Reset display preview unggah
        function resetUploadPreview() {
            $('#bukti_laporan').val('');
            $('#upload-preview').addClass('d-none');
            $('.upload-icon-wrapper, .upload-text').removeClass('d-none');
            $('#preview-media-container').empty();
        }
    </script>
</body>
</html>
