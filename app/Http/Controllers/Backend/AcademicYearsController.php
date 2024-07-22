<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AcademicYearsController extends Controller
{
    public function index()
    {
        $tahun_ajarans = AcademicYear::all();
        $data = [
            'judul' => "Data Tahun Pelajaran",
            'tags' => $tahun_ajarans
        ];

        return view('admin.akademik.all_tahun_ajaran', $data, compact('tahun_ajarans'));
    }

    public function getAcademicYears(Request $request)
    {
        if ($request->ajax()) {
            $tahun_ajarans = AcademicYear::select(['id', 'academic_year', 'semester', 'current_semester'])
                ->orderBy('academic_year', 'asc');

            return DataTables::of($tahun_ajarans)
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
            'tahun_ajarans_name' => [
                'required',
                Rule::unique('academic_years', 'academic_year')
            ],
            'tahun_ajarans_semester' => [
                'required',

            ],
            'tahun_ajarans_is_active' => [
                'required',
                'integer', // Validasi agar current_semester berupa angka
                'in:0,1'   // Validasi agar hanya bisa 0 atau 1
            ]
        ], [
            'tahun_ajarans_name.required' => 'Tahun Ajaran harus diisi.',
            'tahun_ajarans_name.unique' => 'Tahun Ajaran sudah ada dalam database.',
            'tahun_ajarans_semester.required' => 'Semester harus diisi.',
            'tahun_ajarans_is_active.required' => 'Status Semester harus diisi.',
            'tahun_ajarans_is_active.integer' => 'Status Semester harus berupa angka.',
            'tahun_ajarans_is_active.in' => 'Status Semester harus 0 (Tidak Aktif) atau 1 (Aktif).'
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Simpan data ke database
        AcademicYear::create([
            'academic_year' => $request->input('tahun_ajarans_name'),
            'semester' => $request->input('tahun_ajarans_semester'),
            'current_semester' => $request->input('tahun_ajarans_is_active')
        ]);

        // Jika berhasil disimpan, kirim respons JSON dengan pesan sukses
        return response()->json(['success' => 'Data Tahun Ajaran berhasil ditambahkan.'], 200);
    }


    public function fetchAcademicYearsById($id)
    {

        $tahun_ajarans = AcademicYear::findOrFail($id);

        return response()->json($tahun_ajarans);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'tahun_ajarans_name' => [
                'required',

            ],
            'tahun_ajarans_semester' => [
                'required',

            ],
            'tahun_ajarans_is_active' => [
                'required',
                'integer', // Validasi agar current_semester berupa angka
                'in:0,1'   // Validasi agar hanya bisa 0 atau 1
            ]
        ], [
            'tahun_ajarans_name.required' => 'Tahun Ajaran harus diisi.',
            'tahun_ajarans_semester.required' => 'Semester harus diisi.',
            'tahun_ajarans_is_active.required' => 'Status Semester harus diisi.',
            'tahun_ajarans_is_active.integer' => 'Status Semester harus berupa angka.',
            'tahun_ajarans_is_active.in' => 'Status Semester harus 0 (Tidak Aktif) atau 1 (Aktif).'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $tahun_ajarans = AcademicYear::findOrFail($id);
        $tahun_ajarans->academic_year = $request->input('tahun_ajarans_name');
        $tahun_ajarans->semester = $request->input('tahun_ajarans_semester');
        $tahun_ajarans->current_semester = $request->input('tahun_ajarans_is_active');

        $tahun_ajarans->save();


        return response()->json(['message' => 'Data Tahun Pelajaran berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $tahun_ajarans = AcademicYear::findOrFail($id);

        $tahun_ajarans->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Data Tahun Ajaran berhasil dihapus.'
        ]);
    }

    public function deleteSelectedAcademicYears(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                AcademicYear::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Data Tahun Ajaran berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada Data Tahun Ajaran yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }
}
