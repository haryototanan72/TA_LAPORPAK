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

        // Gamifikasi (hanya saat laporan dibuat)
        $user = Auth::user();
        $user->points += 5;
        $user->title = GamificationHelper::getTitle($user->points);
        $user->save();
        
        return back()->with('success', 'Laporan berhasil dikirim! +5 poin 🎉');
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
        $oldStatus = $laporan->status;
        $laporan->status = $request->status;
        $laporan->save();
        
        $user = $laporan->user;

    if ($user) {

        // Bonus jika diverifikasi pertama kali
        if ($request->status === 'diverifikasi' && $oldStatus !== 'diverifikasi') {
            $user->points += 10;
        }

        // Penalti jika ditolak pertama kali (optional)
        if ($request->status === 'ditolak' && $oldStatus !== 'ditolak') {
            $user->points -= 5;
        }

        $user->title = GamificationHelper::getTitle($user->points);
        $user->save();
    }

        if ($laporan->user && $laporan->status === 'diverifikasi') {
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
    $imagePath = storage_path('app/public/'.$laporan->bukti_laporan);

    $imageBase64 = null;

    if (file_exists($imagePath)) {
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
        $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
    }
// Ambil koordinat dari kolom lokasi
$googleMapsUrl = null;

    if (!empty($laporan->lokasi)) {
        list($lat, $lng) = array_map('trim', explode(',', $laporan->lokasi));
        $googleMapsUrl = "https://www.google.com/maps?q={$lat},{$lng}";
    }
   $pdf = Pdf::loadView('pdf.laporan', [
    'laporan' => $laporan,
    'imageBase64' => $imageBase64,
    'googleMapsUrl' => $googleMapsUrl
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
