<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function showForm(Request $request)
    {
        $success = $request->query('success');
        $errors = $request->query('errors');

        return view('laporan.form_laporan', compact('success', 'errors'));
    }

    public function submitLaporan(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'jenis_laporan' => 'required',
            'bukti_laporan' => 'required|file|max:51200',
            'lokasi' => 'required',
            'ciri_khusus_lokasi' => 'nullable', // Ubah 'optional' menjadi 'nullable'
            'kategori_laporan' => 'required',
            'deskripsi_laporan' => 'required',
            'ceklis' => 'required', // Validasi checkbox persetujuan
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Lengkapi kolom yang kosong',
                'errors' => $validator->errors()
            ], 400);
        }

        // Simpan file bukti laporan
        $file = $request->file('bukti_laporan');
        $path = $file->store('bukti_laporan', 'public');

        // Generate nomor laporan unik
        $nomor_laporan = 'LAP' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        try {
            // Buat laporan baru
            $laporan = new Laporan();
            $laporan->nomor_laporan = $nomor_laporan;
            $laporan->jenis_laporan = $request->jenis_laporan;
            $laporan->lokasi = $request->lokasi;
            $laporan->ciri_khusus = $request->ciri_khusus_lokasi; // Perbaiki nama field
            $laporan->kategori_laporan = $request->kategori_laporan;
            $laporan->deskripsi_laporan = $request->deskripsi_laporan;
            $laporan->bukti_laporan = $path;
            $laporan->save();

            // Jika request expects JSON (AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Laporan berhasil dikirim!',
                    'nomor_laporan' => $nomor_laporan
                ], 200);
            }
            // Jika submit biasa (non-AJAX)
            return redirect()->route('laporan.form_laporan')->with('nomor_laporan', $nomor_laporan);

        } catch (\Exception $e) {
            // Jika terjadi kesalahan, hapus file yang sudah diupload
            Storage::delete('public/' . $path);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Gagal menyimpan laporan ke database',
                    'error' => $e->getMessage()
                ], 500);
            }
            return redirect()->route('laporan.form_laporan')->with('error', 'Gagal menyimpan laporan ke database: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan daftar history laporan milik user yang sedang login.
     */
    public function index(Request $request)
    {
        $laporans = Laporan::where('user_id', Auth::id())
            ->with(['feedbackAdmin.user', 'feedbackUser.user'])
            ->latest()->get();
        return view('laporan.history', compact('laporans'));
    }

    /**
     * Menampilkan detail laporan.
     */
    public function show($id)
{
    $laporan = Laporan::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    return view('laporan.show', compact('laporan'));
}

    /**
     * Menampilkan form edit laporan.
     */
    public function edit($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);
        return view('laporan.edit', compact('laporan'));
    }

    /**
     * Update laporan milik user.
     */
    public function update(Request $request, $id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);
        $validator = Validator::make($request->all(), [
            'jenis_laporan' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $laporan->jenis_laporan = $request->jenis_laporan;
        $laporan->lokasi = $request->lokasi;
        $laporan->kategori = $request->kategori;
        $laporan->deskripsi = $request->deskripsi;
        $laporan->ciri_khusus = $request->ciri_khusus; // Menambahkan update untuk ciri_khusus
        if ($request->hasFile('bukti_laporan')) {
            $file = $request->file('bukti_laporan');
            $path = $file->store('bukti_laporan', 'public');
            $laporan->bukti_laporan = $path;
        }
        $laporan->save();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diupdate!')->with('swal', [
            'title' => 'Berhasil!',
            'text' => 'Laporan berhasil diupdate!',
            'icon' => 'success'
        ]);
    }

    /**
     * Hapus laporan milik user.
     */
    public function destroy($id)
    {
        // Cek apakah laporan ada dan milik user yang sedang login
        $laporan = Laporan::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$laporan) {
            return redirect()->route('laporan.index')->with('error', 'Laporan tidak ditemukan!');
        }

        // Hapus file bukti laporan jika ada
        if ($laporan->bukti_laporan) {
            $path = public_path('uploads/laporan/' . $laporan->bukti_laporan);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Simpan feedback dari user untuk laporan tertentu
     */
    public function feedbackUser(Request $request, $id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);

        // Pastikan laporan sudah selesai dan sudah ada feedback admin
        if ($laporan->status !== 'selesai' || !$laporan->feedbackAdmin) {
            return redirect()->back()->with('error', 'Feedback hanya dapat diberikan jika laporan sudah selesai dan ada bukti perbaikan dari admin.');
        }

        // Cek jika sudah ada feedback user
        if ($laporan->feedbackUser) {
            return redirect()->back()->with('error', 'Anda sudah memberikan feedback untuk laporan ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'pesan' => 'required|string',
        ]);

        $feedback = new \App\Models\Feedback();
        $feedback->laporan_id = $laporan->id;
        $feedback->user_id = Auth::id();
        $feedback->rating = $request->rating;
        $feedback->pesan = $request->pesan;
        $feedback->kategori = $laporan->kategori_laporan ?? '-';
        $feedback->save();

        return redirect()->route('laporan.index')->with('success', 'Feedback berhasil dikirim!');
    }

    /**
     * Tampilkan halaman form feedback user (bukan modal)
     */
    public function feedbackUserForm($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);
        // Pastikan laporan sudah selesai dan sudah ada feedback admin
        if ($laporan->status !== 'selesai' || !$laporan->feedbackAdmin) {
            return redirect()->back()->with('error', 'Feedback hanya dapat diberikan jika laporan sudah selesai dan ada bukti perbaikan dari admin.');
        }
        // Cek jika sudah ada feedback user
        if ($laporan->feedbackUser) {
            return redirect()->back()->with('error', 'Anda sudah memberikan feedback untuk laporan ini.');
        }
        return view('laporan.feedback_user_form', compact('laporan'));
    }
}