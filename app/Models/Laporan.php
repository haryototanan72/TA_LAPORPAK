<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'jenis_laporan',
        'bukti_laporan',
        'lokasi',
        'ciri_khusus',
        'kategori_laporan',
        'deskripsi_laporan',
        'nomor_laporan',
        'user_id', // Tambahkan ini kalau relasi ke user
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    // Relasi ke laporan_petugas berdasarkan laporan_id
    public function laporanPetugas()
    {
        return $this->hasMany(\App\Models\LaporanPetugas::class, 'laporan_id', 'id');
    }
    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    // Relasi ke feedback admin (feedback yang diinput admin)
    public function feedbackAdmin()
    {
        return $this->hasOne(\App\Models\Feedback::class, 'laporan_id')->whereHas('user', function($q){ $q->where('role', 'admin'); });
    }

    // Relasi ke feedback user (feedback yang diinput user/pelapor)
    public function feedbackUser()
    {
        return $this->hasOne(\App\Models\Feedback::class, 'laporan_id')->whereHas('user', function($q){ $q->where('role', 'user'); });
    }

    // Relasi ke feedback (hasOne)
    public function feedback()
    {
        return $this->hasOne(\App\Models\Feedback::class, 'laporan_id');
    }
}
