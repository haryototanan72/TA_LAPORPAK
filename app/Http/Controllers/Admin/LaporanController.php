<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Complaint;
use App\Helpers\GamificationHelper;
use App\Notifications\LaporanStatusUpdated;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaporanTerkirim;
use Illuminate\Support\Facades\Storage;
// Tambahan untuk Export
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan (Admin)
     */
    public function index(Request $request)
    {
        $laporan = Laporan::query();

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $laporan->where('status', $request->status);
        }

        // --- TAMBAHAN BARU: Filter berdasarkan Bulan ---
        if ($request->filled('bulan')) {
            // $request->bulan akan berisi string format "YYYY-MM" (contoh: 2026-05)
            $tahunBulan = explode('-', $request->bulan);
            if (count($tahunBulan) === 2) {
                $laporan->whereYear('created_at', $tahunBulan[0])
                        ->whereMonth('created_at', $tahunBulan[1]);
            }
        }

        // Filter Urutan Tanggal
        if ($request->filled('tanggal')) {
            $laporan->orderBy(
                'created_at',
                $request->tanggal === 'terlama' ? 'asc' : 'desc'
            );
        } else {
            $laporan->orderBy('created_at', 'desc');
        }

        // --- LOGIKA EXPORT ---
        // Jika tombol export ditekan
        if ($request->has('export') && $request->export == 'excel') {
            // Nama file digenerate berdasarkan waktu
            $filename = 'Rekap_Laporan_PU_' . date('Ymd_His') . '.xlsx';
            
            // Kita parsing query yang sudah terfilter ke class Export
            return Excel::download(new LaporanExport($laporan->get()), $filename);
        }

        // Tampilan biasa
        // Jangan lupa withQueryString() agar pagination tetap nyangkut filternya
        $laporans = $laporan->paginate(10)->withQueryString();
        return view('admin.laporan.index', compact('laporans'));
    }

    /**
     * Update status laporan (Admin)
     */
    public function updateStatus(Request $request, $nomor_laporan)
    {
        // Sesuaikan validasi dengan 5 status yang baru
        $request->validate([
            'status' => 'required|in:diajukan,diverifikasi,ditolak,ditindaklanjuti,selesai'
        ]);

        $laporan = Laporan::where('nomor_laporan', $nomor_laporan)
            ->with('user')
            ->firstOrFail();

        $oldStatus = $laporan->status;
        $laporan->status = $request->status;
        $laporan->save();
        
        $user = $laporan->user;

        if ($user) {
            // Poin +10 jika diverifikasi
            if ($request->status === 'diverifikasi' && $oldStatus !== 'diverifikasi') {
                $user->points += 10;
            }

            // Poin -5 jika ditolak (Hukuman laporan tidak valid), data tetap ada tidak dihapus otomatis
            if ($request->status === 'ditolak' && $oldStatus !== 'ditolak') {
                $user->points -= 5;
            }

            $user->title = GamificationHelper::getTitle($user->points);
            $user->save();
        }

        // Kirim notifikasi jika diverifikasi
        if ($laporan->user && $laporan->status === 'diverifikasi') {
            $laporan->user->notify(new LaporanStatusUpdated($laporan));
        }

        // Sinkronisasi dengan tabel Complaint jika ada
        $complaint = Complaint::where('name', $laporan->nomor_laporan)->first();
        if ($complaint) {
            $complaint->status = $request->status;
            $complaint->save();
        }

        return back()->with('success', 'Status laporan berhasil diperbarui menjadi ' . $request->status);
    }

    /**
     * Detail laporan (Admin)
     */
    public function detail($nomor_laporan)
    {
        $laporan = Laporan::with([
            'user',
            'laporanPetugas' => fn ($q) => $q->latest()->limit(1)
        ])
        ->where('nomor_laporan', $nomor_laporan)
        ->firstOrFail();

        return view('admin.laporan.detaillaporan', compact('laporan'));
    }

    /**
     * Menghapus laporan secara manual (Admin)
     */
    public function destroy($id)
    {
        // Parameter diubah ke ID karena view mempassing $laporan->id
        $laporan = Laporan::findOrFail($id);

        // Hapus file bukti secara fisik agar storage hosting tidak penuh
        if ($laporan->bukti_laporan) {
            Storage::disk('public')->delete($laporan->bukti_laporan);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus secara permanen.');
    }

    /**
     * Verifikasi & Kirim ke Instansi (EMAIL + PDF)
     */
    public function verifyAndSend(Laporan $laporan)
    {
        if ($laporan->status !== 'diverifikasi') {
            return back()->with('error', 'Laporan harus diverifikasi terlebih dahulu.');
        }

        // 1. Olah Gambar untuk PDF (Base64)
        $imagePath = storage_path('app/public/' . $laporan->bukti_laporan);
        $imageBase64 = null;

        if (file_exists($imagePath) && is_file($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
            $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
        }

        // 2. FIX: Olah Koordinat menjadi Link Google Maps agar PDF tidak error
        $googleMapsUrl = "-"; 
        
        // Coba periksa dari lokasi_awal dulu
        if (!empty($laporan->lokasi_awal)) {
            $coords = explode(',', $laporan->lokasi_awal);
            if(count($coords) == 2) {
                $lat = trim($coords[0]);
                $lng = trim($coords[1]);
                $googleMapsUrl = "https://www.google.com/maps?q={$lat},{$lng}";
            }
        } 
        // Fallback ke kolom lokasi lama
        elseif (!empty($laporan->lokasi)) {
            $coords = explode(',', $laporan->lokasi);
            if(count($coords) == 2) {
                $lat = trim($coords[0]);
                $lng = trim($coords[1]);
                $googleMapsUrl = "https://www.google.com/maps?q={$lat},{$lng}";
            }
        }

        // 3. Generate PDF
        $pdf = Pdf::loadView('pdf.laporan', [
            'laporan' => $laporan,
            'imageBase64' => $imageBase64,
            'googleMapsUrl' => $googleMapsUrl
        ]);

        try {
            // 4. Kirim Email ke Instansi
            Mail::to(config('laporpak.instansi_email'))
                ->send(new LaporanTerkirim($laporan, $pdf));

            // Jika dikirim ke instansi berarti mulai ditindaklanjuti
            $laporan->update([
                'status'      => 'ditindaklanjuti',
                'verified_at' => now(),
                'sent_at'     => now(),
            ]);

            return redirect()
                ->route('admin.laporan.detail', $laporan->nomor_laporan)
                ->with('success', 'Laporan berhasil dikirim ke instansi dan status diubah menjadi Ditindaklanjuti.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}