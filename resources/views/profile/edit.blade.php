<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @extends('layouts.app')

                    @section('content')
                    <div class="container py-4">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')

                                            <div class="row">
                                                <!-- Profile Picture Section -->
                                                <div class="col-md-4 text-center mb-4">
                                                    <div class="position-relative d-inline-block">
                                                        @if($user->profile_picture)
                                                            <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                                                 alt="Profile Picture" 
                                                                 class="rounded-circle img-fluid mb-3"
                                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                                        @else
                                                            <i class="fas fa-user-circle fa-2x" style="color: #6c757d;"></i>
                                                                 alt="Default Avatar" 
                                                                 class="rounded-circle img-fluid mb-3"
                                                                 style="width: 150px; height: 150px; object-fit: cover; background-color: #f8f9fa;">
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="file" 
                                                               name="profile_picture" 
                                                               class="form-control form-control-sm" 
                                                               accept="image/*">
                                                    </div>
                                                </div>

                                                <!-- Profile Information Section -->
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <input type="text" 
                                                               class="form-control @error('name') is-invalid @enderror" 
                                                               name="name" 
                                                               value="{{ old('name', $user->name) }}" 
                                                               required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" 
                                                               class="form-control @error('email') is-invalid @enderror" 
                                                               name="email" 
                                                               value="{{ old('email', $user->email) }}" 
                                                               required>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">No. Telepon</label>
                                                        <input type="text" 
                                                               class="form-control @error('phone_number') is-invalid @enderror" 
                                                               name="phone_number" 
                                                               value="{{ old('phone_number', $user->phone_number) }}">
                                                        @error('phone_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <select class="form-select @error('gender') is-invalid @enderror" 
                                                                name="gender">
                                                            <option value="">Pilih Jenis Kelamin</option>
                                                            <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>
                                                                Laki-laki
                                                            </option>
                                                            <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>
                                                                Perempuan
                                                            </option>
                                                        </select>
                                                        @error('gender')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <input type="date" 
                                                               class="form-control @error('birth_date') is-invalid @enderror" 
                                                               name="birth_date" 
                                                               value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}">
                                                        @error('birth_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                                  name="address" 
                                                                  rows="3">{{ old('address', $user->address) }}</textarea>
                                                        @error('address')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="d-flex gap-2">
                                                        <button type="submit" 
                                                                class="btn" 
                                                                style="background-color: #fbb03b; color: white;">
                                                            Simpan Perubahan
                                                        </button>
                                                        <a href="{{ route('laporan.form_laporan') }}" 
                                                           class="btn btn-light">
                                                            Batal
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                    .form-control:focus,
                    .form-select:focus {
                        border-color: #fbb03b;
                        box-shadow: 0 0 0 0.25rem rgba(251, 176, 59, 0.25);
                    }

                    .btn-light:hover {
                        background-color: #e9ecef;
                    }
                    </style>
                    @endsection
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
