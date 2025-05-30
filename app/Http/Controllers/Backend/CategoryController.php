<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Backend\Post\KategoriServices;

class CategoryController extends Controller
{
    protected $kategoriServices;

    public function __construct(KategoriServices $kategoriServices)
    {
        $this->kategoriServices = $kategoriServices;
    }

    public function index()
    {
        $kategori = $this->kategoriServices->getAllKategori();

        $data = [
            'judul' => "Semua Kategori",
            'kategori' => $kategori,
        ];

        return view('admin.blog.kategori', $data);
    }

    public function getKategori(Request $request)
    {
        if ($request->ajax()) {
            return $this->kategoriServices->getKategoriDatatable($request);
        }
    }

    public function simpanNewPosts(Request $request)
    {
        return $this->kategoriServices->simpanKategori($request);
    }

    public function simpanKategori(Request $request)
    {
        return $this->kategoriServices->simpanKategori($request);
    }

    public function fetchKategoriById($id)
    {
        return response()->json($this->kategoriServices->getKategoriById($id));
    }

    public function update(Request $request, $id)
    {
        return $this->kategoriServices->updateKategori($request, $id);
    }

    public function destroy($id)
    {
        return $this->kategoriServices->deleteKategori($id);
    }
}
