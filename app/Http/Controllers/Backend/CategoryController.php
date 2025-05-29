<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class CategoryController extends Controller
{

    public function index()
    {
        // Mengambil semua posting
        $kategori = Category::all();

        // Menyiapkan data untuk ditampilkan di tampilan
        $data = [
            'judul' => "Semua Kategori",
            'kategori' => $kategori,
        ];

        // Mengembalikan tampilan dengan data yang disiapkan
        return view('admin.blog.kategori', $data);
    }

    public function getKategori(Request $request)
    {
        if ($request->ajax()) {
            $kategori = Category::select(['id', 'name', 'keterangan', 'created_at', 'updated_at'])
                ->where('category_type', 'post'); // Filter hanya kategori dengan category_type = 'post'

            return DataTables::of($kategori)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '

                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Menyimpan kategori dari Tambah Tulisan
    public function simpanNewPosts(Request $request)
    {
        // Validasi tambahan untuk memastikan nama kategori unik
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:categories,name',
            'category_keterangan' => 'nullable|string|max:255',
        ], [
            'category_name.required' => 'Nama kategori harus diisi.',
            'category_name.unique' => 'Nama kategori sudah ada, silakan masukkan yang lain.',
            'category_keterangan.max' => 'Keterangan kategori maksimal :max karakter.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        Category::create([
            'name' => $request->category_name,
            'keterangan' => $request->category_keterangan,
        ]);

        // Tambahkan pesan flash untuk ditampilkan menggunakan Toastr
        return response()->json(['message' => 'Kategori berhasil ditambahkan.'], 200);
    }

    public function simpanKategori(Request $request)
    {
        // Validasi tambahan untuk memastikan nama kategori unik
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:categories,name',
            'category_keterangan' => 'nullable|string|max:255',
        ], [
            'category_name.required' => 'Nama kategori harus diisi.',
            'category_name.unique' => 'Nama kategori sudah ada, silakan masukkan yang lain.',
            'category_keterangan.max' => 'Keterangan kategori maksimal :max karakter.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        Category::create([
            'name' => $request->category_name,
            'keterangan' => $request->category_keterangan,
        ]);

        // Tambahkan pesan flash untuk ditampilkan menggunakan Toastr
        return response()->json(['message' => 'Kategori berhasil ditambahkan.'], 200);
    }

    public function fetchKategoriById($id)
    {
        // Ambil data kategori berdasarkan ID
        $kategori = Category::findOrFail($id);

        // Kirim data kategori dalam format JSON
        return response()->json($kategori);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Update data kategori berdasarkan ID
        $kategori = Category::findOrFail($id);
        $kategori->name = $request->name;
        $kategori->keterangan = $request->keterangan;
        $kategori->save();

        // Kirim respons sukses
        return response()->json(['message' => 'Kategori berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Hapus kategori
        $category->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Kategori berhasil dihapus.'
        ]);
    }
}
