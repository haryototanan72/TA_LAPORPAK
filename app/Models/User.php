<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'gender',
        'birth_date',
        'address',
        'profile_picture',

        // 🔹 GAMIFIKASI & ROLE
        'role',
        'points',
        'title',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* =====================================================
     |  ROLE HELPER
     ===================================================== */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /* =====================================================
     |  RELATION
     ===================================================== */

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'user_id');
    }
}
