<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class LaporanPublikController extends Controller
{
    public function index()
    {
        $laporan = Laporan::where('jenis_laporan', 'Publik')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        return view('laporan.index', [
            'laporan' => $laporan,
            'menunggu' => Laporan::where('status', 'Menunggu')->count(),
            'selesai' => Laporan::where('status', 'Selesai')->count(),
            'ditolak' => Laporan::where('status', 'Ditolak')->count()
        ]);
    }

    public function submit(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis_laporan' => 'required|in:Privat,Publik',
            'bukti_laporan' => 'required|file|mimes:jpg,jpeg,png,mp4|max:51200', // max 50MB
            'lokasi' => 'required|string|max:255',
            'kategori_laporan' => 'required|in:Jalan Rusak,Jembatan Rusak,Banjir',
            'deskripsi_laporan' => 'required|string|max:1000',
            'ceklis' => 'required|accepted',
        ]);

        // Simpan file ke storage (public/bukti)
        $filePath = $request->file('bukti_laporan')->store('bukti', 'public');

        // Generate nomor laporan unik
        $nomorLaporan = 'LPR-' . strtoupper(Str::random(8));

        // Simpan ke database
        $laporan = new Laporan();
        $laporan->user_id = Auth::id(); // optional jika ada user login
        $laporan->jenis_laporan = $request->jenis_laporan;
        $laporan->bukti_laporan = $filePath;
        $laporan->lokasi = $request->lokasi;
        $laporan->ciri_khusus = $request->ciri_khusus_lokasi ?? null;
        $laporan->kategori = $request->kategori_laporan;
        $laporan->deskripsi = $request->deskripsi_laporan;
        $laporan->nomor_laporan = $nomorLaporan;
        $laporan->status = 'diajukan'; // default status awal
        $laporan->save();

        // Beri response sukses
        return response()->json([
            'message' => 'Laporan berhasil dikirim',
            'nomor_laporan' => $nomorLaporan
        ]);
    }
}
