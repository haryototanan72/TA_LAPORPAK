@extends('layouts.adminlayout')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Tambah Berita</h1>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                    @error('judul')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori_berita" class="form-label">Kategori</label>
                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori_berita" name="kategori" required style="cursor: pointer; appearance: auto;">
                        <option value="" disabled {{ old('kategori') == '' ? 'selected' : '' }}>Pilih Kategori Berita</option>
                        <option value="Informasi" {{ old('kategori') == 'Informasi' ? 'selected' : '' }}>Informasi</option>
                        <option value="Perbaikan Jalan Rampung" {{ old('kategori') == 'Pemberitahuan jalan telah selesai diperbaiki' ? 'selected' : '' }}>Pemberitahuan jalan telah selesai diperbaiki</option>
                    </select>
                    @error('kategori')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Berita</label>
                    <textarea class="form-control summernote @error('isi') is-invalid @enderror" id="isi" name="isi" rows="10">{{ old('isi') }}</textarea>
                    @error('isi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                    <input type="date" class="form-control @error('tanggal_terbit') is-invalid @enderror" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}" required>
                    @error('tanggal_terbit')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required style="cursor: pointer; appearance: auto;">
                        <option value="" disabled {{ old('status') == '' ? 'selected' : '' }}>Pilih Status</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar (Opsional)</label>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                    <small class="text-muted">Ukuran gambar maksimal 2MB. Format: JPG, JPEG, PNG</small>
                    @error('gambar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Berita
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
            height: 300,
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