<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\QuickLink;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class QuickLinkController extends Controller
{
    public function index()
    {
        $items = QuickLink::latest()->get();
        $judul = "Publikasi Akses Cepat";

        return view('admin.publikasi.akses-cepat', compact('items', 'judul'));
    }

    public function getAksesCepat(Request $request)
    {
        if ($request->ajax()) {
            $aksesCepat = QuickLink::select([
                'id',
                'label',
                'url',
                'icon',
                'color',
            ]);

            return DataTables::of($aksesCepat)
                ->addIndexColumn()

                // Render icon sebagai HTML (bukan string teks)
                ->editColumn('icon', function ($row) {
                    // Tambahkan class Tailwind jika perlu
                    return str_replace('<svg', '<svg class="w-2 h-2 text-gray-700"', $row->icon);
                })

                ->addColumn('action', function ($row) {
                    return '

                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
                ';
                })

                // Penting: izinkan kolom 'icon' dan 'action' berisi HTML
                ->rawColumns(['icon', 'action'])
                ->make(true);
        }
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required',
            'url' => ['required', 'string', 'regex:/^(\/|http(s)?:\/\/)/'],
            'icon' => 'required|string',
            'color' => 'required',

        ]);

        $aksesCepat = QuickLink::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Akses Cepat berhasil ditambahkan.',
            'data' => $aksesCepat
        ]);
    }

    public function destroy($id)
    {
        $aksesCepat = QuickLink::findOrFail($id);
        $aksesCepat->delete();
        return response()->json([
            'type' => 'success',
            'message' => 'Akses Cepat berhasil dihapus.'
        ]);
    }
}
