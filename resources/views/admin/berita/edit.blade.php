@extends('layouts.adminlayout')

@section('title', 'Edit Berita')

@section('head')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15);
    }
    .note-editor.note-frame {
        border: 1.5px solid #dbe2eb !important;
        border-radius: 10px !important;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0 py-2">
    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="fw-bold text-dark" style="font-size: 1.5rem;">Edit Berita</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Perbarui konten atau publikasikan draf berita lama agar warga mendapatkan informasi terbaru.</p>
        </div>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-primary fw-semibold" style="border-radius: 8px; padding: 8px 24px;">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
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
            <h5 class="card-title-custom">Konten Berita</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="judul" class="form-label fw-bold text-secondary" style="font-size: 0.95rem;">Judul Berita</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required style="border-radius:10px; padding:12px 16px; font-size:0.95rem; color:#333; border: 1.5px solid #dbe2eb;" placeholder="Masukkan judul artikel...">
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="kategori_berita" class="form-label fw-bold text-secondary" style="font-size: 0.95rem;">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori_berita" name="kategori" required style="border-radius:10px; padding:12px 16px; font-size:0.95rem; color:#333; border: 1.5px solid #dbe2eb; cursor: pointer; appearance: auto;">
                            <option value="" disabled>Pilih Kategori Berita</option>
                            <option value="Informasi" {{ old('kategori', $berita->kategori) == 'Informasi' ? 'selected' : '' }}>Informasi</option>
                            <option value="Pemberitahuan jalan telah selesai diperbaiki" {{ old('kategori', $berita->kategori) == 'Pemberitahuan jalan telah selesai diperbaiki' ? 'selected' : '' }}>Pemberitahuan jalan telah selesai diperbaiki</option>
                        </select>
                        @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="tanggal_terbit" class="form-label fw-bold text-secondary" style="font-size: 0.95rem;">Tanggal Terbit</label>
                        <input type="date" class="form-control @error('tanggal_terbit') is-invalid @enderror" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit', $berita->tanggal_terbit->format('Y-m-d')) }}" required style="border-radius:10px; padding:12px 16px; font-size:0.95rem; color:#333; border: 1.5px solid #dbe2eb;">
                        @error('tanggal_terbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="isi" class="form-label fw-bold text-secondary" style="font-size: 0.95rem;">Isi Berita</label>
                    <textarea class="form-control summernote @error('isi') is-invalid @enderror" id="isi" name="isi" rows="10">{{ old('isi', $berita->isi) }}</textarea>
                    @error('isi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label fw-bold text-secondary" style="font-size: 0.95rem;">Status Publikasi</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required style="border-radius:10px; padding:12px 16px; font-size:0.95rem; color:#333; border: 1.5px solid #dbe2eb;">
                            <option value="">Pilih Status</option>
                            <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
                            <option value="publish" {{ old('status', $berita->status) == 'publish' ? 'selected' : '' }}>Publish (Tampilkan ke Publik)</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="gambar" class="form-label fw-bold text-secondary" style="font-size: 0.95rem;">Ganti Gambar Utama (Opsional)</label>
                        @if($berita->gambar)
                        <div class="mb-2">
                            <span class="d-block text-muted small mb-1">Gambar saat ini:</span>
                            <img src="{{ Storage::url($berita->gambar) }}" alt="Gambar" class="img-thumbnail rounded shadow-sm mb-2" style="max-height: 120px; object-fit: cover; border: 1px solid #e2e8f0;">
                        </div>
                        @endif
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*" style="border-radius:10px; padding:12px 16px; font-size:0.95rem; color:#333; border: 1.5px solid #dbe2eb;">
                        <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin merubah gambar. Ukuran maks 2MB. Format: JPG, JPEG, PNG</small>
                        @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.berita.index') }}"
                       class="btn btn-secondary fw-semibold"
                       style="border-radius:10px; padding:10px 30px; background-color: #64748b; border: none; min-width: 120px;">
                        Kembali
                    </a>
                    <button type="submit"
                            class="btn text-white fw-bold border-0"
                            style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 10px; padding: 10px 32px; min-width: 120px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);">
                        Perbarui Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 350,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endsection
