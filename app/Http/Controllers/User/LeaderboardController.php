<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Leaderboard hanya USER (bukan admin)
        $leaderboard = User::where('role', 'user')
            ->orderBy('points', 'desc')
            ->take(10)
            ->get();

        // Posisi user login
        $userRank = User::where('role', 'user')
            ->where('points', '>', Auth::user()->points)
            ->count() + 1;

        return view('user.leaderboard.index', compact(
            'leaderboard',
            'userRank'
        ));
    }
}
