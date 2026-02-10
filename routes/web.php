<?php
// User Controllers
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TrackReportController;
use App\Http\Controllers\KondisiJalanController;
use App\Http\Controllers\LaporanPublikController;
use App\Http\Controllers\UserLaporanController;
use App\Http\Controllers\User\LeaderboardController;

// Admin Controllers
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\GamificationController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\BeritaController;

/*
|--------------------------------------------------------------------------
| 🔹 PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Laporan Publik
Route::post('/lapor', [LaporanPublikController::class, 'submit'])->name('submit.laporan');
Route::get('/laporan/masuk', [LaporanPublikController::class, 'index'])->name('laporan.masuk');

// Ringkasan Laporan User (Public View)
Route::get('/user/laporan/ringkasan', [UserLaporanController::class, 'ringkasan'])
    ->name('user.laporan.ringkasan');

// Kondisi Jalan
Route::get('/kondisi-jalan', [KondisiJalanController::class, 'index'])
    ->name('petakondisi.index');

// News
Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// FAQ Public
Route::get('/faq', [FaqController::class, 'publicIndex'])->name('faq');

// Tracking Laporan
Route::get('/track', [TrackReportController::class, 'showTrackPage'])->name('track.show');
Route::post('/track/search', [TrackReportController::class, 'search'])->name('track.search');

// Leaderboard User
Route::middleware(['auth'])->group(function () {
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])
        ->name('leaderboard.index');
});


/*
|--------------------------------------------------------------------------
| 🔒 AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard User
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('user.dashboard');

    // Notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index'])
        ->name('notifikasi.index');

    // Profile
    Route::get('/profile', fn () => view('profile.profil'))->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // History Laporan User
    Route::resource('laporan', \App\Http\Controllers\LaporanController::class)
        ->except(['create', 'store']);

    // Form Laporan
    Route::get('/lapor', fn () => view('laporan.form_laporan'))
        ->name('laporan.form_laporan');


    /*
    |--------------------------------------------------------------------------
    | 🔐 ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        // Laporan Admin
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/{laporan}', [LaporanController::class, 'detail'])
            ->name('laporan.detail');

        Route::put('/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])
            ->name('laporan.updateStatus');

        // 🏆 GAMIFICATION & LEADERBOARD (GANTI FEEDBACK)
        Route::get('/gamification', [GamificationController::class, 'index'])
            ->name('gamification.index');

        // Manajemen User
        Route::get('/pengguna', [UserController::class, 'index'])
            ->name('user.index');

        Route::post('/pengguna/{id}/update-status', [UserController::class, 'updateStatus'])
            ->name('user.updateStatus');

        // Berita Admin
        Route::resource('berita', BeritaController::class);

        // Petugas
        Route::resource('petugas', PetugasController::class)->except(['show']);

        // FAQ Admin
        Route::resource('faq', FaqController::class)->except(['show']);

        // Tugas Laporan Petugas
        Route::prefix('petugas')->name('petugas.')->group(function () {
            Route::get('laporan-tugas', [\App\Http\Controllers\Petugas\LaporanTugasController::class, 'index'])
                ->name('laporan-tugas.index');

            Route::put('laporan-tugas/{id}/update', [\App\Http\Controllers\Petugas\LaporanTugasController::class, 'updateStatus'])
                ->name('laporan-tugas.update');
        });
    });
});
Route::post(
    '/laporan/{laporan}/verify',
    [LaporanController::class, 'verifyAndSend']
)->name('admin.laporan.verify');

Route::get(
    '/admin/laporan/{nomor_laporan}',
    [LaporanController::class, 'detail']
)->name('admin.laporan.detail');

/*
|--------------------------------------------------------------------------
| 🔐 AUTH ROUTES (Breeze / Fortify)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
