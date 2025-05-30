<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Services\Backend\Gtk\GtkService;
use App\Http\Requests\Backend\Gtk\StoreGtkRequest;
use App\Http\Requests\Backend\Gtk\UpdateGtkRequest;

class GtkController extends Controller
{
    protected $gtkService;

    public function __construct(GtkService $gtkService)
    {
        $this->gtkService = $gtkService;
    }

    public function index()
    {
        $gtks = $this->gtkService->getAllGtk();

        return view('admin.gtk.all_gtk', [
            'judul' => "Data GTK",
            'tags' => $gtks,
            'gtks' => $gtks
        ]);
    }

    public function getGtk(Request $request)
    {
        if ($request->ajax()) {
            $gtks = $this->gtkService->getGtkDatatable();

            return DataTables::of($gtks)
                ->addIndexColumn()
                ->editColumn('gender', fn($row) => $row->gender === 'M' ? 'Laki-Laki' : ($row->gender === 'F' ? 'Perempuan' : 'Tidak Diketahui'))
                ->editColumn('parent_school_status', fn($row) => $row->parent_school_status === 1 ? 'INDUK' : 'NON INDUK')
                ->addColumn('action', function ($row) {
                    return '
                        <a href="javascript:void(0)" data-id="' . $row->id . '" data-photo="' . asset('storage/' . $row->photo) . '" class="btn btn-info btn-xs view-photo-btn"><i class="fas fa-image"></i> Foto</a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(StoreGtkRequest $request)
    {
        $this->gtkService->storeGtk($request->validated() + ['gtk_foto' => $request->file('gtk_foto')]);

        return response()->json(['success' => 'Data GTK berhasil ditambahkan.']);
    }

    public function fetchGtkById($id)
    {
        $gtk = $this->gtkService->getGtkById($id);

        return response()->json($gtk);
    }

    public function update(UpdateGtkRequest $request, $id)
    {
        $this->gtkService->updateGtk($id, $request->validated() + ['gtk_foto' => $request->file('gtk_foto')]);

        return response()->json(['message' => 'Data GTK berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $this->gtkService->deleteGtk($id);

        return response()->json([
            'type' => 'success',
            'message' => 'GTK berhasil dihapus.'
        ]);
    }

    public function deleteSelectedTags(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;
            if (!empty($ids)) {
                $this->gtkService->deleteSelected($ids);

                return response()->json([
                    'type' => 'success',
                    'message' => 'GTK berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada GTK yang dipilih untuk dihapus.'
                ], 422);
            }
        }
    }
}
