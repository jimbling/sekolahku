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

        // Memeriksa apakah pengguna adalah admin
        $isAdmin = $user->hasRole('admin');

        // Menyiapkan data untuk ditampilkan di tampilan
        $data = [
            'judul' => "Dashboard",
            'isAdmin' => $isAdmin,
        ];

        // Mengembalikan tampilan dashboard dengan data yang disiapkan
        return view('admin.dashboard', $data);
    }
}
