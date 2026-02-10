<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Laporan;

class GamificationController extends Controller
{
    /**
     * Dashboard Gamifikasi & Leaderboard
     */
    public function index()
    {
        // =========================
        // Leaderboard (USER ONLY)
        // =========================
        $leaderboard = User::where('role', 'user')
            ->orderBy('points', 'desc')
            ->take(10)
            ->get();

        // =========================
        // Statistik Gamifikasi
        // =========================
        $totalUsers = User::where('role', 'user')->count();

        $totalPoints = User::where('role', 'user')->sum('points');

        $topUser = User::where('role', 'user')
            ->orderBy('points', 'desc')
            ->first();

        // Total laporan dari user (opsional tapi rapi)
        $totalReports = Laporan::whereHas('user', function ($q) {
            $q->where('role', 'user');
        })->count();

        return view('admin.gamification.index', compact(
            'leaderboard',
            'totalUsers',
            'totalPoints',
            'topUser',
            'totalReports'
        ));
    }

    /**
     * Detail Gamifikasi per User
     * (OPSIONAL – tidak untuk admin)
     */
    public function show($id)
    {
        $user = User::where('role', 'user')
            ->withCount('laporans')
            ->findOrFail($id);

        return view('admin.gamification.show', compact('user'));
    }
}
