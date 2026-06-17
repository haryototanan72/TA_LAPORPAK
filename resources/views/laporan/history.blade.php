@extends('layouts.app')

@section('content')
<style>
    /* Gradient Page Background matching tracking and form_laporan */
    .history-page-container {
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
    
    /* Button back matching tracking and form_laporan */
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

    /* Table & Card Design */
    .rounded-12 {
        border-radius: 12px !important;
    }
    
    .custom-table th, .custom-table td {
        vertical-align: middle !important;
        text-align: center;
    }
    
    .btn-navy {
        background: transparent !important;
        color: #182848 !important;
        border: 2px solid transparent;
        box-shadow: none;
        padding: 0.375rem 0.6rem;
    }
    
    .btn-navy:hover {
        background: #0f1731 !important;
        color: #fff !important;
    }
    
    .btn-edit-custom {
        background: #fff;
        color: #ffc107;
        border: 1.5px solid #ffc107;
        transition: all 0.2s;
    }
    
    .btn-edit-custom:hover {
        background: #ffc107;
        color: #fff;
        border-color: #ffc107;
    }
    
    .btn-delete-custom {
        background: #fff;
        color: #dc3545;
        border: 1.5px solid #dc3545;
        transition: all 0.2s;
    }
    
    .btn-delete-custom:hover {
        background: #dc3545;
        color: #fff;
        border-color: #dc3545;
    }

    @media (max-width: 576px) {
        .history-page-container {
            padding: 20px 10px;
        }
        .title {
            font-size: 1.6rem;
        }
        .subtitle {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        .custom-table th, .custom-table td {
            font-size: 0.8rem;
            padding: 8px 4px !important;
        }
        .btn-sm {
            padding: 0.2rem 0.35rem;
            font-size: 0.75rem;
        }
        .card {
            padding: 15px 10px !important;
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="history-page-container shadow-sm mt-3">
    <!-- Tombol Kembali (Direct Link to Dashboard) -->
    <a href="{{ route('user.dashboard') }}" class="btn-back" title="Kembali">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18l-6-6 6-6" />
        </svg>
    </a>

    <div class="text-center mb-4">
        <h1 class="title">LAPORAN SAYA</h1>
        <p class="subtitle">Daftar keluhan dan laporan yang telah Anda kirimkan</p>
    </div>

    <!-- Card Tabel History -->
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card border-0 shadow-sm rounded-12 bg-white p-4">
                <div class="table-responsive">
                    <table class="table table-bordered custom-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:50px">No</th>
                                <th>Nomor Laporan</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th style="width:120px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporans as $laporan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $laporan->nomor_laporan }}</td>
                                <td>{{ $laporan->created_at->format('d-m-Y') }}</td>
                                <td>{{ $laporan->kategori }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">
                                        <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-navy btn-sm" title="Lihat"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-edit-custom btn-sm" title="Edit">Edit</a>
                                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete-custom btn-sm btn-hapus-laporan" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                    @if($laporan->status === 'selesai' && $laporan->feedbackAdmin && !$laporan->feedbackUser)
                                        <!-- Tombol Beri Feedback (halaman popup biasa)-->
                                        <a href="{{ route('laporan.feedbackUserForm', $laporan->id) }}" class="btn btn-primary btn-sm mt-2" target="_blank">Beri Feedback</a>
                                    @elseif($laporan->feedbackUser)
                                        <!-- Sudah ada feedback user -->
                                        <div class="mt-2">
                                          <span class="badge bg-success">Feedback Terkirim</span><br>
                                          <strong>Rating:</strong> {{ $laporan->feedbackUser->rating }}<br>
                                          <strong>Pesan:</strong> {{ $laporan->feedbackUser->pesan }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($laporans->isEmpty())
                    <div class="alert alert-info mt-3 mb-0">Belum ada laporan yang Anda buat.</div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/history.js') }}"></script>
@endsection
