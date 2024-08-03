<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\RombonganBelajar;
use App\Models\AnggotaRombel;
use App\Models\Classroom;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::all();
        $data = [
            'judul' => "Data Peserta Didik",
            'peserta_didik' => $students
        ];

        return view('admin.siswa.all_pd', $data, compact('students'));
    }

    public function getStudents(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data siswa dengan status_id = 1
            $students = Student::select(['id', 'name', 'nis', 'birth_place', 'birth_date', 'gender', 'email', 'student_status_id', 'photo', 'end_date', 'reason'])
                ->where('student_status_id', 1) // Tambahkan kondisi filter di sini
                ->orderBy('name', 'asc'); // Urutkan berdasarkan nama secara ascending

            return DataTables::of($students)
                ->addIndexColumn()
                ->editColumn('jenis_kelamin', function ($row) {
                    // Mengubah nilai gender menjadi teks yang lebih deskriptif
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
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'students_name' => 'required|string|max:255',
            'students_no_induk' => 'required|numeric', // Menambahkan validasi numeric untuk nomor induk
            'students_tempat_lahir' => 'required',
            'students_tanggal_lahir' => 'required|date',
            'students_keaktifan' => 'required',
            'students_email' => 'required|email',
            'students_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ], [
            'students_name.required' => 'Nama siswa harus diisi.',
            'students_name.string' => 'Nama siswa harus berupa teks.',
            'students_name.max' => 'Nama siswa tidak boleh lebih dari :max karakter.',
            'students_no_induk.required' => 'Nomor induk siswa harus diisi.',
            'students_no_induk.numeric' => 'Nomor induk siswa harus berupa angka.', // Pesan error untuk validasi numeric
            'students_tempat_lahir.required' => 'Tempat lahir siswa harus diisi.',
            'students_tanggal_lahir.required' => 'Tanggal lahir siswa harus diisi.',
            'students_tanggal_lahir.date' => 'Tanggal lahir siswa harus berupa tanggal yang valid.',
            'students_keaktifan.required' => 'Status keaktifan siswa harus diisi.',
            'students_email.required' => 'Email siswa harus diisi.',
            'students_email.email' => 'Email siswa harus berupa format email yang valid.',
            'students_foto.image' => 'Foto harus berupa file gambar.',
            'students_foto.mimes' => 'Foto harus memiliki format jpg, jpeg, atau png.',
            'students_foto.max' => 'Ukuran foto tidak boleh lebih dari :max kilobita.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Menyimpan file foto jika ada
        $photoPath = null;
        if ($request->hasFile('students_foto')) {
            $photo = $request->file('students_foto');
            $photoPath = $photo->store('images/students', 'public');
        }

        // Simpan data ke database
        Student::create([
            'name' => $request->input('students_name'),
            'nis' => $request->input('students_no_induk'),
            'birth_place' => $request->input('students_tempat_lahir'),
            'birth_date' => $request->input('students_tanggal_lahir'),
            'gender' => $request->input('students_jk'),
            'email' => $request->input('students_email'),
            'student_status_id' => $request->input('students_keaktifan'),
            'photo' => $photoPath,
        ]);

        // Redirect atau kembali dengan pesan sukses
        return response()->json(['success' => 'Data Peserta Didik berhasil ditambahkan.'], 200);
    }

    public function fetchStudentsById($id)
    {
        // Ambil data kategori berdasarkan ID
        $students = Student::findOrFail($id);

        // Kirim data kategori dalam format JSON
        return response()->json($students);
    }

    public function destroy($id)
    {
        $students = Student::findOrFail($id);

        // Hapus kategori
        $students->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Peserta Didik berhasil dihapus.'
        ]);
    }

    public function deleteSelectedStudents(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                Student::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Peserta Didik berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada Peserta Didik yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'students_name' => 'required|string|max:255',
            'students_no_induk' => 'required|numeric', // Menambahkan validasi numeric untuk nomor induk
            'students_tempat_lahir' => 'required',
            'students_tanggal_lahir' => 'required|date',
            'students_keaktifan' => 'required',
            'students_email' => 'required|email',
            'students_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ], [
            'students_name.required' => 'Nama siswa harus diisi.',
            'students_name.string' => 'Nama siswa harus berupa teks.',
            'students_name.max' => 'Nama siswa tidak boleh lebih dari :max karakter.',
            'students_no_induk.required' => 'Nomor induk siswa harus diisi.',
            'students_no_induk.numeric' => 'Nomor induk siswa harus berupa angka.', // Pesan error untuk validasi numeric
            'students_tempat_lahir.required' => 'Tempat lahir siswa harus diisi.',
            'students_tanggal_lahir.required' => 'Tanggal lahir siswa harus diisi.',
            'students_tanggal_lahir.date' => 'Tanggal lahir siswa harus berupa tanggal yang valid.',
            'students_keaktifan.required' => 'Status keaktifan siswa harus diisi.',
            'students_email.required' => 'Email siswa harus diisi.',
            'students_email.email' => 'Email siswa harus berupa format email yang valid.',
            'students_foto.image' => 'Foto harus berupa file gambar.',
            'students_foto.mimes' => 'Foto harus memiliki format jpg, jpeg, atau png.',
            'students_foto.max' => 'Ukuran foto tidak boleh lebih dari :max kilobita.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Temukan data GTK berdasarkan ID
        $students = Student::findOrFail($id);

        // Perbarui data GTK dengan nilai yang diterima dari permintaan
        $students->name = $request->input('students_name');
        $students->nis = $request->input('students_no_induk');
        $students->gender = $request->input('students_jk');
        $students->birth_place = $request->input('students_tempat_lahir');
        $students->birth_date = $request->input('students_tanggal_lahir');
        $students->email = $request->input('students_email');
        $students->student_status_id = $request->input('students_keaktifan');


        // Menyimpan file foto jika ada
        if ($request->hasFile('students_foto')) {
            // Hapus foto lama jika ada
            if ($students->photo && file_exists(storage_path('app/public/' . $students->photo))) {
                unlink(storage_path('app/public/' . $students->photo));
            }

            // Simpan foto baru
            $photo = $request->file('students_foto');
            $photoPath = $photo->store('images/students', 'public');
            $students->photo = $photoPath;
        }

        // Simpan perubahan
        $students->save();

        // Kirim respons sukses
        return response()->json(['message' => 'Data GTK berhasil diperbarui.']);
    }

    /////////////////////////////////////////////////////////////////////////////
    // ALUMNI - PESERTA DIDIK NON AKTIF
    public function studentsNonActive()
    {
        $students = Student::all();
        $data = [
            'judul' => "Data Peserta Didik Non Aktif",
            'peserta_didik' => $students
        ];

        return view('admin.siswa.pd_non_active', $data, compact('students'));
    }

    public function getStudentsNonActive(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data siswa dengan status_id = 0
            $students = Student::select(['id', 'name', 'nis', 'birth_place', 'birth_date', 'gender', 'email', 'student_status_id', 'photo', 'end_date', 'reason', 'is_alumni'])
                ->where('student_status_id', 0) // Tambahkan kondisi filter di sini
                ->orderBy('name', 'asc'); // Urutkan berdasarkan nama secara ascending

            return DataTables::of($students)
                ->addIndexColumn()
                ->editColumn('jenis_kelamin', function ($row) {
                    // Mengubah nilai gender menjadi teks yang lebih deskriptif
                    return $row->gender === 'M' ? 'Laki-Laki' : ($row->gender === 'F' ? 'Perempuan' : 'Tidak Diketahui');
                })
                ->editColumn('is_alumni', function ($row) {
                    // Mengubah nilai is_alumni menjadi teks yang lebih deskriptif
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
    }

    public function markAsAlumni(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:students,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $ids = $request->input('ids');

        // Update siswa yang dipilih
        Student::whereIn('id', $ids)->update([
            'end_date' => now(),
            'is_alumni' => true,
            'reason' => 'Lulus',
            'student_status_id' => 0 // Mengubah status siswa menjadi tidak aktif
        ]);

        return response()->json(['success' => true]);
    }

    public function restoreAlumni(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            if (!empty($ids)) {
                // Update data berdasarkan ID yang dipilih
                Student::whereIn('id', $ids)->update([
                    'student_status_id' => 1,
                    'end_date' => null,
                    'is_alumni' => false,
                    'reason' => null,
                ]);

                return response()->json([
                    'type' => 'success',
                    'message' => 'Peserta Didik berhasil dikembalikan menjadi Aktif.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada Peserta Didik yang dipilih untuk diperbarui.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }

    public function storeAlumni(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'alumni_nama' => 'required|string|max:255',
            'alumni_tempat_lahir' => 'required|string|max:255',
            'alumni_tanggal_lahir' => 'required|date',
            'alumni_email' => 'required|email',
            'alumni_tahun_lulus' => 'required|numeric',
            'alumni_phone' => 'required|numeric',
            'alumni_jk' => 'required|string|in:M,F',
            'alumni_alamat' => 'required|string|max:500',
            'alumni_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ], [
            'alumni_nama.required' => 'Nama alumni harus diisi.',
            'alumni_nama.string' => 'Nama alumni harus berupa teks.',
            'alumni_nama.max' => 'Nama alumni tidak boleh lebih dari :max karakter.',
            'alumni_tempat_lahir.required' => 'Tempat lahir alumni harus diisi.',
            'alumni_tempat_lahir.string' => 'Tempat lahir alumni harus berupa teks.',
            'alumni_tempat_lahir.max' => 'Tempat lahir alumni tidak boleh lebih dari :max karakter.',
            'alumni_tanggal_lahir.required' => 'Tanggal lahir alumni harus diisi.',
            'alumni_tanggal_lahir.date' => 'Tanggal lahir alumni harus berupa tanggal yang valid.',
            'alumni_email.required' => 'Email alumni harus diisi.',
            'alumni_email.email' => 'Email alumni harus berupa format email yang valid.',
            'alumni_tahun_lulus.required' => 'Tahun Lulus alumni harus diisi.',
            'alumni_tahun_lulus.numeric' => 'Tahun Lulus alumni harus berupa angka.',
            'alumni_phone.required' => 'No HP alumni harus diisi.',
            'alumni_phone.numeric' => 'No HP alumni harus berupa angka.',
            'alumni_jk.required' => 'Jenis kelamin harus diisi.',
            'alumni_jk.string' => 'Jenis kelamin harus berupa teks.',
            'alumni_jk.in' => 'Jenis kelamin harus salah satu dari M atau F.',
            'alumni_alamat.required' => 'Alamat alumni harus diisi.',
            'alumni_alamat.string' => 'Alamat alumni harus berupa teks.',
            'alumni_alamat.max' => 'Alamat alumni tidak boleh lebih dari :max karakter.',
            'alumni_foto.image' => 'Foto harus berupa file gambar.',
            'alumni_foto.mimes' => 'Foto harus memiliki format jpg, jpeg, atau png.',
            'alumni_foto.max' => 'Ukuran foto tidak boleh lebih dari :max kilobyte.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }



        // Menentukan nomor induk berikutnya
        $lastStudent = Student::latest('created_at')->first();
        $nextId = 1;

        if ($lastStudent) {
            // Mengambil nomor terakhir dan menambahkannya
            $lastId = (int) str_replace('alumni_', '', $lastStudent->nis);
            $nextId = $lastId + 1;
        }

        $no_induk = 'alumni_' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Pastikan tidak ada duplikat nomor induk
        while (Student::where('nis', $no_induk)->exists()) {
            $nextId++;
            $no_induk = 'alumni_' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        }

        $no_induk = 'alumni_' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        // Menyimpan file foto jika ada
        $photoPath = null;
        if ($request->hasFile('alumni_foto')) {
            $photo = $request->file('alumni_foto');
            $photoPath = $photo->store('images/alumni', 'public');
        }

        // Simpan data ke database
        Student::create([
            'name' => $request->input('alumni_nama'),
            'nis' => $no_induk,
            'birth_place' => $request->input('alumni_tempat_lahir'),
            'birth_date' => $request->input('alumni_tanggal_lahir'),
            'gender' => $request->input('alumni_jk'),
            'email' => $request->input('alumni_email'),
            'alamat' => $request->input('alumni_alamat'),
            'no_hp' => $request->input('alumni_phone'),
            'tahun_lulus' => $request->input('alumni_tahun_lulus'),
            'photo' => $photoPath,
            'end_date' => now(),
            'is_alumni' => true,
            'reason' => 'Lulus',
            'student_status_id' => 0
        ]);

        // Redirect atau kembali dengan pesan sukses
        return redirect()->route('web.pd.non.active')
            ->with('success', 'Data alumni berhasil ditambahkan.');
    }
}
