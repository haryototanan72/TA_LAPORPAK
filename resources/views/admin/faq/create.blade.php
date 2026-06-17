@extends('layouts.adminlayout')

@section('title', 'Tambah FAQ')

@section('content')
<style>
    .custom-card {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02) !important;
    }
    .card-header-custom {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-title-custom {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15);
    }
</style>

<div class="container-fluid px-0 py-2">
    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="fw-bold text-dark" style="font-size: 1.5rem;">Tambah FAQ Baru</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Buat pertanyaan dan jawaban baru untuk ditampilkan pada halaman bantuan pengguna.</p>
        </div>
        <button 
            type="button" 
            onclick="document.getElementById('faqForm').reset();"
            class="btn btn-outline-primary fw-semibold"
            style="border-radius: 8px; padding: 8px 24px;">
            Reset Form
        </button>
    </div>

    <!-- Error/Validation Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-12 p-3 mb-4" style="background-color: #f8d7da; color: #842029;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card custom-card">
        <div class="card-header-custom">
            <h5 class="card-title-custom">Informasi FAQ</h5>
        </div>
        <div class="card-body p-4">
            <form id="faqForm" action="{{ route('admin.faq.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="question" class="form-label fw-bold text-secondary" style="font-size: 0.95rem;">
                        Pertanyaan
                    </label>
                    <input
                        type="text"
                        name="question"
                        id="question"
                        value="{{ old('question') }}"
                        required
                        class="form-control"
                        style="border-radius:10px; padding:12px 16px; font-size:0.95rem; color:#333; border: 1.5px solid #dbe2eb;"
                        placeholder="Contoh: Bagaimana cara membuat laporan di LaporPak?"
                    >
                    @error('question')
                        <div class="invalid-feedback d-block" style="color:#dc3545;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="answer" class="form-label fw-bold text-secondary" style="font-size: 0.95rem;">
                        Jawaban
                    </label>
                    <textarea
                        name="answer"
                        id="answer"
                        rows="6"
                        required
                        class="form-control"
                        style="border-radius:10px; padding:12px 16px; font-size:0.95rem; color:#333; border: 1.5px solid #dbe2eb; resize:vertical;"
                        placeholder="Contoh: Pengguna hanya perlu menekan tombol 'Lapor!' di dashboard, melengkapi detail data kerusakan jalan beserta bukti foto pendukung, lalu menekan tombol kirim..."
                    >{{ old('answer') }}</textarea>
                    @error('answer')
                        <div class="invalid-feedback d-block" style="color:#dc3545;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons Inside Form Layout -->
                <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.faq.index') }}"
                       class="btn btn-secondary fw-semibold"
                       style="border-radius:10px; padding:10px 30px; background-color: #64748b; border: none; min-width: 120px;">
                        Kembali
                    </a>
                    <button type="submit"
                            class="btn text-white fw-bold border-0"
                            style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 10px; padding: 10px 32px; min-width: 120px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);">
                        Simpan FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
