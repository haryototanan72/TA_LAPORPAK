@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8fafc;
    }
    .profile-container {
        max-width: 1000px;
        margin: 60px auto;
        padding: 0 15px;
    }
    .profile-header-card {
        background: linear-gradient(135deg, #002147 0%, #fbb03b 100%);
        color: #fff;
        padding: 40px 20px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 33, 71, 0.15);
        position: relative;
        margin-bottom: 30px;
    }
    .profile-avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 15px auto;
    }
    .profile-avatar-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #ffffff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        background-color: #fff;
    }
    .profile-name {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 4px;
        color: #ffffff;
    }
    .profile-email {
        font-size: 0.95rem;
        opacity: 0.85;
        margin-bottom: 0;
    }
    
    /* Info Card / Gamifikasi */
    .gamification-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        padding: 24px;
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
    }
    .gamification-title {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .gamification-stats {
        background: linear-gradient(135deg, rgba(251, 176, 59, 0.08) 0%, rgba(0, 33, 71, 0.05) 100%);
        border: 1px solid rgba(251, 176, 59, 0.15);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: space-around;
        text-align: center;
        margin-bottom: 16px;
    }
    .stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
    }
    .stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #002147;
    }
    .stat-value.points {
        color: #e28a00;
    }
    .stat-value.title-badge {
        color: #002147;
        font-size: 1.1rem;
    }
    .btn-exchange {
        background-color: #e2e8f0;
        color: #64748b;
        font-weight: 700;
        font-size: 0.9rem;
        border-radius: 10px;
        border: 2px dashed #cbd5e1;
        width: 100%;
        padding: 12px;
        cursor: not-allowed;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    
    /* Form Card */
    .form-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        padding: 30px;
        border: 1px solid #e2e8f0;
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #002147;
        margin-bottom: 24px;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 12px;
    }
    .form-label-custom {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }
    .form-control-custom {
        width: 100%;
        background-color: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .form-control-custom:focus {
        border-color: #fbb03b;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(251, 176, 59, 0.15);
        outline: none;
    }
    .btn-save-custom {
        background: linear-gradient(135deg, #fbb03b 0%, #002147 100%);
        color: #ffffff;
        font-weight: 700;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(0, 33, 71, 0.15);
        transition: all 0.2s ease;
    }
    .btn-save-custom:hover {
        background: linear-gradient(135deg, #002147 0%, #fbb03b 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(0, 33, 71, 0.2);
    }
    .text-error-custom {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 4px;
        font-weight: 500;
    }
</style>

<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-12 p-3 text-center mb-4" style="background-color: #d1e7dd; color: #0f5132;">
            🎉 {{ session('success') }}
        </div>
    @endif

    <!-- Profile Header Card -->
    <div class="profile-header-card">
        <div class="profile-avatar-wrapper">
            @php
                $avatar = Auth::user()->profile_picture
                    ? asset('storage/' . Auth::user()->profile_picture)
                    : asset('assets/img/avatar-cartoon.png');
            @endphp
            <img src="{{ $avatar }}" alt="Avatar" class="profile-avatar-img">
        </div>
        <h3 class="profile-name">{{ Auth::user()->name }}</h3>
        <p class="profile-email"><i class="bi bi-envelope"></i> {{ Auth::user()->email }}</p>
    </div>

    <div class="row">
        <!-- Left Side: Gamifikasi Info -->
        <div class="col-lg-4 mb-4">
            <div class="gamification-card">
                <div class="gamification-title">
                    <i class="bi bi-trophy-fill text-warning"></i>
                    <span>Poin Gamifikasi</span>
                </div>
                
                <div class="gamification-stats">
                    <div>
                        <div class="stat-label">Poin</div>
                        <div class="stat-value points">{{ Auth::user()->points ?? 0 }}</div>
                    </div>
                    <div style="width: 1px; height: 35px; background-color: #e2e8f0;"></div>
                    <div>
                        <div class="stat-label">Gelar</div>
                        <div class="stat-value title-badge">{{ Auth::user()->title ?? 'Pemula' }}</div>
                    </div>
                </div>
                
                <button type="button" class="btn-exchange" disabled>
                    <i class="bi bi-gift"></i>
                    <span>Tukar Poin</span>
                    <span class="badge bg-secondary" style="font-size: 0.65rem; text-transform: uppercase;">Soon</span>
                </button>
            </div>
        </div>

        <!-- Right Side: Edit Profile Form -->
        <div class="col-lg-8 mb-4">
            <div class="form-card">
                <h5 class="form-section-title">Edit Profil Pengguna</h5>
                
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" autocomplete="on">
                    @csrf
                    @method('PATCH')
                    
                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom" for="name">Nama Lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" autocomplete="name" class="form-control-custom">
                            @error('name')<p class="text-error-custom">{{ $message }}</p>@enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom" for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" autocomplete="email" class="form-control-custom">
                            @error('email')<p class="text-error-custom">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- No. Telepon -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom" for="phone_number">No. Telepon</label>
                            <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}" autocomplete="tel" class="form-control-custom">
                            @error('phone_number')<p class="text-error-custom">{{ $message }}</p>@enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom" for="gender">Jenis Kelamin</label>
                            <select id="gender" name="gender" class="form-control-custom">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('gender', Auth::user()->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender', Auth::user()->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')<p class="text-error-custom">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Tanggal Lahir -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom" for="birth_date">Tanggal Lahir</label>
                            <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', Auth::user()->birth_date) }}" class="form-control-custom">
                            @error('birth_date')<p class="text-error-custom">{{ $message }}</p>@enderror
                        </div>

                        <!-- Foto Profil -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom" for="profile_picture">Foto Profil (opsional)</label>
                            <input id="profile_picture" type="file" name="profile_picture" accept="image/*" class="form-control-custom" style="padding: 7px;">
                            @error('profile_picture')<p class="text-error-custom">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-4">
                        <label class="form-label-custom" for="address">Alamat</label>
                        <textarea id="address" name="address" rows="3" class="form-control-custom">{{ old('address', Auth::user()->address) }}</textarea>
                        @error('address')<p class="text-error-custom">{{ $message }}</p>@enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-save-custom">
                            <i class="bi bi-check-circle-fill me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection