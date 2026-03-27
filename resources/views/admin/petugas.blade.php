@extends('layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Petugas</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPetugasModal" dusk="open-tambah-petugas-modal">Tambahkan Petugas Baru +</button>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="row" id="petugas-list">
        @forelse($petugas as $item)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('assets/img/default-profile.png') }}" class="rounded-circle mb-3" width="90" height="90" style="object-fit:cover;">
                    <h5 class="fw-bold mb-0">{{ $item->nama }}</h5>
                    <div class="mb-2 text-muted">{{ $item->kontak ?? '-' }}</div>
                    <div class="d-flex justify-content-center gap-2">
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#kirimPetugasModal{{ $item->id }}" dusk="kirim-petugas-btn-{{ $item->id }}">Kirim Petugas</button>
    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPetugasModal{{ $item->id }}">Edit</button>
    <form action="{{ route('admin.petugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus petugas ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Delete</button>
    </form>
</div>

<!-- Modal Kirim Petugas -->
<div class="modal fade" id="kirimPetugasModal{{ $item->id }}" tabindex="-1" aria-labelledby="kirimPetugasModalLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.petugas.store', $item->id) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="kirimPetugasModalLabel{{ $item->id }}">Kirim Tugas ke Petugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nomor_laporan{{ $item->id }}" class="form-label">Nomor Laporan</label>
            <input type="text" class="form-control" name="nomor_laporan" id="nomor_laporan{{ $item->id }}" required placeholder="Masukkan nomor laporan">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" dusk="kirim-tugas-submit">Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editPetugasModal{{ $item->id }}" tabindex="-1" aria-labelledby="editPetugasModalLabel{{ $item->id }}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('admin.petugas.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                  <h5 class="modal-title" id="editPetugasModalLabel{{ $item->id }}">Edit Petugas</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="nama{{ $item->id }}" class="form-label">Nama Petugas</label>
                    <input type="text" class="form-control" name="nama" id="nama{{ $item->id }}" value="{{ old('nama', $item->nama) }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="kontak{{ $item->id }}" class="form-label">Kontak</label>
                    <input type="text" class="form-control" name="kontak" id="kontak{{ $item->id }}" value="{{ old('kontak', $item->kontak) }}">
                  </div>
                  <div class="mb-3">
                    <label for="foto{{ $item->id }}" class="form-label">Foto</label>
                    <input type="file" class="form-control" name="foto" id="foto{{ $item->id }}">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">Belum ada data petugas.</div>
        @endforelse
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addPetugasModal" tabindex="-1" aria-labelledby="addPetugasModalLabel" aria-hidden="true" dusk="modal-tambah-petugas">
      <div class="modal-dialog">
        <div class="modal-content">
          {{-- Tampilkan error validasi jika ada --}}
          @if($errors->any())
            <div class="alert alert-danger m-3">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form action="{{ route('admin.petugas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="addPetugasModalLabel">Tambah Petugas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Petugas</label>
                <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" required>
              </div>
              <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto">
              </div>
              <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" class="form-control" name="kontak" id="kontak" value="{{ old('kontak') }}">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary" dusk="submit-tambah-petugas">Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
