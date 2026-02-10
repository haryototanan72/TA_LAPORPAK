<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Ambil notifikasi belum dibaca
    public function getUnread()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications;

        return view('notifikasi.index', compact('notifications'));
    }

    // Tandai notifikasi sebagai dibaca
    public function markAsRead($id)
    {
        $user = Auth::user(); // FIX
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->route('notifikasi.index');
    }

    // Tampilkan semua notifikasi + tandai unread jadi read
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);

        // Tandai yang belum dibaca sebagai read
        $user->unreadNotifications->markAsRead();

        return view('notifikasi.index', compact('notifications'));
    }
}
