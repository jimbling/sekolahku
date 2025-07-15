<?php

namespace Modules\Ringkas\Controllers;

use Illuminate\Routing\Controller;

class RingkasFrontendController extends Controller
{
    public function index()
    {
        $judul = 'Ringkas';
        return view('ringkas::frontend.index', compact('judul'));
    }
}