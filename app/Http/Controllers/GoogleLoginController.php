<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleLoginController extends Controller
{
    public function handleCallback(Request $request)
    {
        logger('📥 Google Callback Dipanggil', $request->all());

        // ✅ 1. Ambil token dari request
        $tokenRaw = $request->get('token');
        if (!$tokenRaw) {
            return redirect('/login')->with('error', 'Token tidak ditemukan.');
        }

        $decodedOnce = json_decode($tokenRaw, true);
        $tokenData   = is_string($decodedOnce) ? json_decode($decodedOnce, true) : $decodedOnce;

        if (!$tokenData) {
            return redirect('/login')->with('error', 'Token tidak valid.');
        }

        // ✅ 2. Ambil data user dari query Google
        $email    = $request->get('email');
        $googleId = $request->get('id');
        $name     = $request->get('name');
        $picture  = $request->get('picture');

        if (!$email || !$googleId) {
            return redirect('/login')->with('error', 'Login gagal. Data Google tidak lengkap.');
        }

        // ✅ 3. Siapkan data update
        $updateData = [
            'name'                 => $name,
            'avatar'               => $picture,
            'google_id'            => $googleId,
            'google_token'         => $tokenData['access_token'] ?? null,
            'google_refresh_token' => $tokenData['refresh_token'] ?? null,
        ];

        // ✅ 4. Periksa apakah ada link_user_id dari Auth Server (untuk handle cross-domain)
        $linkUserId = $request->get('link_user_id');
        if ($linkUserId) {
            $user = User::find($linkUserId);
            if ($user) {
                $user->update($updateData);
                Auth::login($user);

                return redirect()->intended('/admin/formulir')
                    ->with('success', '✅ Akun Google berhasil dihubungkan ke akun Anda.');
            }
        }

        // ✅ 5. Kalau tidak ada link_user_id → cek apakah user sudah login biasa
        if (Auth::check()) {
            $user = Auth::user();
            $user->update($updateData);

            return redirect()->intended('/admin/formulir')
                ->with('success', '✅ Akun Google berhasil dihubungkan ke akun Anda.');
        }

        // ✅ 6. Kalau tidak login → proses login dengan akun Google
        $user = User::where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        if (!$user) {
            // 👉 Hanya bikin user baru kalau user belum ada sama sekali
            $user = User::create(array_merge([
                'email'    => $email,
                'password' => bcrypt(Str::random(16)), // password dummy
            ], $updateData));
        } else {
            $user->update($updateData);
        }

        // ✅ Login user baru atau existing user
        Auth::login($user);

        return redirect()->intended('/admin/formulir')
            ->with('success', '✅ Berhasil login dengan Google.');
    }
}
