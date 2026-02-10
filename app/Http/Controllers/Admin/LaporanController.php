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

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan (Admin)
     */
    public function index(Request $request)
    {
        $laporan = Laporan::query();

        if ($request->filled('status')) {
            $laporan->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $laporan->orderBy(
                'created_at',
                $request->tanggal === 'terlama' ? 'asc' : 'desc'
            );
        } else {
            $laporan->orderBy('created_at', 'desc');
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'prioritas':
                    $laporan->orderBy('prioritas', 'desc');
                    break;
                case 'status':
                    $laporan->orderBy('status');
                    break;
            }
        }

        $laporans = $laporan->paginate(10);
        return view('admin.laporan.index', compact('laporans'));
    }

    /**
     * Menyimpan laporan baru (USER) + GAMIFIKASI
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori'        => 'required',
            'lokasi'          => 'required|string',
            'deskripsi'       => 'required|string',
            'jenis_laporan'   => 'required|in:Privat,Publik',
            'bukti_laporan'   => 'required|file|mimes:jpg,jpeg,png,pdf',
            'ciri_khusus'     => 'nullable|string',
        ]);

        $buktiPath = $request->file('bukti_laporan')
            ->store('laporan', 'public');

        $laporan = Laporan::create([
            'user_id'        => Auth::id(),
            'jenis_laporan'  => $request->jenis_laporan,
            'bukti_laporan'  => $buktiPath,
            'lokasi'         => $request->lokasi,
            'ciri_khusus'    => $request->ciri_khusus,
            'kategori'       => $request->kategori,
            'deskripsi'      => $request->deskripsi,
            'nomor_laporan'  => 'LP-' . strtoupper(Str::random(8)),
            'status'         => 'diajukan',
        ]);

        // Gamifikasi
        $user = Auth::user();
        $user->points += 10;
        $user->title = GamificationHelper::getTitle($user->points);
        $user->save();

        return back()->with('success', 'Laporan berhasil dikirim! +10 poin 🎉');
    }

    /**
     * Update status laporan (Admin)
     */
    public function updateStatus(Request $request, $nomor_laporan)
    {
        $request->validate([
            'status' => 'required|in:diajukan,diverifikasi,diterima,ditolak,ditindaklanjuti,ditanggapi,selesai'
        ]);

        $laporan = Laporan::where('nomor_laporan', $nomor_laporan)
            ->with('user')
            ->firstOrFail();

        $laporan->status = $request->status;
        $laporan->save();

        if ($laporan->user) {
            $laporan->user->notify(
                new LaporanStatusUpdated($laporan)
            );
        }

        $complaint = Complaint::where('name', $laporan->nomor_laporan)->first();
        if ($complaint) {
            $complaint->status = $request->status;
            $complaint->save();
        }

        return back()->with('success', 'Status laporan berhasil diperbarui');
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
     * Verifikasi & Kirim ke Instansi (EMAIL)
     */
    public function verifyAndSend(Laporan $laporan)
{
    if ($laporan->status !== 'diverifikasi') {
        return back()->with('error', 'Laporan harus diverifikasi terlebih dahulu.');
    }

    // Generate PDF
    $pdf = Pdf::loadView('pdf.laporan', [
        'laporan' => $laporan
    ]);

    // Kirim Email ke Instansi
    Mail::to(config('laporpak.instansi_email'))
    ->send(new LaporanTerkirim($laporan, $pdf));

    // Update status laporan
    $laporan->update([
        'status'      => 'dikirim',
        'verified_at' => now(),
        'sent_at'     => now(),
    ]);

    return redirect()
        ->route('admin.laporan.detail', $laporan->nomor_laporan)
        ->with('success', 'Laporan berhasil dikirim ke instansi.');
}
}
