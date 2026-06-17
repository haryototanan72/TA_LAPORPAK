<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    // Mengalihkan pengguna ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Menangani callback dari Google setelah pengguna berhasil login
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari apakah pengguna dengan google_id atau email ini sudah ada
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Jika user sudah ada tapi belum punya google_id, update google_id-nya
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                
                Auth::login($user);
            } else {
                // Jika user baru, buat akun otomatis di sistem
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(rand(1, 10000)) // Password acak formalitas
                ]);

                Auth::login($newUser);
            }

            // Alihkan ke halaman dashboard utama LAPORPAK!
            return redirect()->route('dashboard');

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan Google, silakan coba lagi.');
        }
    }
}