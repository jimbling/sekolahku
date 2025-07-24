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

        // Ambil token dari request
        $tokenRaw = $request->get('token');

        if (!$tokenRaw) {
            return redirect('/login')->with('error', 'Token tidak ditemukan');
        }

        // Decode JSON token
        $decodedOnce = json_decode($tokenRaw, true);
        $tokenData = is_string($decodedOnce) ? json_decode($decodedOnce, true) : $decodedOnce;

        if (!$tokenData) {
            return redirect('/login')->with('error', 'Token tidak valid');
        }

        // Ambil data dari query string
        $email = $request->get('email');
        $googleId = $request->get('id');
        $name = $request->get('name');
        $picture = $request->get('picture');

        logger('✅ Data dari Google', compact('email', 'googleId', 'name', 'picture', 'tokenData'));

        if (!$email || !$googleId) {
            return redirect('/login')->with('error', 'Login gagal. Data tidak lengkap.');
        }

        // Cari user berdasarkan google_id atau email
        $user = User::where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        $updateData = [
            'name' => $name,
            'avatar' => $picture,
            'google_id' => $googleId,
            'google_token' => $tokenData['access_token'] ?? null,
            'google_refresh_token' => $tokenData['refresh_token'] ?? null,
        ];

        if (!$user) {
            // Buat user baru
            $user = User::create(array_merge([
                'email' => $email,
                'password' => bcrypt(Str::random(16)), // dummy password
                'role' => 'admin', // atau "user" tergantung default kamu
            ], $updateData));
        } else {
            // Update user yang sudah ada
            $user->update($updateData);
        }

        // Login ke Laravel
        Auth::login($user);

        return redirect()->intended('/admin/formulir')->with('success', 'Berhasil login dengan Google');
    }
}
