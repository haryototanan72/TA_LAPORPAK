<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Cek status user setelah berhasil authenticate
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user && $user->status !== 'aktif') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun kamu lagi ditangguhkan sementara, silakan hubungi kami.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google Login belum dikonfigurasi di file .env (GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET wajib diisi).'
            ]);
        }

        return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google Login belum dikonfigurasi di file .env.'
            ]);
        }

        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();

            // Cari user berdasarkan email
            $user = \App\Models\User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Cek apakah akun ditangguhkan
                if (isset($user->status) && $user->status !== 'aktif') {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Akun Anda sedang ditangguhkan sementara. Silakan hubungi admin.'
                    ]);
                }

                // Update google_id jika belum tersimpan
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $user->save();
                }
            } else {
                // Buat user baru jika belum ada
                $user = \App\Models\User::create([
                    'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User',
                    'email' => $googleUser->getEmail(),
                    'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(24)),
                    'google_id' => $googleUser->getId(),
                    'role' => 'user', // default role
                    'status' => 'aktif',
                ]);
            }

            Auth::login($user);

            request()->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal login dengan Google: ' . $e->getMessage()
            ]);
        }
    }
}
