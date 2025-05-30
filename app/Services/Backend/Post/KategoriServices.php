<?php

namespace App\Services\Backend\Post;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class KategoriServices
{
    public function getAllKategori()
    {
        return Category::all();
    }

    public function getKategoriDatatable(Request $request)
    {
        $kategori = Category::select(['id', 'name', 'keterangan', 'created_at', 'updated_at'])
            ->where('category_type', 'post');

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function simpanKategori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:categories,name',
            'category_keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        Category::create([
            'name' => $request->category_name,
            'keterangan' => $request->category_keterangan,
        ]);

        return response()->json(['message' => 'Kategori berhasil ditambahkan.']);
    }

    public function getKategoriById($id)
    {
        return Category::findOrFail($id);
    }

    public function updateKategori(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $kategori = Category::findOrFail($id);
        $kategori->update([
            'name' => $request->name,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json(['message' => 'Kategori berhasil diperbarui.']);
    }

    public function deleteKategori($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Kategori berhasil dihapus.'
        ]);
    }
}
