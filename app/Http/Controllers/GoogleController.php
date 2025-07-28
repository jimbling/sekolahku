<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // ✅ 1. Kalau user sudah login → hubungkan akun Google ke user itu
            if (Auth::check()) {
                $user = Auth::user();

                // Update data google
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'avatar' => $googleUser->getAvatar(),
                ]);

                return redirect()->route('formulir.index')
                    ->with('success', 'Akun Google berhasil dihubungkan.');
            }

            // ✅ 2. Kalau tidak ada user login, cari user berdasarkan google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Cari via email (mungkin user sudah pernah daftar manual)
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // Update data google_id
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                } else {
                    // Baru buat user (last option)
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                        'avatar' => $googleUser->getAvatar(),
                        'password' => bcrypt(Str::random(16)), // Password acak
                        // 🚨 HAPUS role karena kamu pakai Spatie Roles
                    ]);
                }
            }

            Auth::login($user);

            return redirect()->route('formulir.index')->with('success', 'Berhasil login dengan Google');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google.');
        }
    }


    public function disconnect()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'Tidak ada user yang login.');
        }

        if ($user->google_id) {
            // (Opsional) Revoke akses di Google
            if ($user->google_token) {
                \Illuminate\Support\Facades\Http::asForm()->post('https://oauth2.googleapis.com/revoke', [
                    'token' => $user->google_token,
                ]);
            }

            // HAPUS data Google dari user (pastikan kolom ada di DB)
            $user->google_id = null;
            $user->google_token = null;
            $user->google_refresh_token = null;
            $user->avatar = null;
            $user->save(); // ← WAJIB ada ini

            return redirect()->back()->with('status', 'Akses Google berhasil diputuskan.');
        }

        return redirect()->back()->with('error', 'Tidak ada akun Google yang terhubung.');
    }
}
