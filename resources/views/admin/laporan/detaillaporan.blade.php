@extends('layouts.adminlayout')

@section('content')
<div class="container-fluid px-4"><!-- px-4 untuk mengurangi jarak kiri-kanan -->
    <div class="row justify-content-center">
        <div class="col-lg-10 mx-auto"><!-- col-lg-10 agar konten lebih tengah dan tidak terlalu jauh dari sidebar -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0">
                    <h3 class="fw-bold mb-0" style="color:#2763ba;">Detail Laporan</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-stretch"><!-- g-4 untuk mengatur jarak antar kolom -->
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th class="text-secondary">Nomor Laporan</th>
                                    <td>{{ $laporan->nomor_laporan }}</td>
                                </tr>
                                <tr>
                                <tr>
                                    <th class="text-secondary">Lokasi</th>
                                    <td>{{ $laporan->lokasi }}</td>
                                </tr>
                                <tr>
                                    <th class="text-secondary">Tanggal</th>
                                    <td>{{ $laporan->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-secondary">Pelapor</th>
                                    <td>{{ $laporan->user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-secondary">Status</th>
                                    <td>
                                        <form id="statusForm" action="{{ route('admin.laporan.updateStatus', $laporan->nomor_laporan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" id="statusSelect" class="form-select d-inline-block w-auto mb-2" style="background:#fbb03b;color:#fff;font-weight:600;">
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
                                @if($laporan->laporanPetugas->count())
                                <tr>
                                    <th class="text-secondary">Kondisi Lapangan</th>
                                    <td>
                                        @foreach($laporan->laporanPetugas as $petugas)
                                            <div>{{ $petugas->kondisi_lapangan }}</div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif

                                @if($laporan->bukti_laporan)
                            <tr>
                                <th class="text-secondary align-top">Bukti Laporan</th>
                                <td>
                                    @php
                                        $ext = pathinfo($laporan->bukti_laporan, PATHINFO_EXTENSION);
                                        $isVideo = in_array(strtolower($ext), ['mp4', 'mov', 'avi', 'mkv', 'webm']);
                                    @endphp

                                    <div style="border:1px solid #ddd; border-radius:8px; padding:8px; width:140px; background:#f8f9fa; display:flex; align-items:center; justify-content:center;">
                                        @if($isVideo)
                                            <video id="buktiLaporanVideo" controls style="max-width:120px; max-height:120px; border-radius:6px; cursor:pointer; object-fit:cover;">
                                                <source src="{{ asset('storage/' . $laporan->bukti_laporan) }}" type="video/{{ $ext }}">
                                                Browser Anda tidak mendukung pemutaran video.
                                            </video>
                                        @else
                                            <img src="{{ asset('storage/' . $laporan->bukti_laporan) }}" alt="Bukti Laporan" style="max-width:120px; max-height:120px; object-fit:cover; border-radius:6px; cursor:pointer;" id="buktiLaporanImg">
                                        @endif
                                    </div>

                                    <!-- Modal untuk preview gambar/video besar -->
                                    <div id="buktiModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
                                        <div style="position:relative; display:flex; align-items:center; justify-content:center; height:100vh;">
                                            @if($isVideo)
                                                <video controls autoplay style="max-width:80vw; max-height:80vh; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.3);">
                                                    <source src="{{ asset('storage/' . $laporan->bukti_laporan) }}" type="video/{{ $ext }}">
                                                    Browser Anda tidak mendukung video.
                                                </video>
                                            @else
                                                <img src="{{ asset('storage/' . $laporan->bukti_laporan) }}" alt="Bukti Laporan Besar" style="max-width:80vw; max-height:80vh; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.3);">
                                            @endif

                                            <button id="closeBuktiModal" style="position:absolute; top:20px; right:20px; background:#fbb03b; color:#fff; border:none; border-radius:50%; width:40px; height:40px; font-size:22px; font-weight:bold; box-shadow:0 2px 8px rgba(0,0,0,0.2); cursor:pointer;">&times;</button>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var img = document.getElementById('buktiLaporanImg');
                                            var video = document.getElementById('buktiLaporanVideo');
                                            var modal = document.getElementById('buktiModal');
                                            var closeBtn = document.getElementById('closeBuktiModal');

                                            if (modal && closeBtn) {
                                                // Untuk gambar
                                                if (img) {
                                                    img.addEventListener('click', function() {
                                                        modal.style.display = 'flex';
                                                    });
                                                }
                                                // Untuk video
                                                if (video) {
                                                    video.addEventListener('click', function() {
                                                        modal.style.display = 'flex';
                                                    });
                                                }
                                                // Tutup modal
                                                closeBtn.addEventListener('click', function() {
                                                    modal.style.display = 'none';
                                                });
                                                modal.addEventListener('click', function(e) {
                                                    if (e.target === modal) modal.style.display = 'none';
                                                });
                                            }
                                        });
                                    </script>
                                </td>
                            </tr>
                            @endif
                             @if($laporan->status === 'diverifikasi')
                                <form action="{{ route('admin.laporan.verify', $laporan->id) }}"
                                        method="POST" >
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            Kirim Email ke Instansi
                                        </button>
                                    </form>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-2" style="color:#2763ba;">Deskripsi Laporan</h5>
                            <div class="bg-light p-3 rounded shadow-sm border mb-3 h-100">
                                <span class="text-dark">{{ $laporan->deskripsi }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Timeline dipindah ke bawah -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="status-timeline d-flex justify-content-between align-items-center position-relative">
                                <div class="timeline-line"></div>
                                <div class="timeline-item {{ in_array($laporan->status, ['diajukan', 'diverifikasi', 'diterima', 'ditindaklanjuti', 'ditanggapi', 'selesai']) ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="fas fa-edit"></i></span>
                                    <span class="timeline-title">Tulis Laporan</span>
                                </div>
                                <div class="timeline-item {{ in_array($laporan->status, ['diverifikasi', 'diterima', 'ditindaklanjuti', 'ditanggapi', 'selesai']) ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="fas fa-search"></i></span>
                                    <span class="timeline-title">Proses Verifikasi</span>
                                </div>
                                <div class="timeline-item {{ in_array($laporan->status, ['ditindaklanjuti', 'ditanggapi', 'selesai']) ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="fas fa-tools"></i></span>
                                    <span class="timeline-title">Proses Tindak Lanjut</span>
                                </div>
                                <div class="timeline-item {{ in_array($laporan->status, ['ditanggapi', 'selesai']) ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="fas fa-comments"></i></span>
                                    <span class="timeline-title">Beri Tanggapan</span>
                                </div>
                                <div class="timeline-item {{ $laporan->status == 'selesai' ? 'done' : '' }}">
                                    <span class="timeline-icon"><i class="fas fa-check-circle"></i></span>
                                    <span class="timeline-title">Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol konfirmasi ubah status -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button id="btnUbahStatus" class="btn btn-warning px-4 py-2 fw-bold" style="background:#fbb03b; font-size:1.1rem;">Ubah Status</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedStatus = document.getElementById('statusSelect').value;
    document.getElementById('statusSelect').addEventListener('change', function() {
        selectedStatus = this.value;
    });
    document.getElementById('btnUbahStatus').addEventListener('click', function() {
        const statusText = document.getElementById('statusSelect').options[document.getElementById('statusSelect').selectedIndex].text;
        if(confirm('Apakah Anda yakin ingin mengubah status laporan menjadi: ' + statusText + '?')) {
            document.getElementById('statusForm').submit();
        }
    });
});
</script>

<style>
.status-timeline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0;
    margin-top: 36px;
    min-width: 700px;
    position: relative;
}
.timeline-line {
    position: absolute;
    left: 0;
    right: 0;
    top: 28px;
    height: 4px;
    background: #fbb03b33;
    z-index: 1;
}
.timeline-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-weight: 500;
    color: #bdbdbd;
    z-index: 2;
    min-width: 120px;
}
.timeline-item.done {
    color: #fbb03b;
}
.timeline-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    background: #f3f3f3;
    border-radius: 50%;
    margin-bottom: 10px;
    font-size: 2rem;
    border: 4px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: background 0.2s, color 0.2s;
}
.timeline-item.done .timeline-icon {
    background: #fbb03b;
    color: #fff;
}
.timeline-title {
    font-size: 1.04rem;
    font-weight: 600;
    margin-top: 2px;
    text-align: center;
}
.card {
    border-radius: 14px;
}
th.text-secondary {
    font-weight: 600;
    color: #2763ba !important;
    width: 140px;
}
.form-select {
    background: #fbb03b;
    color: #fff;
    font-weight: 600;
    border: none;
}
.form-select:focus {
    border: 1px solid #fbb03b;
    box-shadow: 0 0 0 0.2rem rgba(251, 176, 59, 0.25);
}
.btn-warning {
    background: #fbb03b;
    border: none;
    color: #fff;
    font-weight: 600;
}
.btn-warning:hover {
    background: #ffcb6b;
    color: #333;
}
</style>
@endsection
