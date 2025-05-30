<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\Backend\Akademik\KelasServices;

class ClassroomController extends Controller
{
    protected $kelasService;

    public function __construct(KelasServices $kelasService)
    {
        $this->kelasService = $kelasService;
    }

    public function index()
    {
        $classrooms = $this->kelasService->getAll();
        $data = [
            'judul' => "Data Kelas",
            'data_kelas' => $classrooms
        ];

        return view('admin.siswa.all_kelas', $data);
    }

    public function getClassrooms(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->kelasService->getDatatables())
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
        $result = $this->kelasService->store($request);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json($result, 200);
    }

    public function update(Request $request, $id)
    {
        $result = $this->kelasService->update($request, $id);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json($result);
    }

    public function destroy($id)
    {
        $result = $this->kelasService->delete($id);

        return response()->json($result);
    }

    public function deleteSelectedClassrooms(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->kelasService->deleteBulk($request->ids);
            $status = $result['type'] === 'success' ? 200 : 422;

            return response()->json($result, $status);
        }
    }

    public function fetchClassromsById($id)
    {
        $classroom = $this->kelasService->findById($id);
        return response()->json($classroom);
    }
}
