@extends('layouts.app')

@section('content')
<style>
    /* Gradient Page Background matching form_laporan */
    .track-page-container {
        background: linear-gradient(135deg, #e0ecfc 0%, #f9f6e7 100%);
        min-height: 90vh;
        border-radius: 12px;
        padding: 40px 30px;
        font-family: 'Poppins', Arial, sans-serif;
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
    
    /* Input Styling matching form_laporan */
    .form-control-lg {
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        font-size: 1.1rem;
        padding: 12px 16px;
        background-color: white;
        transition: all 0.2s ease;
    }
    
    .form-control-lg:focus {
        border-color: #f6b23e;
        box-shadow: 0 0 0 3px #ffe4b8;
    }
    
    /* Button back matching form_laporan */
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
        transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    
    .btn-back:hover {
        background: linear-gradient(90deg, #ff3c3c 0%, #ff8c42 100%);
        color: #fff;
        box-shadow: 0 4px 16px 0 rgba(255, 140, 66, 0.18);
        text-decoration: none;
        transform: scale(1.05);
    }
    
    .btn-back svg {
        width: 22px;
        height: 22px;
        vertical-align: middle;
    }
    
    /* Button search matching form_laporan theme */
    .btn-submit {
        background: #f6b23e;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        padding: 14px 20px;
        font-size: 1.1rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(246, 178, 62, 0.15);
    }
    
    .btn-submit:hover {
        background: #e6a23c;
        color: #fff;
        box-shadow: 0 6px 16px rgba(246, 178, 62, 0.25);
    }
    
    /* Details Table Styling */
    .table-borderless td {
        padding: 8px 0;
    }
    
    /* Responsive timeline converter */
    @media (max-width: 767.98px) {
        .timeline-wrapper {
            flex-direction: column !important;
            align-items: flex-start !important;
            padding-left: 20px;
        }
        .timeline-item {
            flex-direction: row !important;
            text-align: left !important;
            width: 100% !important;
            margin-bottom: 28px;
            align-items: center;
        }
        .timeline-item .rounded-circle {
            margin-left: 0 !important;
            margin-right: 20px !important;
            margin-bottom: 0 !important;
            flex-shrink: 0;
        }
        .timeline-item p {
            display: none;
        }
        .timeline-line-bg {
            left: 45px !important;
            top: 25px !important;
            bottom: 25px !important;
            width: 3px !important;
            height: auto !important;
            right: auto !important;
        }
        .timeline-line-progress {
            left: 45px !important;
            top: 25px !important;
            width: 3px !important;
            height: {{ isset($report) ? ($progress_pct ?? 0) : 0 }}% !important;
            right: auto !important;
        }
    }
</style>

<div class="track-page-container shadow-sm mt-3">
    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="btn-back" title="Kembali ke Dashboard">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18l-6-6 6-6" />
        </svg>
    </a>

    <div class="text-center mb-4">
        <h1 class="title">LACAK LAPORANMU</h1>
        <p class="subtitle">Masukkan nomor laporan Anda untuk melacak status penanganan terkini</p>
    </div>

    @if(session('nomor_laporan'))
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="alert alert-success border-0 rounded-12 shadow-sm text-center py-3" style="background-color: #d1e7dd; color: #0f5132;">
                    <h5 class="font-weight-bold mb-1">🎉 Laporan Berhasil Dikirim!</h5>
                    Nomor Laporan Anda: <strong class="fs-5" style="letter-spacing: 0.5px;">{{ session('nomor_laporan') }}</strong><br>
                    <span class="small text-muted mt-1 d-block">Gunakan nomor di atas untuk melakukan pelacakan langsung pada kolom di bawah.</span>
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-7">
            <form action="{{ route('track.search') }}" method="POST" autocomplete="off">
                @csrf
                <div class="input-group mb-4">
                    <input type="text" 
                        class="form-control form-control-lg" 
                        name="nomor_laporan" 
                        placeholder="Contoh: LAP123456 atau LPR-ABCDEF12"
                        value="{{ $nomor_laporan ?? old('nomor_laporan') }}"
                        required>
                    <div class="input-group-append pl-2">
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-search mr-1"></i> Cari Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @php
        $status = isset($report) ? strtolower($report->status) : '';
        
        // Logika 4 Steps Berdasarkan 5 Status Baru
        $step1_active = true; // Selalu aktif (Diajukan)
        $step2_active = in_array($status, ['diverifikasi', 'ditindaklanjuti', 'selesai']);
        $step3_active = in_array($status, ['ditindaklanjuti', 'selesai']);
        $step4_active = ($status === 'selesai');
        
        $is_rejected = ($status === 'ditolak');

        // Persentase untuk 4 steps: (Step1: 0%, Step2: 33%, Step3: 66%, Step4: 100%)
        $progress_pct = 0;
        if ($step4_active) $progress_pct = 100;
        elseif ($step3_active) $progress_pct = 66;
        elseif ($step2_active) $progress_pct = 33;
    @endphp

    <div class="row justify-content-center mt-5">
        <div class="col-md-11">
            <div class="d-flex justify-content-between position-relative timeline-wrapper">
                <div class="position-absolute timeline-line-bg" style="top: 25px; left: 10%; right: 10%; height: 3px; background-color: #e0e0e0; z-index: 1;"></div>
                
                @if(isset($report) && !$is_rejected)
                    <div class="position-absolute timeline-line-progress" style="top: 25px; left: 10%; width: {{ $progress_pct * 0.8 }}%; height: 3px; background: linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%); z-index: 1; transition: width 0.6s ease;"></div>
                @endif

                <div class="text-center position-relative timeline-item" style="z-index: 2; width: 180px;">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%); box-shadow: 0 4px 10px rgba(255, 140, 66, 0.3); color: #fff;">
                        <i class="bi bi-pencil-fill"></i>
                    </div>
                    <h6 class="mb-1 font-weight-bold text-dark">Diajukan</h6>
                    <p class="text-muted small mb-0 px-1" style="font-size: 0.78rem; line-height: 1.3;">Laporan aduan masuk ke sistem LaporPak!</p>
                </div>

                <div class="text-center position-relative timeline-item" style="z-index: 2; width: 180px;">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: {{ $step2_active && !$is_rejected ? 'linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%)' : '#e0e0e0' }}; box-shadow: {{ $step2_active && !$is_rejected ? '0 4px 10px rgba(255, 140, 66, 0.3)' : 'none' }}; color: {{ $step2_active && !$is_rejected ? '#fff' : '#aaa' }}; transition: all 0.3s ease;">
                        <i class="bi bi-check-circle-fill" style="color: {{ $step2_active && !$is_rejected ? '#fff' : '#aaa' }}"></i>
                    </div>
                    <h6 class="mb-1 font-weight-bold {{ $step2_active && !$is_rejected ? 'text-dark' : 'text-muted' }}">Diverifikasi</h6>
                    <p class="text-muted small mb-0 px-1" style="font-size: 0.78rem; line-height: 1.3;">Diverifikasi dan diteruskan ke Dinas terkait</p>
                </div>

                <div class="text-center position-relative timeline-item" style="z-index: 2; width: 180px;">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: {{ $step3_active && !$is_rejected ? 'linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%)' : '#e0e0e0' }}; box-shadow: {{ $step3_active && !$is_rejected ? '0 4px 10px rgba(255, 140, 66, 0.3)' : 'none' }}; color: {{ $step3_active && !$is_rejected ? '#fff' : '#aaa' }}; transition: all 0.3s ease;">
                        <i class="bi bi-gear" style="color: {{ $step3_active && !$is_rejected ? '#fff' : '#aaa' }}"></i>
                    </div>
                    <h6 class="mb-1 font-weight-bold {{ $step3_active && !$is_rejected ? 'text-dark' : 'text-muted' }}">Ditindaklanjuti</h6>
                    <p class="text-muted small mb-0 px-1" style="font-size: 0.78rem; line-height: 1.3;">Proses perbaikan fasilitas jalan/jembatan dimulai</p>
                </div>

                <div class="text-center position-relative timeline-item" style="z-index: 2; width: 180px;">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: {{ $step4_active && !$is_rejected ? 'linear-gradient(90deg, #ff8c42 0%, #ff3c3c 100%)' : '#e0e0e0' }}; box-shadow: {{ $step4_active && !$is_rejected ? '0 4px 10px rgba(255, 140, 66, 0.3)' : 'none' }}; color: {{ $step4_active && !$is_rejected ? '#fff' : '#aaa' }}; transition: all 0.3s ease;">
                        <i class="bi bi-check2-circle" style="color: {{ $step4_active && !$is_rejected ? '#fff' : '#aaa' }}"></i>
                    </div>
                    <h6 class="mb-1 font-weight-bold {{ $step4_active && !$is_rejected ? 'text-dark' : 'text-muted' }}">Selesai</h6>
                    <p class="text-muted small mb-0 px-1" style="font-size: 0.78rem; line-height: 1.3;">Laporan telah diselesaikan secara tuntas</p>
                </div>
            </div>
        </div>
    </div>

    @if(isset($report) && $is_rejected)
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="alert alert-danger border-0 rounded-12 shadow-sm text-center py-3" style="background-color: #fde8e8; color: #9b1c1c;">
                    <h5 class="font-weight-bold mb-1">❌ Laporan Ditolak</h5>
                    <p class="mb-0 small">{{ $alasan_penolakan ?? 'Maaf Laporan Anda Kurang Valid atau telah Ditolak oleh Admin.' }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(isset($report))
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm rounded-12 overflow-hidden bg-white">
                    <div class="card-header border-0 bg-white pt-4 px-4 pb-0">
                        <h5 class="font-weight-bold text-dark mb-0">
                            <i class="bi bi-info-circle-fill text-warning mr-1"></i> Detail Informasi Laporan
                        </h5>
                        <hr class="mt-2 mb-0" style="border-top: 1.5px solid #f1f1f1;">
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row">
                            <div class="col-md-7">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted font-weight-500" style="width: 160px;">Nomor Laporan</td>
                                            <td class="font-weight-bold text-dark">: {{ $report->nomor_laporan }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted font-weight-500">Kategori</td>
                                            <td class="font-weight-bold text-dark">: {{ $report->kategori ?? $report->kategori_laporan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted font-weight-500">Status</td>
                                            <td>: 
                                                <span class="badge px-3 py-2 text-white font-weight-600 rounded-32" style="background-color: {{ $is_rejected ? '#e74c3c' : ($step4_active ? '#2ecc71' : ($step3_active ? '#f39c12' : '#3498db')) }}; text-transform: uppercase;">
                                                    {{ $report->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted font-weight-500">Tanggal Kirim</td>
                                            <td class="text-dark">: {{ $report->created_at->format('d M Y - H:i') }} WIB</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted font-weight-500">Deskripsi</td>
                                            <td class="text-dark" style="white-space: pre-line;">: {{ $report->deskripsi ?? $report->deskripsi_laporan ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-5 text-center mt-3 mt-md-0 border-left pl-md-4">
                                <p class="text-muted font-weight-600 text-left mb-2">Lampiran Bukti Laporan</p>
                                @if($report->bukti_laporan)
                                    @php
                                        $fileExtension = pathinfo($report->bukti_laporan, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        $isVideo = in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov', 'webm']);
                                    @endphp
                                    
                                    @if($isImage)
                                        <div class="d-inline-block p-1 border rounded-8 shadow-xs bg-light">
                                            <img src="{{ asset('storage/' . $report->bukti_laporan) }}" class="img-fluid rounded-8" style="max-height: 200px; object-fit: cover;">
                                        </div>
                                    @elseif($isVideo)
                                        <div class="d-inline-block p-1 border rounded-8 shadow-xs bg-light w-100">
                                            <video src="{{ asset('storage/' . $report->bukti_laporan) }}" controls class="img-fluid rounded-8" style="max-height: 200px; object-fit: cover;"></video>
                                        </div>
                                    @else
                                        <div class="py-4 bg-light rounded-8 border">
                                            <i class="bi bi-file-earmark-arrow-down-fill text-warning d-block" style="font-size: 3rem;"></i>
                                            <a href="{{ asset('storage/' . $report->bukti_laporan) }}" target="_blank" class="btn btn-sm btn-outline-warning mt-2 font-weight-bold">
                                                Unduh Lampiran
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-muted italic small py-4 bg-light rounded-8">Tidak ada bukti lampiran</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Nomor Laporan Tidak Ditemukan',
        text: 'Cek dan pastikan kembali nomor laporan yang Anda masukkan sudah benar.',
        confirmButtonColor: '#ff8c42',
        confirmButtonText: 'Tutup'
    });
</script>
@endif

@push('scripts')
<style>
.bi {
    font-size: 1.5rem;
}
</style>
@endpush

@endsection