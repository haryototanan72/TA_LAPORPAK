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

        // Upload bukti laporan
        $buktiPath = $request->file('bukti_laporan')
            ->store('laporan', 'public');

        // Simpan laporan
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

        // === GAMIFIKASI ===
        $users = Auth::user(); 
        $users->points += 10;
        $users->title = GamificationHelper::getTitle($users->points);
        $users->save();

        return redirect()->back()
            ->with('success', 'Laporan berhasil dikirim! +10 poin 🎉');
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

        return redirect()->back()
            ->with('success', 'Status laporan berhasil diperbarui');
    }

    /**
     * Detail laporan (Admin)
     */
    public function detail($nomor_laporan)
    {
        $laporan = Laporan::with([
            'user',
            'laporanPetugas' => function ($q) {
                $q->latest('updated_at')->limit(1);
            }
        ])->where('nomor_laporan', $nomor_laporan)
          ->firstOrFail();

        return view('admin.laporan.detaillaporan', compact('laporan'));
    }
}
