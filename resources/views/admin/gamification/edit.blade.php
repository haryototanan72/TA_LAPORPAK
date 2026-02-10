@extends('layouts.adminlayout')

@section('title', 'Edit Bukti Feedback')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>Edit Bukti</strong> Feedback</h3>
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
            <form action="{{ route('admin.feedback.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nomor Laporan</label>
                    <input type="text" class="form-control" value="{{ $laporan->nomor_laporan }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" class="form-control" value="{{ $laporan->kategori }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="current_file" class="form-label">Bukti Feedback Saat Ini</label>
                    <div class="mb-2">
                        @if(pathinfo($laporan->feedback_file, PATHINFO_EXTENSION) == 'pdf')
                            <a href="{{ asset('storage/' . $laporan->feedback_file) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="align-middle" data-feather="file-text"></i> Lihat PDF
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $laporan->feedback_file) }}" alt="Bukti Feedback" class="img-thumbnail" style="max-height: 200px;">
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file_proof" class="form-label">Ganti Bukti Feedback</label>
                    <input type="file" class="form-control" id="file_proof" name="file_proof" accept=".jpg,.jpeg,.png,.pdf">
                    <small class="text-muted">Format yang diizinkan: JPG, JPEG, PNG, PDF. Ukuran maksimal: 2MB</small>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
