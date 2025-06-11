<?php

namespace App\Http\Controllers\Backend;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    public function index()
    {
        $items = Announcement::latest()->get();
        $judul = "Publikasi Pengumuman";
        return view('admin.publikasi.pengumuman', compact('items', 'judul'));
    }

    public function getPengumuman(Request $request)
    {
        if ($request->ajax()) {
            $pengumuman = Announcement::select([
                'id',
                'title',
                'content',
                'publish_date',
                'expired_at',
                'created_at',
                'updated_at'
            ]);

            return DataTables::of($pengumuman)
                ->addIndexColumn()
                ->editColumn('publish_date', function ($data) {
                    return Carbon::parse($data->publish_date)->translatedFormat('d F Y');
                })
                ->editColumn('expired_at', function ($data) {
                    return Carbon::parse($data->expired_at)->translatedFormat('d F Y');
                })
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->translatedFormat('d F Y - H:i');
                })
                ->addColumn('action', function ($row) {
                    return '
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
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
            'content' => 'required',
            'publish_date' => 'nullable|date',
            'expired_at' => 'nullable|date',

        ]);

        $info = Announcement::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil ditambahkan.',
            'data' => $info
        ]);
    }

    public function fetchAnnouncementById($id)
    {
        $pengumuman = Announcement::findOrFail($id);
        return response()->json($pengumuman);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'publish_date' => 'nullable|date',
            'expired_at' => 'nullable|date',

        ]);

        $pengumuman = Announcement::findOrFail($id);
        $pengumuman->update($validated);

        return response()->json([
            'message' => 'Pengumuman berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $pengumuman = Announcement::findOrFail($id);
        $pengumuman->delete();
        return response()->json([
            'type' => 'success',
            'message' => 'Pengumuman berhasil dihapus.'
        ]);
    }
}
