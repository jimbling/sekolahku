<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Gtk;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\RombonganBelajar;
use App\Models\AnggotaRombel;
use Illuminate\Support\Facades\DB;

Carbon::setLocale('id');

class DirektoriController extends Controller
{
    // Fungsi untuk mengambil nilai setting dan mengonversinya menjadi integer
    private function get_setting_int($key, $default = 0)
    {
        $value = get_setting($key, $default);
        return is_numeric($value) ? (int) $value : $default;
    }

    public function gtk()
    {
        $data = [
            'judul' => "Daftar Guru dan Tendik",

        ];


        return theme_view('konten.guru_tendik', $data);
        // return view('web.guru_tendik', $data);
    }




    public function gtkData()
    {
        $cacheEnabled = get_setting('site_cache', false);
        $cacheTime = $this->get_setting_int('site_cache_time', 10);
        $page = request('page', 1);
        $cacheKey = 'gtks_page_' . $page . '_search_' . request('search') . '_status_' . request('status');

        if ($cacheEnabled) {
            Cache::forget($cacheKey);
        }

        $query = Gtk::query();

        // Filter: Search by Name or NIP
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%");
            });
        }

        // Filter: Status Aktif / Non-Aktif
        if (request()->filled('status')) {
            $query->where('gtk_status', request('status'));
        }

        $gtks = $cacheEnabled
            ? Cache::remember($cacheKey, now()->addMinutes($cacheTime), function () use ($query, $page) {
                return $query->orderBy('full_name', 'asc')->paginate(6, ['*'], 'page', $page);
            })
            : $query->orderBy('full_name', 'asc')->paginate(6, ['*'], 'page', $page);

        return response()->json($gtks);
    }


    public function gtkDetail($id)
    {
        $gtk = Gtk::findOrFail($id);
        return response()->json($gtk);
    }



    public function peserta_didik(Request $request)
    {
        $academicYearId = $request->input('academic_year');
        $classroomId = $request->input('classroom');

        // Query siswa dengan filter berdasarkan rombel_id
        $students = Student::whereHas('anggotaRombels.rombel', function ($q) use ($academicYearId, $classroomId) {
            if ($academicYearId) {
                $q->where('academic_years_id', $academicYearId);
            }
            if ($classroomId) {
                $q->where('classroom_id', $classroomId);
            }
        })
            ->with(['anggotaRombels.rombel.academicYear', 'anggotaRombels.rombel.classroom'])
            ->get()
            ->sortBy(function ($student) {
                // Urutkan berdasarkan academic_year dan classroom
                $anggotaRombel = $student->anggotaRombels->first();
                return [
                    $anggotaRombel->rombel->academicYear->academic_year,
                    $anggotaRombel->rombel->classroom->name,
                ];
            });

        // Ambil data tahun pelajaran dan kelas untuk filter, urutkan academic_year secara descending
        $academicYears = AcademicYear::orderBy('academic_year', 'asc')->get();
        $classrooms = Classroom::orderBy('name')->get();

        // Data tambahan yang ingin diteruskan ke view
        $data = [
            'judul' => "Daftar PD Rombel",
            'students' => $students,
            'academicYears' => $academicYears,
            'classrooms' => $classrooms,
            'academicYearId' => $academicYearId,
            'classroomId' => $classroomId
        ];

        return theme_view('konten.peserta_didik', $data);
        // return view('web.peserta_didik', $data);
    }

    public function filterPesertaDidik(Request $request)
    {
        $academicYearId = $request->input('academic_year');
        $classroomId = $request->input('classroom');

        // Query siswa dengan filter berdasarkan rombel_id
        $students = Student::whereHas('anggotaRombels.rombel', function ($q) use ($academicYearId, $classroomId) {
            if ($academicYearId) {
                $q->where('academic_years_id', $academicYearId);
            }
            if ($classroomId) {
                $q->where('classroom_id', $classroomId);
            }
        })
            ->with(['anggotaRombels.rombel.academicYear', 'anggotaRombels.rombel.classroom'])
            ->get()
            ->sortBy(function ($student) {
                // Urutkan berdasarkan academic_year dan classroom
                $anggotaRombel = $student->anggotaRombels->first();
                return [
                    $anggotaRombel->rombel->academicYear->academic_year,
                    $anggotaRombel->rombel->classroom->name,
                ];
            });

        // Kembalikan hasil query sebagai JSON
        return response()->json($students);
    }

    public function peserta_didik_non_aktif()
    {

        $data = [
            'judul' => "Daftar PD Non Aktif",
        ];

        return theme_view('konten.peserta_didik_non_aktif', $data);
        // return view('web.peserta_didik_non_aktif', $data);
    }



    public function nonaktif()
    {
        $students = Student::where('student_status_id', 0)
            ->with(['anggotaRombels.rombel.academicYear', 'anggotaRombels.rombel.classroom'])
            ->get();

        // Hapus duplikasi berdasarkan ID siswa dan pilih anggota rombel pertama
        $students = $students->map(function ($student) {
            $student->anggotaRombels = $student->anggotaRombels->first();
            return $student;
        })->unique('id');

        // Sorting
        $sortedStudents = $students->sortBy(function ($student) {
            return [
                $student->anggotaRombels->rombel->academicYear->academic_year ?? '',
                $student->anggotaRombels->rombel->classroom->name ?? '',
            ];
        });

        return response()->json($sortedStudents);
    }
}
