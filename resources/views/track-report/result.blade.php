@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/track-report-custom.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<div class="min-h-screen flex flex-col items-center justify-center bg-[#f8fcfa] py-8">
    <div class="max-w-2xl w-full mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-center mb-2 text-[#233876] tracking-wide">LACAK LAPORANMU</h1>
        <p class="text-center text-gray-600 mb-8">Sudah bikin laporan belum? Kalau sudah, Masukkan Nomor Laporanmu dibawah ini!</p>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4 text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center mb-6">
                <h2 class="text-lg font-semibold text-[#233876]">Nomor Laporan:</h2>
                <p class="text-2xl font-bold text-[#233876] tracking-wide">{{ $report->nomor_laporan }}</p>
            </div>

            <!-- Timeline Status Persis Tengah & Icon & Status Color -->
            <div class="flex justify-center mb-10">
                <div class="track-timeline">
                    @php
    $steps = [
        [
            'title' => 'Tulis Laporan',
            'desc' => 'Laporkan keluhan atau aspirasi Anda dengan jelas dan lengkap',
            'icon' => 'fa-pencil',
            'status' => 'diajukan',
        ],
        [
            'title' => 'Proses Verifikasi',
            'desc' => 'Dalam 2 hari laporan Anda akan diverifikasi dan ditindaklanjuti',
            'icon' => 'fa-magnifying-glass',
            'status' => 'diverifikasi',
        ],
        [
            'title' => 'Laporan Diterima',
            'desc' => 'Laporan Anda telah diverifikasi dan diterima',
            'icon' => 'fa-file-circle-check',
            'status' => 'diterima',
        ],
        [
            'title' => 'Proses Tindak Lanjut',
            'desc' => 'Laporan sedang dalam proses perbaikan',
            'icon' => 'fa-screwdriver-wrench',
            'status' => 'ditindaklanjuti',
        ],
        // [
        //     'title' => 'Beri Tanggapan',
        //     'desc' => 'Anda dapat menanggapi tindak lanjut',
        //     'icon' => 'fa-comment-dots',
        //     'status' => 'ditanggapi',
        // ],
        [
            'title' => 'Selesai',
            'desc' => 'Laporan Anda telah selesai ditindaklanjuti',
            'icon' => 'fa-circle-check',
            'status' => 'selesai',
        ],
    ];
    $status_order = ['diajukan','diverifikasi','diterima','ditindaklanjuti','ditanggapi','selesai'];
    $current_index = array_search($report->status, $status_order);
    $isDitolak = ($report->status === 'ditolak');
    if ($isDitolak) {
        $current_index = array_search('diterima', $status_order); // Stop at 'diterima' if rejected
    }
@endphp
@if ($isDitolak)
    @for ($i = 0; $i <= $current_index; $i++)
        @php
            $step = $steps[$i];
            $isYellow = true;
            $iconClass = 'active-yellow';
            $lineClass = 'yellow';
            $titleClass = 'yellow';
        @endphp
        <div class="track-timeline-step">
            <div class="track-timeline-icon {{ $iconClass }}">
                <i class="fa-solid {{ $step['icon'] }}"></i>
            </div>
            <div class="track-timeline-line {{ $lineClass }}"></div>
            <div class="track-timeline-content">
                <div class="track-timeline-title {{ $titleClass }}">{{ $step['title'] }}</div>
                <div class="track-timeline-desc">{{ $step['desc'] }}</div>
            </div>
        </div>
    @endfor
    <div class="track-timeline-step">
        <div class="track-timeline-icon active-red">
            <i class="fa-solid fa-circle-xmark"></i>
        </div>
        <div class="track-timeline-content">
            <div class="track-timeline-title text-red-600 font-bold">Laporan Ditolak</div>
            <div class="track-timeline-desc text-red-500">Laporan Anda ditolak dan tidak akan diproses lebih lanjut.</div>
        </div>
    </div>
@else
    @foreach ($steps as $i => $step)
        @php
            // Kuning sampai status aktif, biru jika sudah selesai, abu jika belum
            $isYellow = $i <= $current_index && $current_index < 5;
            $isBlue = $current_index == 5 && $i <= $current_index;
            $iconClass = $isBlue ? 'active-blue' : ($isYellow ? 'active-yellow' : '');
            $lineClass = ($i < $current_index && $current_index < 5) ? 'yellow' : (($current_index == 5 && $i < $current_index) ? '' : '');
            $titleClass = $isYellow ? 'yellow' : '';
        @endphp
        <div class="track-timeline-step">
            <div class="track-timeline-icon {{ $iconClass }}">
                <i class="fa-solid {{ $step['icon'] }}"></i>
            </div>
            <div class="track-timeline-line {{ $lineClass }}"></div>
            <div class="track-timeline-content">
                <div class="track-timeline-title {{ $titleClass }}">{{ $step['title'] }}</div>
                <div class="track-timeline-desc">{{ $step['desc'] }}</div>
            </div>
        </div>
    @endforeach
@endif
                </div>
            </div>

            <!-- Detail Laporan -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold mb-4 text-[#233876]">Detail Laporan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600"><span class="font-semibold">Tanggal Laporan:</span> {{ $report->created_at ? $report->created_at->format('d F Y H:i') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><span class="font-semibold">Status Terakhir:</span> {{ $report->status ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-600"><span class="font-semibold">Deskripsi:</span> {{ $report->deskripsi ?? '-' }}</p>
                    </div>
                    @if(isset($report->user) && !is_null($report->user) && !empty($report->user->name))
                    <div>
                        <p class="text-gray-600"><span class="font-semibold">Pelapor:</span> {{ $report->user->name }}</p>
                    </div>
                    @endif
                    @if($report->foto)
                    <div class="md:col-span-2">
                        <p class="font-semibold text-gray-600 mb-2">Foto/Video:</p>
                        <img src="{{ asset('storage/' . $report->foto) }}" alt="Foto Laporan" class="max-w-full h-auto rounded-lg shadow">
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="w-full flex justify-center">
            <a href="{{ route('track.show') }}" class="btn-kembali">
                Kembali
            </a>
        </div>
    </div>
</div>

@push('scripts')
@endpush

@endsection
