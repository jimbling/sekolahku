<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\Backend\Akademik\TahunPelajaranServices;

class AcademicYearsController extends Controller
{
    protected $academicYearService;

    public function __construct(TahunPelajaranServices $academicYearService)
    {
        $this->academicYearService = $academicYearService;
    }

    public function index()
    {
        $tahun_ajarans = $this->academicYearService->all();
        return view('admin.akademik.all_tahun_ajaran', [
            'judul' => "Data Tahun Pelajaran",
            'tags' => $tahun_ajarans,
            'tahun_ajarans' => $tahun_ajarans
        ]);
    }

    public function getAcademicYears(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->academicYearService->datatable();
            return DataTables::of($data)
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
        $result = $this->academicYearService->store($request);

        return response()->json(
            $result['status'] === 200 ? ['success' => $result['message']] : ['errors' => $result['errors']],
            $result['status']
        );
    }

    public function fetchAcademicYearsById($id)
    {
        $data = $this->academicYearService->getById($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $result = $this->academicYearService->update($request, $id);

        return response()->json(
            $result['status'] === 200 ? ['message' => $result['message']] : ['errors' => $result['errors']],
            $result['status']
        );
    }

    public function destroy($id)
    {
        $result = $this->academicYearService->delete($id);
        return response()->json(['type' => 'success', 'message' => $result['message']], $result['status']);
    }

    public function deleteSelectedAcademicYears(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->academicYearService->deleteSelected($request->ids ?? []);
            return response()->json([
                'type' => $result['status'] === 200 ? 'success' : 'error',
                'message' => $result['message']
            ], $result['status']);
        }
    }
}
