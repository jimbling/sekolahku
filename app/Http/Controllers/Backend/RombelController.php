<?php

namespace App\Http\Controllers\Backend;

use App\Models\Gtk;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\AnggotaRombel;
use App\Models\RombonganBelajar;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\Backend\Akademik\RombelService;
use App\Http\Requests\Backend\Akademik\Rombel\StoreRombelRequest;
use App\Http\Requests\Backend\Akademik\Rombel\UpdateRombelRequest;

class RombelController extends Controller
{

    protected $rombelService;

    public function __construct(RombelService $rombelService)
    {
        $this->rombelService = $rombelService;
    }

    public function index()
    {
        $students = $this->rombelService->getStudentsWithRombel();
        $formData = $this->rombelService->getFormData();

        return view('admin.siswa.rombel', [
            'judul' => "Daftar PD Rombel",
            'students' => $students,
            'academicYears' => $formData['academicYears'],
            'classrooms' => $formData['classrooms']
        ]);
    }



    public function filter(Request $request)
    {
        $academicYearString = $request->input('academic_year');
        $classroomName = $request->input('classroom');

        $students = $this->rombelService->getFilteredStudents($academicYearString, $classroomName);
        $formData = $this->rombelService->getFormData();

        return view('admin.siswa.rombel', [
            'judul' => "Pengaturan Umum",
            'students' => $students,
            'academicYears' => $formData['academicYears'],
            'classrooms' => $formData['classrooms'],
            'selectedAcademicYear' => $academicYearString,
            'selectedClassroom' => $classroomName
        ]);
    }

    // Menampilkan daftar rombongan belajar
    public function daftarRombel()
    {
        $formData = $this->rombelService->getFormDataWithGtk();

        return view('admin.siswa.rombel_daftar', [
            'judul' => "Data Rombongan Belajar",
            'academicYears' => $formData['academicYears'],
            'classrooms' => $formData['classrooms'],
            'gtks' => $formData['gtks'],
        ]);
    }


    public function getDaftarRombel(Request $request)
    {
        if ($request->ajax()) {
            $rombels = $this->rombelService->getAllRombels();

            return DataTables::of($rombels)
                ->addIndexColumn()
                ->addColumn('tahun_ajaran', fn($row) => $row->tahun_ajaran)
                ->addColumn('kelas', fn($row) => $row->kelas)
                ->addColumn('wali_kelas', fn($row) => $row->wali_kelas)
                ->addColumn('jumlah_anggota', fn($row) => $row->jumlah_anggota)
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




    public function store(StoreRombelRequest $request)
    {
        $this->rombelService->store($request->validated());

        return response()->json(['success' => 'Data Rombongan Belajar berhasil ditambahkan.'], 200);
    }

    public function fetchRombelsById($id)
    {
        $rombel = RombonganBelajar::findOrFail($id);
        return response()->json($rombel);
    }

    public function update(UpdateRombelRequest $request, $id)
    {
        $rombel = RombonganBelajar::findOrFail($id);
        $this->rombelService->update($rombel, $request->validated());

        return response()->json(['message' => 'Data Rombongan Belajar berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $rombel = RombonganBelajar::findOrFail($id);
        $this->rombelService->delete($rombel);

        return response()->json([
            'type' => 'success',
            'message' => 'Data Rombongan Belajar berhasil dihapus.'
        ]);
    }

    public function deleteSelectedRombels(Request $request)
    {
        $ids = $request->ids;

        if (!empty($ids)) {
            $this->rombelService->deleteSelected($ids);
            return response()->json([
                'type' => 'success',
                'message' => 'Data Rombongan Belajar berhasil dihapus.'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'message' => 'Tidak ada Data Rombongan Belajar yang dipilih untuk dihapus.'
        ], 422);
    }

    //////////////////////////////////////////////////////////////////////////
    // ANGGOTA ROMBEL//////////////////////////////////////////////////////

    public function anggotaRombel()
    {
        $data = $this->rombelService->getAnggotaRombelData();
        return view('admin.siswa.rombel_anggota', $data);
    }

    public function getStudents(Request $request)
    {
        if ($request->ajax()) {
            return $this->rombelService->fetchStudents($request);
        }
    }

    public function getFilteredStudents(Request $request)
    {
        if ($request->ajax()) {
            return $this->rombelService->getFilteredStudentsAjax($request);
        }
    }

    public function getRombelId(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'classroom_id' => 'required|integer',
                'academic_year_id' => 'nullable|integer',
            ]);

            return response()->json([
                'rombel_id' => $this->rombelService->getRombelIdByRequest($request),
            ]);
        }
    }
}
