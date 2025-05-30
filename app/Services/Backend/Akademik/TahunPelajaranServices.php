<?php

namespace App\Services\Backend\Akademik;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TahunPelajaranServices
{
    public function all()
    {
        return AcademicYear::all();
    }

    public function datatable()
    {
        return AcademicYear::select(['id', 'academic_year', 'semester', 'current_semester'])
            ->orderBy('academic_year', 'asc');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_ajarans_name' => ['required', Rule::unique('academic_years', 'academic_year')],
            'tahun_ajarans_semester' => ['required'],
            'tahun_ajarans_is_active' => ['required', 'integer', 'in:0,1']
        ], [
            'tahun_ajarans_name.required' => 'Tahun Ajaran harus diisi.',
            'tahun_ajarans_name.unique' => 'Tahun Ajaran sudah ada dalam database.',
            'tahun_ajarans_semester.required' => 'Semester harus diisi.',
            'tahun_ajarans_is_active.required' => 'Status Semester harus diisi.',
            'tahun_ajarans_is_active.integer' => 'Status Semester harus berupa angka.',
            'tahun_ajarans_is_active.in' => 'Status Semester harus 0 (Tidak Aktif) atau 1 (Aktif).'
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all(), 'status' => 422];
        }

        AcademicYear::create([
            'academic_year' => $request->input('tahun_ajarans_name'),
            'semester' => $request->input('tahun_ajarans_semester'),
            'current_semester' => $request->input('tahun_ajarans_is_active')
        ]);

        return ['message' => 'Data Tahun Ajaran berhasil ditambahkan.', 'status' => 200];
    }

    public function getById($id)
    {
        return AcademicYear::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tahun_ajarans_name' => ['required'],
            'tahun_ajarans_semester' => ['required'],
            'tahun_ajarans_is_active' => ['required', 'integer', 'in:0,1']
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all(), 'status' => 422];
        }

        $tahun_ajaran = AcademicYear::findOrFail($id);
        $tahun_ajaran->update([
            'academic_year' => $request->input('tahun_ajarans_name'),
            'semester' => $request->input('tahun_ajarans_semester'),
            'current_semester' => $request->input('tahun_ajarans_is_active')
        ]);

        return ['message' => 'Data Tahun Pelajaran berhasil diperbarui.', 'status' => 200];
    }

    public function delete($id)
    {
        $tahun_ajaran = AcademicYear::findOrFail($id);
        $tahun_ajaran->delete();

        return ['message' => 'Data Tahun Ajaran berhasil dihapus.', 'status' => 200];
    }

    public function deleteSelected(array $ids)
    {
        if (!empty($ids)) {
            AcademicYear::whereIn('id', $ids)->delete();
            return ['message' => 'Data Tahun Ajaran berhasil dihapus.', 'status' => 200];
        }
        return ['message' => 'Tidak ada Data Tahun Ajaran yang dipilih.', 'status' => 422];
    }
}
