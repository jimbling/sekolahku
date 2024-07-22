<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::all();
        $data = [
            'judul' => "Data Kelas",
            'data_kelas' => $classrooms
        ];

        return view('admin.siswa.all_kelas', $data, compact('classrooms'));
    }

    public function getClassrooms(Request $request)
    {
        if ($request->ajax()) {
            $classrooms = Classroom::select(['id', 'name'])
                ->orderBy('name', 'asc');

            return DataTables::of($classrooms)
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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'classrooms_name' => [
                'required',
                Rule::unique('classrooms', 'name')
            ]
        ], [
            'classrooms_name.required' => 'Nama Kelas harus diisi.',
            'classrooms_name.unique' => 'Nama Kelas sudah ada dalam database.'
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Simpan data ke database
        Classroom::create([
            'name' => $request->input('classrooms_name')
        ]);

        // Jika berhasil disimpan, kirim respons JSON dengan pesan sukses
        return response()->json(['success' => 'Data Kelas berhasil ditambahkan.'], 200);
    }

    public function fetchClassromsById($id)
    {

        $classrooms = Classroom::findOrFail($id);

        return response()->json($classrooms);
    }

    public function destroy($id)
    {
        $classrooms = Classroom::findOrFail($id);

        $classrooms->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Data Kelas berhasil dihapus.'
        ]);
    }

    public function deleteSelectedClassrooms(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                Classroom::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Data Kelas berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada Data Kelas yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'classrooms_name' => 'required'
        ], [
            'classrooms_name.required' => 'Nama Kelas harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }


        $classrooms = Classroom::findOrFail($id);
        $classrooms->name = $request->input('classrooms_name');

        $classrooms->save();
        return response()->json(['message' => 'Data Kelas berhasil diperbarui.']);
    }
}
