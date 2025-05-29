<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\Validator; // Import Validator facade
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
    // Menampilkan daftar tags
    public function index()
    {
        $tags = Tag::all();
        $data = [
            'judul' => "All Tags",
            'tags' => $tags
        ];

        return view('admin.blog.tags', $data, compact('tags'));
    }

    public function getTags(Request $request)
    {
        if ($request->ajax()) {
            $tags = Tag::select(['id', 'name', 'slug',]);
            return DataTables::of($tags)
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

    public function simpanTags(Request $request)
    {
        // Validasi tambahan untuk memastikan nama tag unik
        $validator = Validator::make($request->all(), [
            'tag_name' => 'required|string|max:255|unique:tags,name', // Ubah categories ke tags
        ], [
            'tag_name.required' => 'Nama tag harus diisi.',
            'tag_name.unique' => 'Tag dengan nama ini sudah ada.', // Pesan error jika nama sudah digunakan
        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Buat slug dari nama tag
        $slug = Str::slug($request->tag_name, '-');

        // Simpan tag ke database
        Tag::create([
            'name' => $request->tag_name,
            'slug' => $slug, // Simpan slug yang dibuat
        ]);

        // Mengembalikan respon JSON dengan pesan sukses
        return response()->json(['message' => 'Tag berhasil ditambahkan.'], 200);
    }

    // Menyimpan tag baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags,name|max:255',
        ]);

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name, '-');
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit tag
    public function edit(Tag $tag)
    {
        return view('backend.tags.edit', compact('tag'));
    }

    // Memperbarui tag yang ada di database
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|max:255|unique:tags,name,' . $tag->id,
        ]);

        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name, '-');
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag berhasil diperbarui.');
    }



    public function destroy($id)
    {
        $tags = Tag::findOrFail($id);

        // Hapus kategori
        $tags->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Tag berhasil dihapus.'
        ]);
    }

    public function deleteSelectedTags(Request $request)
    {
        if ($request->ajax()) {
            $ids = $request->ids;

            // Lakukan validasi atau operasi penghapusan di sini
            // Contoh validasi: pastikan id yang dikirim adalah array dan bukan kosong

            if (!empty($ids)) {
                Tag::whereIn('id', $ids)->delete();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Tags berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Tidak ada tags yang dipilih untuk dihapus.'
                ], 422); // 422 untuk Unprocessable Entity status
            }
        }
    }
}
