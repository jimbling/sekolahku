<?php

namespace App\Services\Backend\Akademik;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KelasServices
{
    public function getAll()
    {
        return Classroom::all();
    }

    public function getDatatables()
    {
        return Classroom::select(['id', 'name'])->orderBy('name', 'asc');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classrooms_name' => ['required', Rule::unique('classrooms', 'name')]
        ], [
            'classrooms_name.required' => 'Nama Kelas harus diisi.',
            'classrooms_name.unique' => 'Nama Kelas sudah ada dalam database.'
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }

        Classroom::create(['name' => $request->input('classrooms_name')]);
        return ['success' => 'Data Kelas berhasil ditambahkan.'];
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'classrooms_name' => 'required'
        ], [
            'classrooms_name.required' => 'Nama Kelas harus diisi.',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }

        $kelas = Classroom::findOrFail($id);
        $kelas->name = $request->input('classrooms_name');
        $kelas->save();

        return ['message' => 'Data Kelas berhasil diperbarui.'];
    }

    public function delete($id)
    {
        $kelas = Classroom::findOrFail($id);
        $kelas->delete();

        return ['type' => 'success', 'message' => 'Data Kelas berhasil dihapus.'];
    }

    public function deleteBulk(array $ids)
    {
        if (!empty($ids)) {
            Classroom::whereIn('id', $ids)->delete();
            return ['type' => 'success', 'message' => 'Data Kelas berhasil dihapus.'];
        }

        return ['type' => 'error', 'message' => 'Tidak ada Data Kelas yang dipilih untuk dihapus.'];
    }

    public function findById($id)
    {
        return Classroom::findOrFail($id);
    }
}
