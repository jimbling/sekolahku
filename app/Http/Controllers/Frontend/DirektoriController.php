<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gtk;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


Carbon::setLocale('id');

class DirektoriController extends Controller
{
    public function gtk()
    {
        // Mengambil data GTK dengan pagination
        $gtks = Gtk::orderBy('full_name', 'asc')->paginate(6); // Mengatur jumlah data per halaman (misalnya 10)

        return view('web.guru_tendik', compact('gtks'));
    }
}
