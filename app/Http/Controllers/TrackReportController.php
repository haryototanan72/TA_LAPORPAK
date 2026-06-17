<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class TrackReportController extends Controller
{
    public function showTrackPage(Request $request)
    {
        $nomor_laporan = $request->query('nomor_laporan') ?? session('nomor_laporan');
        $report = null;
        $alasan_penolakan = null;
        $pesan_diterima = null;

        if ($nomor_laporan) {
            $nomor_laporan = str_replace('"', '', $nomor_laporan);
            $report = Report::where('nomor_laporan', $nomor_laporan)->first();
            
            if ($report) {
                $statusLower = strtolower($report->status);
                if ($statusLower === 'ditolak') {
                    $alasan_penolakan = 'Maaf Laporan Anda Kurang Valid / Ditolak';
                } elseif (in_array($statusLower, ['diterima', 'disetujui', 'diajukan'])) {
                    $pesan_diterima = 'Laporan Anda Disetujui, Silakan Tunggu Prosesnya';
                }
            }
        }

        return view('track-report.index', compact('report', 'alasan_penolakan', 'pesan_diterima', 'nomor_laporan'));
    }

    public function search(Request $request)
    {
        $nomor_laporan = $request->input('nomor_laporan');
        
        // Hapus tanda kutip jika ada
        $nomor_laporan = str_replace('"', '', $nomor_laporan);
        
        $report = Report::where('nomor_laporan', $nomor_laporan)->first();
        
        if ($report) {
            $alasan_penolakan = null;
            $pesan_diterima = null;
            $statusLower = strtolower($report->status);
            
            if ($statusLower === 'ditolak') {
                $alasan_penolakan = 'Maaf Laporan Anda Kurang Valid / Ditolak';
            } elseif (in_array($statusLower, ['diterima', 'disetujui', 'diajukan'])) {
                $pesan_diterima = 'Laporan Anda Disetujui, Silakan Tunggu Prosesnya';
            }

            return view('track-report.index', [
                'report' => $report,
                'alasan_penolakan' => $alasan_penolakan,
                'pesan_diterima' => $pesan_diterima,
                'nomor_laporan' => $nomor_laporan
            ]);
        }
        
        return redirect()->route('track.show')->with('error', 'Nomor laporan tidak ditemukan')->withInput();
    }
}
