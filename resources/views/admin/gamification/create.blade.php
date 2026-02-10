@extends('layouts.adminlayout')

@php $selectedLaporanId = $selectedLaporanId ?? null; @endphp

@section('title', 'Tambah Bukti Feedback')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>Tambah Bukti</strong> Feedback</h3>
        </div>

        <div class="col-auto ms-auto text-end">
            <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.feedback.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="laporan_id" class="form-label">Pilih Laporan</label>
                    <select class="form-select" id="laporan_id" name="laporan_id" required {{ $selectedLaporanId ? 'disabled' : '' }}>
                        <option value="">-- Pilih Laporan --</option>
                        @foreach($laporans as $laporan)
                        <option value="{{ $laporan->id }}" {{ (old('laporan_id', $selectedLaporanId) == $laporan->id) ? 'selected' : '' }}>
                            {{ $laporan->nomor_laporan }} - {{ $laporan->kategori }}
                        </option>
                        @endforeach
                    </select>
                    @if($selectedLaporanId)
                        <input type="hidden" name="laporan_id" value="{{ $selectedLaporanId }}">
                    @endif
                </div>

                <div class="mb-3">
                    <label for="file_proof" class="form-label">Bukti Feedback (Gambar/PDF)</label>
                    <input type="file" class="form-control" id="file_proof" name="file_proof" accept=".jpg,.jpeg,.png,.pdf" required>
                    <small class="text-muted">Format yang diizinkan: JPG, JPEG, PNG, PDF. Ukuran maksimal: 2MB</small>
                </div>

                <!-- Input User ID (otomatis dari admin yang login) -->
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
