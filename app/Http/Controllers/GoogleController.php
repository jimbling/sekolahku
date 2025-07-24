<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

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

            // Cek apakah user sudah ada berdasarkan google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Jika belum, cari via email (mungkin user sudah pernah daftar manual)
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // Update data google_id
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                    ]);
                } else {
                    // Atau buat user baru
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                        'password' => bcrypt(Str::random(16)), // Password acak
                        'role' => 'admin', // Bisa kamu ubah sesuai skenario
                    ]);
                }
            }

            Auth::login($user);

            return redirect()->route('formulir.index')->with('success', 'Berhasil login dengan Google');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google.');
        }
    }
}
