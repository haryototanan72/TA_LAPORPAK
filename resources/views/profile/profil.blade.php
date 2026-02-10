@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f8fafc;
    }
    .profile-header {
        background: linear-gradient(90deg, #002147 0%, #fbb03b 100%);
        color: #fff;
        padding: 36px 0 60px 0;
        text-align: center;
        border-radius: 0 0 32px 32px;
        margin-bottom: 0;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        position: relative;
        z-index: 1;
    }
    .profile-avatar {
        width: 128px;
        height: 128px;
        object-fit: cover;
        border-radius: 50%;
        border: 6px solid #fff;
        margin-top: -64px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        background: #fff;
        position: absolute;
        left: 50%;
        transform: translateX(-50%) translateY(60px);
        z-index: 2;
    }
    .profile-form {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem 2rem 2rem;
        max-width: 520px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 100px;
        position: relative;
        z-index: 3;
    }
    .profile-form label {
        color: #002147;
        font-weight: 500;
    }
    .profile-form input,
    .profile-form select,
    .profile-form textarea {
        background: #fbb03b22;
        border: 1.5px solid #002147;
        color: #002147;
        font-weight: 500;
    }
    .profile-form input:focus,
    .profile-form select:focus,
    .profile-form textarea:focus {
        border-color: #fbb03b;
        background: #fffbe8;
        outline: none;
    }
    .profile-form .btn-save {
        background: linear-gradient(90deg, #fbb03b 0%, #002147 100%);
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2.5rem;
        font-size: 1.1rem;
        transition: background 0.2s;
        margin-top: 1.5rem;
    }
    .profile-form .btn-save:hover {
        background: linear-gradient(90deg, #002147 0%, #fbb03b 100%);
        color: #fff;
    }
</style>

<div class="profile-header">
    <h1 class="text-3xl font-bold mb-2">Profil Pengguna</h1>
    <p class="text-lg opacity-90 mb-0">Data lengkap akun Anda</p>
    @php
        $avatar = Auth::user()->profile_picture
            ? asset('storage/' . Auth::user()->profile_picture)
            : asset('assets/img/avatar-cartoon.png');
    @endphp
    <img src="{{ $avatar }}" alt="Avatar" class="profile-avatar">
</div>
<div class="profile-form">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" autocomplete="on">
        @csrf
        @method('PATCH')
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" autocomplete="name" class="w-full px-3 py-2 rounded">
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" autocomplete="email" class="w-full px-3 py-2 rounded">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone_number">No. Telepon</label>
                <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}" autocomplete="tel" class="w-full px-3 py-2 rounded">
                @error('phone_number')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="gender">Jenis Kelamin</label>
                <select id="gender" name="gender" class="w-full px-3 py-2 rounded">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('gender', Auth::user()->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender', Auth::user()->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="birth_date">Tanggal Lahir</label>
                <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', Auth::user()->birth_date) }}" class="w-full px-3 py-2 rounded">
                @error('birth_date')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="address">Alamat</label>
                <textarea id="address" name="address" rows="2" class="w-full px-3 py-2 rounded">{{ old('address', Auth::user()->address) }}</textarea>
                @error('address')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="profile_picture">Foto Profil (opsional)</label>
                <input id="profile_picture" type="file" name="profile_picture" accept="image/*" class="w-full">
                @error('profile_picture')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn-save">Simpan Perubahan</button>
        </div>
    </form>
</div>
@if(session('success'))
    <div class="bg-green-500 text-white p-3 rounded mb-4 text-center mt-4">
        {{ session('success') }}
    </div>
@endif

@endsection
@section('scripts')
<script>
    // No script needed
</script>