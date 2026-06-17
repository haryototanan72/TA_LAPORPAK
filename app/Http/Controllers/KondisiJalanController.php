<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class KondisiJalanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::whereNotNull('lokasi_awal')
            ->whereNotNull('lokasi_akhir')
            ->get();

        $data = $laporans->map(function ($laporan) {
            return [
                'lokasi_awal' => $laporan->lokasi_awal,
                'lokasi_akhir' => $laporan->lokasi_akhir,
                'status' => $laporan->status,
                'kategori' => $laporan->kategori ?? $laporan->kategori_laporan,
                'nomor_laporan' => $laporan->nomor_laporan,
                'deskripsi' => $laporan->deskripsi ?? $laporan->deskripsi_laporan,
            ];
        });

        return view('petakondisi.index', compact('data'));
    }
}
