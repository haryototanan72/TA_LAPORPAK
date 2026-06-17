@extends('layouts.app')

@section('content')
<style>
    /* Premium style for Notification Page matching LaporPak theme */
    .notif-container {
        background: linear-gradient(135deg, #e0ecfc 0%, #f9f6e7 100%);
        min-height: 80vh;
        border-radius: 15px;
        padding: 40px 30px;
        font-family: 'Poppins', Arial, sans-serif;
    }
    
    .title {
        font-size: 2.1rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 0.5rem;
    }
    
    .subtitle {
        font-size: 1rem;
        color: #555;
        margin-bottom: 2rem;
    }
    
    /* Back button style */
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
        transition: all 0.2s ease;
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

    /* Notification Card Style */
    .notif-card {
        border-radius: 12px;
        border: 1px solid #f1f1f1 !important;
        transition: all 0.2s ease;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    
    .notif-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.06) !important;
    }
    
    .notif-unread {
        background-color: rgba(246, 178, 62, 0.04) !important;
        border-left: 4px solid #f6b23e !important;
    }
    
    .icon-box {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background-color: #f8f9fa;
        border: 1px solid #eee;
    }
</style>

<div class="container py-4">
    <div class="notif-container shadow-sm">
        <!-- Back Button -->
        <a href="{{ route('dashboard') }}" class="btn-back" title="Kembali ke Dashboard">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </a>

        <div class="mb-4">
            <h1 class="title">Riwayat Notifikasi</h1>
            <p class="subtitle text-muted">Daftar pemberitahuan perubahan status laporan Anda dari Admin</p>
        </div>

        @if(isset($notifications) && count($notifications) > 0)
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    @foreach($notifications as $notification)
                        @php
                            $statusLower = isset($notification->data['status']) ? strtolower($notification->data['status']) : '';
                            $icon = 'bi-bell-fill text-primary';
                            
                            if (strpos($statusLower, 'selesai') !== false || strpos($statusLower, 'diperbaiki') !== false) {
                                $icon = 'bi-check-circle-fill text-success';
                            } elseif (strpos($statusLower, 'tolak') !== false || strpos($statusLower, 'kurang valid') !== false) {
                                $icon = 'bi-x-circle-fill text-danger';
                            } elseif (strpos($statusLower, 'tindak') !== false || strpos($statusLower, 'proses') !== false) {
                                $icon = 'bi-gear-fill text-warning';
                            }
                        @endphp
                        <div class="card notif-card my-3 {{ !$notification->read_at ? 'notif-unread' : '' }}">
                            <div class="card-body p-3 d-flex align-items-center">
                                <div class="icon-box mr-3">
                                    <i class="bi {{ $icon }}" style="font-size: 1.25rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 text-dark" style="font-size: 0.95rem; font-weight: {{ !$notification->read_at ? '600' : '400' }}; line-height: 1.45;">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    <span class="text-muted small d-inline-flex align-items-center">
                                        <i class="bi bi-clock me-1" style="font-size: 0.85rem;"></i>
                                        {{ $notification->created_at->format('d M Y') }} pukul {{ $notification->created_at->format('H:i') }} WIB
                                    </span>
                                </div>
                                @if(!$notification->read_at)
                                    <span class="badge bg-warning text-dark font-weight-bold ml-auto px-2 py-1" style="font-size: 0.7rem;">BARU</span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bell-slash text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">Belum Ada Notifikasi</h5>
                <p class="text-muted small">Anda akan menerima pemberitahuan di sini setelah Admin memproses laporan Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection