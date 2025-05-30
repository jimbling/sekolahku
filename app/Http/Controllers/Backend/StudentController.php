<?php

namespace App\Http\Controllers\Backend;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Backend\Akademik\StudentService;
use App\Http\Requests\Backend\Akademik\PesertaDidik\AlumniRequest;
use App\Http\Requests\Backend\Akademik\PesertaDidik\StudentRequest;

class StudentController extends Controller
{

    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        $students = $this->studentService->getAllActiveStudents();

        $data = [
            'judul' => "Data Peserta Didik",
            'peserta_didik' => $students
        ];

        return view('admin.siswa.all_pd', $data, compact('students'));
    }

    public function getStudents()
    {
        $students = $this->studentService->getStudentsForDatatables();

        return DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('jenis_kelamin', function ($row) {
                return $row->gender === 'M' ? 'Laki-Laki' : ($row->gender === 'F' ? 'Perempuan' : 'Tidak Diketahui');
            })
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

    public function store(StudentRequest $request)
    {
        $this->studentService->createStudent($request->all());

        return response()->json(['success' => 'Data Peserta Didik berhasil ditambahkan.'], 200);
    }

    public function fetchStudentsById($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function destroy($id)
    {
        $this->studentService->deleteStudent($id);

        return response()->json([
            'type' => 'success',
            'message' => 'Peserta Didik berhasil dihapus.'
        ]);
    }

    public function deleteSelectedStudents(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json([
                'type' => 'error',
                'message' => 'Tidak ada Peserta Didik yang dipilih untuk dihapus.'
            ], 422);
        }

        $this->studentService->deleteMultipleStudents($ids);

        return response()->json([
            'type' => 'success',
            'message' => 'Peserta Didik berhasil dihapus.'
        ]);
    }

    public function update(StudentRequest $request, $id)
    {
        $this->studentService->updateStudent($id, $request->all());

        return response()->json(['message' => 'Data GTK berhasil diperbarui.']);
    }

    /////////////////////////////////////////////////////////////////////////////
    public function studentsNonActive()
    {
        $students = $this->studentService->getAllNonActiveStudents();

        $data = [
            'judul' => "Data Peserta Didik Non Aktif",
            'peserta_didik' => $students
        ];

        return view('admin.siswa.pd_non_active', $data, compact('students'));
    }

    public function getStudentsNonActive()
    {
        $students = $this->studentService->getNonActiveStudentsForDatatables();

        return DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('jenis_kelamin', function ($row) {
                return $row->gender === 'M' ? 'Laki-Laki' : ($row->gender === 'F' ? 'Perempuan' : 'Tidak Diketahui');
            })
            ->editColumn('is_alumni', function ($row) {
                return $row->is_alumni ? 'Ya' : 'Tidak';
            })
            ->addColumn('action', function ($row) {
                return '
                <a href="javascript:void(0)" data-id="' . $row->id . '" data-photo="' . asset('storage/' . $row->photo) . '" class="btn btn-info btn-xs view-photo-btn"><i class="fas fa-image"></i> Foto</a>
                <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
            ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function markAsAlumni(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:students,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $this->studentService->markAsAlumni($request->input('ids'));

        return response()->json(['success' => true]);
    }

    public function restoreAlumni(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:students,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'message' => 'Tidak ada Peserta Didik yang dipilih untuk diperbarui.'
            ], 422);
        }

        $this->studentService->restoreToActive($request->input('ids'));

        return response()->json([
            'type' => 'success',
            'message' => 'Peserta Didik berhasil dikembalikan menjadi Aktif.'
        ]);
    }

    public function storeAlumni(AlumniRequest $request)
    {
        $this->studentService->createAlumni($request->all());

        return redirect()->route('web.pd.non.active')
            ->with('success', 'Data alumni berhasil ditambahkan.');
    }
}
