<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gtk;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GtkController extends Controller
{
    public function index()
    {
        $gtks = Gtk::all();
        $data = [
            'judul' => "Data GTK",
            'tags' => $gtks
        ];

        return view('admin.gtk.all_gtk', $data, compact('gtks'));
    }

    public function getGtk(Request $request)
    {
        if ($request->ajax()) {
            $gtks = Gtk::select(['id', 'full_name', 'gender', 'parent_school_status', 'gtk_status', 'email', 'photo'])
                ->orderBy('full_name', 'asc'); // Urutkan berdasarkan full_name secara ascending

            return DataTables::of($gtks)
                ->addIndexColumn()
                ->editColumn('gender', function ($row) {
                    // Mengubah nilai gender menjadi teks yang lebih deskriptif
                    return $row->gender === 'M' ? 'Laki-Laki' : ($row->gender === 'F' ? 'Perempuan' : 'Tidak Diketahui');
                })
                ->editColumn('parent_school_status', function ($row) {
                    return $row->parent_school_status === 1 ? 'INDUK' : 'NON INDUK';
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
            'gtk_name' => 'required|string|max:255',
            'gtk_jk' => 'required|in:M,F',
            'gtk_status_induk' => 'required|boolean',
            'gtk_keaktifan' => 'required|string|max:255',
            'gtk_email' => 'required|email|unique:gtks,email',
            'gtk_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ], [
            'gtk_name.required' => 'Nama GTK harus diisi.',
            'gtk_name.string' => 'Nama GTK harus berupa string.',
            'gtk_name.max' => 'Nama GTK tidak boleh lebih dari :max karakter.',
            'gtk_jk.required' => 'Jenis kelamin harus dipilih.',
            'gtk_jk.in' => 'Jenis kelamin harus salah satu dari M atau F.',
            'gtk_status_induk.required' => 'Status induk harus diisi.',
            'gtk_status_induk.boolean' => 'Status induk harus Ya atau Tidak.',
            'gtk_keaktifan.required' => 'Status GTK harus diisi.',
            'gtk_keaktifan.string' => 'Status GTK harus berupa string.',
            'gtk_keaktifan.max' => 'Status GTK tidak boleh lebih dari :max karakter.',
            'gtk_email.required' => 'Email GTK harus diisi.',
            'gtk_email.email' => 'Format email tidak valid.',
            'gtk_email.unique' => 'Email GTK sudah digunakan.',
            'gtk_foto.image' => 'Foto harus berupa gambar.',
            'gtk_foto.mimes' => 'Gambar harus memiliki ekstensi jpg, jpeg, atau png.',
            'gtk_foto.max' => 'Ukuran gambar tidak boleh lebih dari 500KB.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Menyimpan file foto jika ada
        $photoPath = null;
        if ($request->hasFile('gtk_foto')) {
            $photo = $request->file('gtk_foto');
            $photoPath = $photo->store('images/gtks', 'public');
        }

        // Simpan data ke database
        Gtk::create([
            'full_name' => $request->input('gtk_name'),
            'gender' => $request->input('gtk_jk'),
            'parent_school_status' => $request->input('gtk_status_induk'),
            'gtk_status' => $request->input('gtk_keaktifan'),
            'email' => $request->input('gtk_email'),
            'photo' => $photoPath,
        ]);

        // Redirect atau kembali dengan pesan sukses
        return response()->json(['success' => 'Data GTK berhasil ditambahkan.'], 200);
    }

    public function fetchGtkById($id)
    {
        // Ambil data kategori berdasarkan ID
        $gtks = Gtk::findOrFail($id);

        // Kirim data kategori dalam format JSON
        return response()->json($gtks);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'gtk_name' => 'required|string|max:255',
            'gtk_jk' => 'required|in:M,F',
            'gtk_status_induk' => 'required|boolean',
            'gtk_keaktifan' => 'required|string|max:255',
            'gtk_email' => 'required|email|unique:gtks,email,' . $id, // Menambahkan ID untuk pengecualian pada email
            'gtk_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:500', // Validasi gambar
        ], [
            'gtk_name.required' => 'Nama GTK harus diisi.',
            'gtk_name.string' => 'Nama GTK harus berupa string.',
            'gtk_name.max' => 'Nama GTK tidak boleh lebih dari :max karakter.',
            'gtk_jk.required' => 'Jenis kelamin harus dipilih.',
            'gtk_jk.in' => 'Jenis kelamin harus salah satu dari M atau F.',
            'gtk_status_induk.required' => 'Status induk harus diisi.',
            'gtk_status_induk.boolean' => 'Status induk harus Ya atau Tidak.',
            'gtk_keaktifan.required' => 'Status GTK harus diisi.',
            'gtk_keaktifan.string' => 'Status GTK harus berupa string.',
            'gtk_keaktifan.max' => 'Status GTK tidak boleh lebih dari :max karakter.',
            'gtk_email.required' => 'Email GTK harus diisi.',
            'gtk_email.email' => 'Format email tidak valid.',
            'gtk_email.unique' => 'Email GTK sudah digunakan.',
            'gtk_foto.image' => 'Foto harus berupa gambar.',
            'gtk_foto.mimes' => 'Gambar harus memiliki ekstensi jpg, jpeg, atau png.',
            'gtk_foto.max' => 'Ukuran gambar tidak boleh lebih dari 500KB.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Temukan data GTK berdasarkan ID
        $gtk = Gtk::findOrFail($id);

        // Perbarui data GTK dengan nilai yang diterima dari permintaan
        $gtk->full_name = $request->input('gtk_name');
        $gtk->gender = $request->input('gtk_jk');
        $gtk->parent_school_status = $request->input('gtk_status_induk');
        $gtk->gtk_status = $request->input('gtk_keaktifan');
        $gtk->email = $request->input('gtk_email');

        // Menyimpan file foto jika ada
        if ($request->hasFile('gtk_foto')) {
            // Hapus foto lama jika ada
            if ($gtk->photo && file_exists(storage_path('app/public/' . $gtk->photo))) {
                unlink(storage_path('app/public/' . $gtk->photo));
            }

            // Simpan foto baru
            $photo = $request->file('gtk_foto');
            $photoPath = $photo->store('images/gtks', 'public');
            $gtk->photo = $photoPath;
        }

        // Simpan perubahan
        $gtk->save();

        // Kirim respons sukses
        return response()->json(['message' => 'Data GTK berhasil diperbarui.']);
    }


    public function destroy($id)
    {
        $gtks = Gtk::findOrFail($id);

        // Hapus kategori
        $gtks->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'GTK berhasil dihapus.'
        ]);
    }

    public function deleteSelectedTags(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            // Lakukan validasi atau operasi penghapusan di sini
            // Contoh validasi: pastikan id yang dikirim adalah array dan bukan kosong

            if (!empty($ids)) {
                Gtk::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'GTK berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada GTK yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }
}
