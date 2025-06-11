<?php

namespace App\Http\Controllers\Backend;

use App\Models\UrgentInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class UrgentInfoController extends Controller
{
    public function index()
    {
        $items = UrgentInfo::latest()->get();
        $judul = "Publikasi Informasi";

        return view('admin.publikasi.informasi', compact('items', 'judul'));
    }


    public function getInformasi(Request $request)
    {
        if ($request->ajax()) {
            $informasi = UrgentInfo::select(['id', 'title', 'message', 'start_date', 'end_date', 'url', 'created_at', 'updated_at']);

            return DataTables::of($informasi)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'message' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'url' => 'nullable|url'
        ]);

        $info = UrgentInfo::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Informasi berhasil ditambahkan.',
            'data' => $info
        ]);
    }

    public function fetchUrgentInfoById($id)
    {
        $urgentInfo = UrgentInfo::findOrFail($id);
        return response()->json($urgentInfo);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'url' => 'nullable|url'
        ]);

        $info = UrgentInfo::findOrFail($id);
        $info->update($validated);

        return response()->json([
            'message' => 'Informasi berhasil diperbarui.'
        ]);
    }



    public function destroy($id)
    {
        $urgentInfo = UrgentInfo::findOrFail($id);
        $urgentInfo->delete();
        return response()->json([
            'type' => 'success',
            'message' => 'Informasi berhasil dihapus.'
        ]);
    }
}
