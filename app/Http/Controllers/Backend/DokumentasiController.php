<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
    public function index()
    {
        $judul = 'Dokumentasi Sistem';
        return view('admin.documentation.index', compact('judul'));
    }

    public function module()
    {
        $judul = 'Dokumentasi: make:module';
        return view('dokumentasi.doc_makemodule', compact('judul'));
    }

    // Tambahan dokumentasi lain bisa ditambahkan seperti ini:
    public function permission()
    {
        $judul = 'Dokumentasi: Permission';
        return view('admin.documentation.permission', compact('judul'));
    }
}
