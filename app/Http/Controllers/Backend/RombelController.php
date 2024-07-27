<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\RombonganBelajar;
use App\Models\AnggotaRombel;
use App\Models\Gtk;
use App\Models\Classroom;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RombelController extends Controller
{

    public function index()
    {
        // Ambil semua data siswa beserta tahun pelajaran dan kelasnya
        $students = Student::with(['anggotaRombels.rombel.academicYear', 'anggotaRombels.rombel.classroom'])
            ->get()
            ->sortBy(function ($student) {
                $anggotaRombel = $student->anggotaRombels->first(); // Ambil anggotaRombel pertama

                // Pastikan anggotaRombel dan rombel ada sebelum mengakses propertinya
                if ($anggotaRombel && $anggotaRombel->rombel) {
                    return [
                        $anggotaRombel->rombel->academicYear->academic_year ?? 'Unknown Year',
                        $anggotaRombel->rombel->classroom->name ?? 'Unknown Classroom',
                    ];
                }

                return [
                    'Unknown Year',
                    'Unknown Classroom',
                ];
            });

        // Ambil data tahun pelajaran dan kelas untuk filter, urutkan academic_year secara descending
        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $classrooms = Classroom::orderBy('name')->get();

        // Data tambahan yang ingin diteruskan ke view
        $data = [
            'judul' => "Daftar PD Rombel",
            'students' => $students,
            'academicYears' => $academicYears,
            'classrooms' => $classrooms
        ];

        return view('admin.siswa.rombel', $data);
    }


    public function filter(Request $request)
    {
        $academicYearString = $request->input('academic_year');
        $classroomName = $request->input('classroom');

        $academicYearId = null;
        $classroomId = null;

        // Mendapatkan ID AcademicYear jika ada
        if ($academicYearString) {
            $parts = explode('-', $academicYearString);
            $academicYear = AcademicYear::where('academic_year', $parts[0])
                ->where('semester', $parts[1])
                ->first();
            if ($academicYear) {
                $academicYearId = $academicYear->id;
            }
        }

        // Mendapatkan ID Classroom jika ada
        if ($classroomName) {
            $classroom = Classroom::where('name', $classroomName)->first();
            if ($classroom) {
                $classroomId = $classroom->id;
            }
        }

        // Memfilter data siswa berdasarkan tahun pelajaran dan kelas
        $students = Student::whereHas('anggotaRombels', function ($query) use ($academicYearId, $classroomId) {
            $query->whereHas('rombel', function ($query) use ($academicYearId, $classroomId) {
                if ($academicYearId) {
                    $query->where('academic_years_id', $academicYearId);
                }
                if ($classroomId) {
                    $query->where('classroom_id', $classroomId);
                }
            });
        })->with(['anggotaRombels.rombel.academicYear', 'anggotaRombels.rombel.classroom'])
            ->get()
            ->sortBy(function ($student) {
                $anggotaRombel = $student->anggotaRombels->first();
                return [
                    $anggotaRombel->rombel->academicYear->academic_year,
                    $anggotaRombel->rombel->classroom->name,
                ];
            });

        // Ambil data tahun pelajaran dan kelas untuk filter
        $academicYears = AcademicYear::orderBy('academic_year', 'desc')->get();
        $classrooms = Classroom::orderBy('name')->get();

        // Data tambahan yang ingin diteruskan ke view
        $data = [
            'judul' => "Pengaturan Umum",
            'students' => $students,
            'academicYears' => $academicYears,
            'classrooms' => $classrooms,
            'selectedAcademicYear' => $academicYearString,
            'selectedClassroom' => $classroomName
        ];

        return view('admin.siswa.rombel', $data);
    }




    // Menampilkan daftar rombongan belajar
    public function daftarRombel()
    {
        $academicYears = AcademicYear::all();
        $classrooms = Classroom::all();
        $gtks = Gtk::orderBy('full_name', 'asc')->get(); // Mengurutkan berdasarkan nama GTK secara abjad

        $data = [
            'judul' => "Data Rombongan Belajar",
        ];

        return view('admin.siswa.rombel_daftar', $data, compact('academicYears', 'classrooms', 'gtks'));
    }

    public function getDaftarRombel(Request $request)
    {
        if ($request->ajax()) {
            $rombels = RombonganBelajar::with(['academicYear', 'classroom', 'gtk'])
                ->select(['id', 'academic_years_id', 'classroom_id', 'gtks_id'])
                ->orderBy('id', 'asc'); // Urutkan berdasarkan ID atau kolom lain yang sesuai

            return DataTables::of($rombels)
                ->addIndexColumn()
                ->addColumn('tahun_ajaran', function ($row) {
                    return $row->tahun_ajaran; // Menggunakan accessor
                })
                ->addColumn('kelas', function ($row) {
                    return $row->kelas; // Menggunakan accessor
                })
                ->addColumn('wali_kelas', function ($row) {
                    return $row->wali_kelas; // Menggunakan accessor
                })
                ->addColumn('jumlah_anggota', function ($row) {
                    return $row->jumlah_anggota; // Menggunakan accessor
                })
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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'tahun_ajaran' => 'required|exists:academic_years,id',
            'kelas' => 'required|exists:classrooms,id',
            'wali_kelas' => 'required|exists:gtks,id',
        ], [
            'tahun_ajaran.required' => 'Tahun Ajaran harus diisi.',
            'tahun_ajaran.exists' => 'Tahun Ajaran yang dipilih tidak valid.',
            'kelas.required' => 'Kelas harus diisi.',
            'kelas.exists' => 'Kelas yang dipilih tidak valid.',
            'wali_kelas.required' => 'Wali Kelas harus diisi.',
            'wali_kelas.exists' => 'Wali Kelas yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Simpan data ke database
        RombonganBelajar::create([
            'academic_years_id' => $request->input('tahun_ajaran'),
            'classroom_id' => $request->input('kelas'),
            'gtks_id' => $request->input('wali_kelas'),
        ]);

        // Jika berhasil disimpan, kirim respons JSON dengan pesan sukses
        return response()->json(['success' => 'Data Rombongan Belajar berhasil ditambahkan.'], 200);
    }

    public function fetchRombelsById($id)
    {

        $rombels = RombonganBelajar::findOrFail($id);

        return response()->json($rombels);
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'tahun_ajaran' => 'required|exists:academic_years,id',
            'kelas' => 'required|exists:classrooms,id',
            'wali_kelas' => 'required|exists:gtks,id',
        ], [
            'tahun_ajaran.required' => 'Tahun Ajaran harus diisi.',
            'tahun_ajaran.exists' => 'Tahun Ajaran yang dipilih tidak valid.',
            'kelas.required' => 'Kelas harus diisi.',
            'kelas.exists' => 'Kelas yang dipilih tidak valid.',
            'wali_kelas.required' => 'Wali Kelas harus diisi.',
            'wali_kelas.exists' => 'Wali Kelas yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }


        $rombels = RombonganBelajar::findOrFail($id);
        $rombels->academic_years_id = $request->input('tahun_ajaran');
        $rombels->classroom_id = $request->input('kelas');
        $rombels->gtks_id = $request->input('wali_kelas');

        $rombels->save();
        return response()->json(['message' => 'Data Rombongan Belajar berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $rombels = RombonganBelajar::findOrFail($id);

        // Hapus kategori
        $rombels->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Data Rombongan Belajar berhasil dihapus.'
        ]);
    }

    public function deleteSelectedRombels(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                RombonganBelajar::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Data Rombongan Belajar berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada Data Rombongan Belajar yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }

    //////////////////////////////////////////////////////////////////////////
    // ANGGOTA ROMBEL//////////////////////////////////////////////////////

    public function anggotaRombel()
    {
        $classrooms = Classroom::all();
        $academic_years = AcademicYear::all();
        $data = [
            'judul' => "Anggota Rombel",
            'data_kelas' => $classrooms,
            'tahun_pelajaran' => $academic_years
        ];
        // dd($data); // Untuk debugging, pastikan data muncul dengan benar
        return view('admin.siswa.rombel_anggota', $data);
    }

    public function getStudents(Request $request)
    {
        if ($request->ajax()) {
            // Memulai query dengan tabel student
            $query = Student::select([
                'students.id',
                'name',
                'nis',
                'birth_place',
                'birth_date',
                'gender',
                'email',
                'student_status_id',
                'photo',
                'end_date',
                'reason'
            ])
                ->leftJoin('anggota_rombels', 'students.id', '=', 'anggota_rombels.student_id')
                ->where('students.student_status_id', 1)
                ->distinct(); // Menghindari duplikasi data siswa

            // Filter berdasarkan status pendaftaran
            if ($request->filter === 'unregistered') {
                $query->whereNull('anggota_rombels.id'); // Hanya siswa yang belum terdaftar
            } elseif ($request->filter !== 'all') {
                // Filter berdasarkan classroom_id dan academic_year_id
                $query->join('rombongan_belajars', 'anggota_rombels.rombel_id', '=', 'rombongan_belajars.id')
                    ->where('rombongan_belajars.classroom_id', $request->classroom_id)
                    ->where('rombongan_belajars.academic_years_id', $request->academic_year_id);
            }

            // Mengatur urutan dan mendapatkan hasil
            $students = $query->orderBy('name', 'asc')->get();

            return DataTables::of($students)
                ->addIndexColumn()
                ->make(true);
        }
    }




    public function getFilteredStudents(Request $request)
    {
        if ($request->ajax()) {
            $query = Student::select([
                'students.id as student_id',
                'name',
                'nis',
                'birth_place',
                'birth_date',
                'gender',
                'email',
                'student_status_id',
                'photo',
                'end_date',
                'reason',
                'anggota_rombels.id as anggota_rombel_id' // Add anggota_rombel ID
            ])
                ->leftJoin('anggota_rombels', 'students.id', '=', 'anggota_rombels.student_id');

            if (!is_null($request->classroom_id)) {
                $query->join('rombongan_belajars', 'anggota_rombels.rombel_id', '=', 'rombongan_belajars.id')
                    ->where('rombongan_belajars.classroom_id', $request->classroom_id);
            }

            if (!is_null($request->academic_year_id)) {
                $query->where('rombongan_belajars.academic_years_id', $request->academic_year_id);
            }

            $students = $query->orderBy('name', 'asc')->get();

            return DataTables::of($students)
                ->addIndexColumn()
                ->make(true);
        }
    }


    public function getRombelId(Request $request)
    {
        if ($request->ajax()) {
            // Validasi input
            $request->validate([
                'classroom_id' => 'required|integer',
                'academic_year_id' => 'required|integer',
            ]);

            // Cari rombel_id berdasarkan classroom_id dan academic_year_id
            $rombel = RombonganBelajar::where('classroom_id', $request->classroom_id)
                ->where('academic_years_id', $request->academic_year_id)
                ->first();

            $rombelId = $rombel ? $rombel->id : null;

            return response()->json([
                'rombel_id' => $rombelId
            ]);
        }
    }
}
