<?php

namespace App\Services\Backend\Akademik;

use App\Models\Gtk;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\AcademicYear;
use App\Models\RombonganBelajar;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RombelService
{
    /**
     * Ambil semua siswa beserta relasi rombel, tahun pelajaran, dan kelas.
     */
    public function getStudentsWithRombel()
    {
        return Student::with(['anggotaRombels.rombel.academicYear', 'anggotaRombels.rombel.classroom'])
            ->get()
            ->sortBy(function ($student) {
                $anggotaRombel = $student->anggotaRombels->first();

                if ($anggotaRombel && $anggotaRombel->rombel) {
                    return [
                        $anggotaRombel->rombel->academicYear->academic_year ?? 'Unknown Year',
                        $anggotaRombel->rombel->classroom->name ?? 'Unknown Classroom',
                    ];
                }

                return ['Unknown Year', 'Unknown Classroom'];
            });
    }

    /**
     * Data untuk kebutuhan filter siswa berdasarkan tahun pelajaran dan kelas.
     */
    public function getFormData(): array
    {
        return [
            'academicYears' => AcademicYear::orderBy('academic_year', 'desc')->get(),
            'classrooms' => Classroom::orderBy('name')->get(),
        ];
    }

    /**
     * Data tambahan untuk form tambah/edit rombel (termasuk GTK).
     */
    public function getFormDataWithGtk(): array
    {
        return [
            'academicYears' => AcademicYear::orderBy('academic_year', 'desc')->get(),
            'classrooms' => Classroom::orderBy('name')->get(),
            'gtks' => Gtk::orderBy('full_name')->get()
        ];
    }

    /**
     * Ambil data siswa yang difilter berdasarkan tahun pelajaran dan kelas.
     */
    public function getFilteredStudents($academicYearString, $classroomName)
    {
        $academicYearId = null;
        $classroomId = null;

        if ($academicYearString) {
            $parts = explode('-', $academicYearString);
            $academicYear = AcademicYear::where('academic_year', $parts[0])
                ->where('semester', $parts[1])
                ->first();

            if ($academicYear) {
                $academicYearId = $academicYear->id;
            }
        }

        if ($classroomName) {
            $classroom = Classroom::where('name', $classroomName)->first();
            if ($classroom) {
                $classroomId = $classroom->id;
            }
        }

        return Student::whereHas('anggotaRombels', function ($query) use ($academicYearId, $classroomId) {
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
                    $anggotaRombel->rombel->academicYear->academic_year ?? '',
                    $anggotaRombel->rombel->classroom->name ?? '',
                ];
            });
    }

    /**
     * Ambil semua data rombel beserta relasi tahun, kelas, dan GTK.
     */
    public function getAllRombels()
    {
        return RombonganBelajar::with(['academicYear', 'classroom', 'gtk'])
            ->select(['id', 'academic_years_id', 'classroom_id', 'gtks_id'])
            ->orderBy('id', 'asc')
            ->get();
    }

    public function store(array $data): RombonganBelajar
    {
        return RombonganBelajar::create([
            'academic_years_id' => $data['tahun_ajaran'],
            'classroom_id' => $data['kelas'],
            'gtks_id' => $data['wali_kelas'],
        ]);
    }

    public function update(RombonganBelajar $rombel, array $data): RombonganBelajar
    {
        $rombel->update([
            'academic_years_id' => $data['tahun_ajaran'],
            'classroom_id' => $data['kelas'],
            'gtks_id' => $data['wali_kelas'],
        ]);

        return $rombel;
    }

    public function delete(RombonganBelajar $rombel): void
    {
        $rombel->delete();
    }

    public function deleteSelected(array $ids): int
    {
        return RombonganBelajar::whereIn('id', $ids)->delete();
    }

    public function getAnggotaRombelData()
    {
        return [
            'judul' => 'Anggota Rombel',
            'data_kelas' => Classroom::all(),
            'tahun_pelajaran' => AcademicYear::all(),
        ];
    }

    public function fetchStudents($request)
    {
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
            ->distinct();

        if ($request->filter === 'unregistered') {
            $query->whereNull('anggota_rombels.id');
        } elseif ($request->filter !== 'all') {
            $query->join('rombongan_belajars', 'anggota_rombels.rombel_id', '=', 'rombongan_belajars.id')
                ->where('rombongan_belajars.classroom_id', $request->classroom_id)
                ->where('rombongan_belajars.academic_years_id', $request->academic_year_id);
        }

        return DataTables::of($query->orderBy('name', 'asc')->get())
            ->addIndexColumn()
            ->make(true);
    }

    public function getFilteredStudentsAjax(Request $request)
    {
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
            'anggota_rombels.id as anggota_rombel_id'
        ])
            ->leftJoin('anggota_rombels', 'students.id', '=', 'anggota_rombels.student_id');

        if (!is_null($request->classroom_id)) {
            $query->join('rombongan_belajars', 'anggota_rombels.rombel_id', '=', 'rombongan_belajars.id')
                ->where('rombongan_belajars.classroom_id', $request->classroom_id);
        }

        if (!is_null($request->academic_year_id)) {
            $query->where('rombongan_belajars.academic_years_id', $request->academic_year_id);
        }

        return DataTables::of($query->orderBy('name', 'asc')->get())
            ->addIndexColumn()
            ->make(true);
    }

    public function getRombelIdByRequest($request)
    {
        $rombel = RombonganBelajar::where('classroom_id', $request->classroom_id)
            ->where('academic_years_id', $request->academic_year_id)
            ->first();

        return $rombel ? $rombel->id : null;
    }
}
