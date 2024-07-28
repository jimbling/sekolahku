<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Memeriksa peran pengguna
        $isAdmin = $user->hasRole('admin');
        $isWriter = $user->hasRole('writer');

        // Menyiapkan data untuk ditampilkan di tampilan
        $data = [
            'judul' => "Dashboard",
            'isAdmin' => $isAdmin,
            'isWriter' => $isWriter,
        ];

        // Mengembalikan tampilan dashboard dengan data yang disiapkan
        return view('admin.dashboard', $data);
    }
}
